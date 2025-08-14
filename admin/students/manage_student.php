<?php
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `student_list` where id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }
}
?>
<div class="content py-3">
    <div class="card card-outline card-primary shadow rounded-0">
        <div class="card-header">
            <h3 class="card-title"><b><?= isset($id) ? "Update Student Details - " . $roll : "New Student" ?></b></h3>
        </div>
        <div class="card-body">
            <div class="container-fluid">
                <form action="" id="student_form" novalidate>
                    <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">

                    <fieldset class="border-bottom">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="roll" class="control-label">Student Roll</label>
                                <input type="text" name="roll" id="roll" value="<?= isset($roll) ? $roll : "" ?>"
                                    class="form-control form-control-sm rounded-0" required maxlength="32"
                                    pattern="[A-Za-z0-9\-\/\.]{1,32}" placeholder="e.g., CS/2023/001">
                                <div class="invalid-feedback">Roll can include letters, numbers, -, /, . (max 32).</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="firstname" class="control-label">First Name</label>
                                <input type="text" name="firstname" id="firstname"
                                    value="<?= isset($firstname) ? $firstname : "" ?>"
                                    class="form-control form-control-sm rounded-0" required maxlength="100"
                                    pattern="[A-Za-z\s'\.]{2,100}">
                                <div class="invalid-feedback">First name is required (2–100 letters).</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="middlename" class="control-label">Middle Name</label>
                                <input type="text" name="middlename" id="middlename"
                                    value="<?= isset($middlename) ? $middlename : "" ?>"
                                    class="form-control form-control-sm rounded-0" maxlength="100"
                                    pattern="[A-Za-z\s'\.]{0,100}" placeholder="optional">
                                <div class="invalid-feedback">Only letters, spaces, apostrophes, and dots.</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="lastname" class="control-label">Last Name</label>
                                <input type="text" name="lastname" id="lastname"
                                    value="<?= isset($lastname) ? $lastname : "" ?>"
                                    class="form-control form-control-sm rounded-0" required maxlength="100"
                                    pattern="[A-Za-z\s'\.]{2,100}">
                                <div class="invalid-feedback">Last name is required (2–100 letters).</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="gender" class="control-label">Gender</label>
                                <select name="gender" id="gender" class="form-control form-control-sm rounded-0"
                                    required>
                                    <option value="" disabled <?= !isset($gender) ? 'selected' : '' ?>>Select gender
                                    </option>
                                    <option value="Male" <?= isset($gender) && $gender == 'Male' ? 'selected' : '' ?>>Male
                                    </option>
                                    <option value="Female" <?= isset($gender) && $gender == 'Female' ? 'selected' : '' ?>>
                                        Female</option>
                                    <option value="Other" <?= isset($gender) && $gender == 'Other' ? 'selected' : '' ?>>
                                        Other</option>
                                </select>
                                <div class="invalid-feedback">Please select a gender.</div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="dob" class="control-label">Date of Birth</label>
                                <input type="date" name="dob" id="dob" value="<?= isset($dob) ? $dob : "" ?>"
                                    class="form-control form-control-sm rounded-0" required>
                                <div class="invalid-feedback">DOB is required (age must be 5–100).</div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="contact" class="control-label">Contact #</label>
                                <input type="text" name="contact" id="contact"
                                    value="<?= isset($contact) ? $contact : "" ?>"
                                    class="form-control form-control-sm rounded-0" required maxlength="20"
                                    pattern="[0-9\+\-\s\(\)]{7,20}" placeholder="+94 77 123 4567">
                                <div class="invalid-feedback">Digits, spaces, +, -, ( ) only (10 chars Only).</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="present_address" class="control-label">Present Address</label>
                                <textarea rows="3" name="present_address" id="present_address"
                                    class="form-control form-control-sm rounded-0" required
                                    maxlength="255"><?= isset($present_address) ? htmlspecialchars($present_address) : "" ?></textarea>
                                <div class="invalid-feedback">Present address is required (max 255 chars).</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="permanent_address" class="control-label">Permanent Address</label>
                                <textarea rows="3" name="permanent_address" id="permanent_address"
                                    class="form-control form-control-sm rounded-0" required
                                    maxlength="255"><?= isset($permanent_address) ? htmlspecialchars($permanent_address) : "" ?></textarea>
                                <div class="invalid-feedback">Permanent address is required (max 255 chars).</div>
                            </div>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-flat btn-primary btn-sm" type="submit" form="student_form">Save Student
                Details</button>
            <a href="./?page=students" class="btn btn-flat btn-default border btn-sm">Cancel</a>
        </div>
    </div>
</div>

<script>
    // ---- Helper validation functions ----
    const trimValue = el => { if (el && typeof el.value === 'string') el.value = el.value.trim(); };

    function calcAge(dobStr) {
        if (!dobStr) return null;
        const today = new Date();
        const dob = new Date(dobStr + "T00:00:00"); // avoid TZ issues
        if (isNaN(dob)) return null;
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
        return age;
    }

    function setValidity(el, message) {
        el.setCustomValidity(message || "");
        if (message) {
            el.classList.add('is-invalid');
            el.classList.remove('is-valid');
        } else {
            el.classList.remove('is-invalid');
            // removed green tick: no .is-valid class added
        }
    }

    function validateName(el) {
        trimValue(el);
        const v = el.value;
        if (el.required && v.length < 2) return setValidity(el, "Please enter at least 2 characters.");
        if (v.length > 100) return setValidity(el, "Must be at most 100 characters.");
        const re = /^[A-Za-z\s'\.]{0,100}$/;
        if (!re.test(v)) return setValidity(el, "Only letters, spaces, apostrophes, and dots.");
        return setValidity(el, "");
    }

    function validateRoll(el) {
        trimValue(el);
        const v = el.value;
        if (!v) return setValidity(el, "Student Roll is required.");
        if (v.length > 32) return setValidity(el, "Max 32 characters.");
        const re = /^[A-Za-z0-9\-\/\.]{1,32}$/;
        if (!re.test(v)) return setValidity(el, "Only A–Z, 0–9, -, /, .");
        return setValidity(el, "");
    }

    function validateGender(el) {
        if (!el.value) return setValidity(el, "Please select a gender.");
        return setValidity(el, "");
    }

    function validateDOB(el) {
        if (!el.value) return setValidity(el, "Date of birth is required.");
        const age = calcAge(el.value);
        if (age === null) return setValidity(el, "Invalid date.");
        if (age < 5 || age > 100) return setValidity(el, "Age must be between 5 and 100.");
        return setValidity(el, "");
    }

    function validateContact(el) {
        trimValue(el);
        const v = el.value;
        if (!v) return setValidity(el, "Contact number is required.");
        if (v.length < 7 || v.length > 10) return setValidity(el, "Length must be 7–10.");
        const re = /^[0-9+\-\s()]{7,10}$/;
        if (!re.test(v)) return setValidity(el, "Digits, spaces, +, -, ( ) only.");
        return setValidity(el, "");
    }

    function validateAddress(el) {
        trimValue(el);
        const v = el.value;
        if (!v) return setValidity(el, "This address is required.");
        if (v.length > 255) return setValidity(el, "Max 255 characters.");
        return setValidity(el, "");
    }

    function validateForm() {
        const form = document.getElementById('student_form');
        const fields = {
            roll: document.getElementById('roll'),
            firstname: document.getElementById('firstname'),
            middlename: document.getElementById('middlename'),
            lastname: document.getElementById('lastname'),
            gender: document.getElementById('gender'),
            dob: document.getElementById('dob'),
            contact: document.getElementById('contact'),
            present_address: document.getElementById('present_address'),
            permanent_address: document.getElementById('permanent_address')
        };

        // run field-wise validators
        validateRoll(fields.roll);
        validateName(fields.firstname);
        if (fields.middlename.value.trim() !== "") validateName(fields.middlename); else setValidity(fields.middlename, "");
        validateName(fields.lastname);
        validateGender(fields.gender);
        validateDOB(fields.dob);
        validateContact(fields.contact);
        validateAddress(fields.present_address);
        validateAddress(fields.permanent_address);

        // HTML5 fallback (pattern/required)
        const html5OK = form.checkValidity();

        // find first invalid
        const firstInvalid = form.querySelector('.is-invalid, :invalid');
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            if (typeof firstInvalid.reportValidity === 'function') firstInvalid.reportValidity();
            return false;
        }
        return html5OK;
    }

    // Live validation on user input/changes
    document.addEventListener('DOMContentLoaded', function () {
        const f = document.getElementById('student_form');
        const bind = (id, fn, evt = 'input') => {
            const el = document.getElementById(id);
            if (!el) return;
            el.addEventListener(evt, () => fn(el));
            // clear custom validity on focus
            el.addEventListener('focus', () => setValidity(el, ""));
        };

        bind('roll', validateRoll);
        bind('firstname', validateName);
        bind('middlename', validateName);
        bind('lastname', validateName);
        bind('gender', validateGender, 'change');
        bind('dob', validateDOB, 'change');
        bind('contact', validateContact);
        bind('present_address', validateAddress);
        bind('permanent_address', validateAddress);
    });

    // ---- Submit (only if valid) + existing AJAX flow ----
    $(function () {
        $('#student_form').on('submit', function (e) {
            e.preventDefault();

            // run validation
            if (!validateForm()) return;

            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>');
            el.addClass("pop-msg alert").hide();

            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_student",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occured", 'error');
                    end_loader();
                },
                success: function (resp) {
                    if (resp.status == 'success') {
                        location.href = "./?page=students/view_student&id=" + resp.sid;
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger").text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger").text("An error occurred due to unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html,body,.modal').animate({ scrollTop: 0 }, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>