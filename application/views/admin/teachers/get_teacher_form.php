<form id="teachers" class="form-horizontal" enctype="multipart/form-data" method="post">
    <input type="hidden" name="teacher_id" value="<?php echo $input->teacher_id; ?>" />
    <div class="form-group row">
        <label for="teacher_name" class="col-sm-4 col-form-label">Teacher Name</label>
        <div class="col-sm-8">
            <input required type="text" id="teacher_name" name="teacher_name" value="<?php echo $input->teacher_name; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="father_name" class="col-sm-4 col-form-label">Father Name</label>
        <div class="col-sm-8">
            <input type="text" id="father_name" name="father_name" value="<?php echo $input->father_name; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row" style="display: none;">
        <label for="gender" class="col-sm-4 col-form-label">Gender</label>
        <div class="col-sm-8">
            <?php
            //$options = array("Male", "Female");
            $options = array("Male");
            foreach ($options as $option) {
                $checked = "";
                if ($option == $input->gender) {
                    $checked = "checked";
                }
                $checked = "checked";
            ?>
                <span style="margin-left:5px"></span>
                <input required <?php echo $checked ?> type="radio" id="<?php echo $option; ?>" name="gender" value="<?php echo $option; ?>" class="">
                <span style="margin-left:3px"></span> <?php echo $option;  ?>
            <?php } ?>
        </div>
    </div>
    <div class="form-group row">
        <label for="date_of_birth" class="col-sm-4 col-form-label">Date Of Birth</label>
        <div class="col-sm-8">
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $input->date_of_birth; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="teacher_designation" class="col-sm-4 col-form-label">Teacher Designation</label>
        <div class="col-sm-8">
            <input required type="text" id="teacher_designation" name="teacher_designation" value="<?php echo $input->teacher_designation; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="cnic" class="col-sm-4 col-form-label">CNIC</label>
        <div class="col-sm-8">
            <input type="text" id="cnic" name="cnic" value="<?php echo $input->cnic; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="mobile_number" class="col-sm-4 col-form-label">Mobile Number</label>
        <div class="col-sm-8">
            <input required type="text" id="mobile_number" name="mobile_number" value="<?php echo $input->mobile_number; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="acadmic_qualification" class="col-sm-4 col-form-label">Acadmic Qualification</label>
        <div class="col-sm-8">
            <input placeholder="MA, BC, FC, M.Phil, Phd" type="text" id="acadmic_qualification" name="acadmic_qualification" value="<?php echo $input->acadmic_qualification; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="major_subject" class="col-sm-4 col-form-label">Major Subject</label>
        <div class="col-sm-8">
            <input placeholder="Urdu, English, Math etc" type="text" id="major_subject" name="major_subject" value="<?php echo $input->major_subject; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="professional_qualification" class="col-sm-4 col-form-label">Professional Qualification</label>
        <div class="col-sm-8">
            <input placeholder="PST, CT, B.Ed, M.Ed" type="text" id="professional_qualification" name="professional_qualification" value="<?php echo $input->professional_qualification; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="initial_appointment_date" class="col-sm-4 col-form-label">Initial Appointment Date</label>
        <div class="col-sm-8">
            <input type="date" id="initial_appointment_date" name="initial_appointment_date" value="<?php echo $input->initial_appointment_date; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="current_school_assumption_date" class="col-sm-4 col-form-label">Current School Assumption Date</label>
        <div class="col-sm-8">
            <input type="date" id="current_school_assumption_date" name="current_school_assumption_date" value="<?php echo $input->current_school_assumption_date; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="current_post_assumption_date" class="col-sm-4 col-form-label">Current Post Assumption Date</label>
        <div class="col-sm-8">
            <input type="date" id="current_post_assumption_date" name="current_post_assumption_date" value="<?php echo $input->current_post_assumption_date; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="personal_no" class="col-sm-4 col-form-label">Personal No</label>
        <div class="col-sm-8">
            <input type="number" id="personal_no" name="personal_no" value="<?php echo $input->personal_no; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="basic_pay_scale" class="col-sm-4 col-form-label">Basic Pay Scale</label>
        <div class="col-sm-8">
            <input type="number" id="basic_pay_scale" name="basic_pay_scale" value="<?php echo $input->basic_pay_scale; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="current_pay" class="col-sm-4 col-form-label">Current Pay</label>
        <div class="col-sm-8">
            <input type="number" id="current_pay" name="current_pay" value="<?php echo $input->current_pay; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="gp_fund_number" class="col-sm-4 col-form-label">Gp Fund Number</label>
        <div class="col-sm-8">
            <input type="text" id="gp_fund_number" name="gp_fund_number" value="<?php echo $input->gp_fund_number; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="bank_branch" class="col-sm-4 col-form-label">Bank Branch</label>
        <div class="col-sm-8">
            <input type="text" id="bank_branch" name="bank_branch" value="<?php echo $input->bank_branch; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="bank_branch_code" class="col-sm-4 col-form-label">Bank Branch Code</label>
        <div class="col-sm-8">
            <input type="text" id="bank_branch_code" name="bank_branch_code" value="<?php echo $input->bank_branch_code; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="bank_account_no" class="col-sm-4 col-form-label">Bank Account No</label>
        <div class="col-sm-8">
            <input type="number" id="bank_account_no" name="bank_account_no" value="<?php echo $input->bank_account_no; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-4 col-form-label">Email</label>
        <div class="col-sm-8">
            <input type="email" id="email" name="email" value="<?php echo $input->email; ?>" class="form-control">
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-4 col-form-label">Address</label>
        <div class="col-sm-8">
            <input type="text" id="address" name="address" value="<?php echo $input->address; ?>" class="form-control">
        </div>
    </div>
    <?php if ($input->teacher_id != 0) {

        $query = "SELECT * FROM users WHERE teacher_id = $input->teacher_id";
        $teacher_account = $this->db->query($query)->row();
        $profile_id = 0;
        if ($teacher_account->user_id >= 0) {
            $profile_id = $teacher_account->user_id;
        }
    ?>
        <div class="form-group row">
            <label for="user_name" class="col-sm-4 col-form-label">User Name</label>
            <div class="col-sm-8">
                <input type="hidden" name="profile_id" value="<?php echo $profile_id; ?>" />
                <input required type="text" id="user_name" name="user_name" value="<?php echo $teacher_account->user_name; ?>" class="form-control">
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-4 col-form-label">Password</label>
            <div class="col-sm-8">
                <input required type="text" id="password" name="password" value="<?php echo $teacher_account->user_password; ?>" class="form-control">
            </div>
        </div>
    <?php } ?>
    <?php if ($input->teacher_id != 0) {
        $hide = 'display:none';
    ?>
        <div class="form-group row">
            <label for="leaved_date" class="col-sm-4 col-form-label">Teacher leaved</label>
            <div class="col-sm-8">
                <span style="margin-left:5px"></span>
                <input onclick="$('#leaved_div').show(); $('#leaved_date').attr('', true)" <?php if ($input->status == 0) {
                                                                                                echo "checked";
                                                                                                $hide = "";
                                                                                            } ?> type="radio" value="0" name="status" /> <span style="margin-left:3px"></span> Yes
                <span style="margin-left:5px"> </span>
                <input onclick="$('#leaved_div').hide(); $('#leaved_date').attr('',false)" <?php if ($input->status == 1) {
                                                                                                echo "checked";
                                                                                            } ?> type="radio" value="1" name="status" /> <span style="margin-left:3px"></span> No
            </div>
        </div>
        <div class="form-group row" id="leaved_div" style="<?php echo $hide; ?>">
            <label for="leaved_date" class="col-sm-4 col-form-label">Leaved Date</label>
            <div class="col-sm-8">
                <input type="date" id="leaved_date" name="leaved_date" value="<?php echo $input->leaved_date; ?>" class="form-control">
            </div>
        </div>
    <?php } ?>

    <div class="form-group row" style="text-align:center">
        <div id="result_response"></div>
        <?php if ($input->teacher_id == 0) { ?>
            <button type="submit" class="btn btn-primary">Add Data</button>
        <?php } else { ?>
            <button type="submit" class="btn btn-primary">Update Data</button>
        <?php } ?>
    </div>
</form>
</div>

<script>
    $('#teachers').submit(function(e) {
        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url(ADMIN_DIR . "teachers/add_teacher"); ?>', // URL to submit form data
            data: formData,
            success: function(response) {
                // Display response
                if (response == 'success') {
                    location.reload();
                } else {
                    $('#result_response').html(response);
                }

            }
        });
    });
</script>