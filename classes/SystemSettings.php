<?php
if (!class_exists('DBConnection')) {
	require_once('../config.php');
	require_once('DBConnection.php');
}
class SystemSettings extends DBConnection
{
	public function __construct()
	{
		parent::__construct();
	}
	function check_connection()
	{
		return ($this->conn);
	}
	function load_system_info()
	{
		// if(!isset($_SESSION['system_info'])){
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
		while ($row = $qry->fetch_assoc()) {
			$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
		}
		// }
	}
	function update_system_info()
	{
		$sql = "SELECT * FROM system_info";
		$qry = $this->conn->query($sql);
		while ($row = $qry->fetch_assoc()) {
			if (isset($_SESSION['system_info'][$row['meta_field']]))
				unset($_SESSION['system_info'][$row['meta_field']]);
			$_SESSION['system_info'][$row['meta_field']] = $row['meta_value'];
		}
		return true;
	}
	function update_settings_info()
	{
		// save key-value meta (except content blocks)
		foreach ($_POST as $key => $value) {
			if (!in_array($key, array("content"))) {
				$value = str_replace("'", "&apos;", $value);
				if (isset($_SESSION['system_info'][$key])) {
					$this->conn->query("UPDATE system_info SET meta_value = '{$value}' WHERE meta_field = '{$key}' ");
				} else {
					$this->conn->query("INSERT INTO system_info SET meta_value = '{$value}', meta_field = '{$key}' ");
				}
			}
		}

		// save content blocks to files
		if (isset($_POST['content'])) {
			foreach ($_POST['content'] as $k => $v) {
				file_put_contents("../{$k}.html", $v);
			}
		}

		$resp = ['msg' => "System Info Successfully Updated."];

		// ensure uploads dir exists
		$uploadsDir = rtrim(base_app, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'uploads';
		if (!is_dir($uploadsDir)) {
			@mkdir($uploadsDir, 0775, true);
		}

		// helper: handle an image upload + optional resize
		$processImage = function ($fileField, $targetMetaField, $targetW, $targetH) use (&$resp, $uploadsDir) {
			if (!isset($_FILES[$fileField]) || empty($_FILES[$fileField]['tmp_name']))
				return null;

			$tmp = $_FILES[$fileField]['tmp_name'];

			// Validate MIME & dimensions
			$mime = 'application/octet-stream';
			if (function_exists('finfo_open')) {
				$f = finfo_open(FILEINFO_MIME_TYPE);
				if ($f) {
					$mime = finfo_file($f, $tmp);
					finfo_close($f);
				}
			} elseif (function_exists('mime_content_type')) {
				$mime = mime_content_type($tmp);
			}
			$allowed = ['image/png', 'image/jpeg'];
			if (!in_array($mime, $allowed)) {
				$resp['msg'] .= " But {$fileField} failed to upload due to invalid file type.";
				return null;
			}

			$imgInfo = @getimagesize($tmp);
			if (!$imgInfo) {
				$resp['msg'] .= " But {$fileField} failed to upload (unreadable image).";
				return null;
			}
			list($origW, $origH) = $imgInfo;

			// pick extension and build final path
			$ext = ($mime === 'image/png') ? 'png' : 'jpg';
			$relName = "uploads/{$targetMetaField}-" . time() . ".{$ext}";
			$absPath = rtrim(base_app, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $relName;

			$uploaded = false;

			// If GD available, resize; else, move as-is
			if (extension_loaded('gd') && function_exists('imagecreatetruecolor')) {
				$dst = imagecreatetruecolor($targetW, $targetH);
				// keep alpha for PNG
				if ($ext === 'png') {
					imagealphablending($dst, false);
					imagesavealpha($dst, true);
				}

				$src = ($ext === 'png')
					? @imagecreatefrompng($tmp)
					: @imagecreatefromjpeg($tmp);

				if ($src) {
					imagecopyresampled($dst, $src, 0, 0, 0, 0, $targetW, $targetH, $origW, $origH);
					// overwrite if exists
					if (is_file($absPath))
						@unlink($absPath);
					$uploaded = ($ext === 'png')
						? imagepng($dst, $absPath)
						: imagejpeg($dst, $absPath, 90);
					imagedestroy($src);
					imagedestroy($dst);
				} else {
					$resp['msg'] .= " But {$fileField} failed to upload (decoder issue).";
				}
			} else {
				// Fallback: no GD → save original without resizing
				// Use .png extension if png, else .jpg
				if (is_file($absPath))
					@unlink($absPath);
				$uploaded = @move_uploaded_file($tmp, $absPath);
				if (!$uploaded) {
					$resp['msg'] .= " But {$fileField} failed to upload (move failed).";
				} else {
					$resp['msg'] .= " (Saved without resizing: GD not enabled.)";
				}
			}

			if ($uploaded) {
				// Update DB and remove old file if present
				if (isset($_SESSION['system_info'][$targetMetaField])) {
					$this->conn->query("UPDATE system_info SET meta_value = '{$relName}' WHERE meta_field = '{$targetMetaField}' ");
					$old = $_SESSION['system_info'][$targetMetaField];
					if ($old && is_file(rtrim(base_app, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $old)) {
						@unlink(rtrim(base_app, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $old);
					}
				} else {
					$this->conn->query("INSERT INTO system_info SET meta_value = '{$relName}', meta_field = '{$targetMetaField}' ");
				}
				return $relName;
			}
			return null;
		};

		// process logo (200x200)
		$processImage('img', 'logo', 200, 200);
		// process cover (1280x720)
		$processImage('cover', 'cover', 1280, 720);

		// refresh session cache + flash
		$update = $this->update_system_info();
		$flash = $this->set_flashdata('success', $resp['msg']);
		if ($update && $flash) {
			return true;
		}
	}

	function set_userdata($field = '', $value = '')
	{
		if (!empty($field) && !empty($value)) {
			$_SESSION['userdata'][$field] = $value;
		}
	}
	function userdata($field = '')
	{
		if (!empty($field)) {
			if (isset($_SESSION['userdata'][$field]))
				return $_SESSION['userdata'][$field];
			else
				return null;
		} else {
			return false;
		}
	}
	function set_flashdata($flash = '', $value = '')
	{
		if (!empty($flash) && !empty($value)) {
			$_SESSION['flashdata'][$flash] = $value;
			return true;
		}
	}
	function chk_flashdata($flash = '')
	{
		if (isset($_SESSION['flashdata'][$flash])) {
			return true;
		} else {
			return false;
		}
	}
	function flashdata($flash = '')
	{
		if (!empty($flash)) {
			$_tmp = $_SESSION['flashdata'][$flash];
			unset($_SESSION['flashdata']);
			return $_tmp;
		} else {
			return false;
		}
	}
	function sess_des()
	{
		if (isset($_SESSION['userdata'])) {
			unset($_SESSION['userdata']);
			return true;
		}
		return true;
	}
	function info($field = '')
	{
		if (!empty($field)) {
			if (isset($_SESSION['system_info'][$field]))
				return $_SESSION['system_info'][$field];
			else
				return false;
		} else {
			return false;
		}
	}
	function set_info($field = '', $value = '')
	{
		if (!empty($field) && !empty($value)) {
			$_SESSION['system_info'][$field] = $value;
		}
	}
}
$_settings = new SystemSettings();
$_settings->load_system_info();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'update_settings':
		echo $sysset->update_settings_info();
		break;
	default:
		// echo $sysset->index();
		break;
}
?>