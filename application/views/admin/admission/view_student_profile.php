<?php

$class_id = $students[0]->class_id;
$section_id = $students[0]->section_id;

?>


<div id="update_profile" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="">Student Profile Update</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">


                <form action="<?php echo site_url(ADMIN_DIR . "admission/update_profile/" . $students[0]->student_id) ?>" method="post" style="text-align: center;">
                    <table class="table">
                        <tr>
                            <th>Class No: </th>
                            <td><input type="text" name="student_class_no" value="<?php echo $students[0]->student_class_no; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Admission No: </th>
                            <td><input type="text" name="student_admission_no" value="<?php echo $students[0]->student_admission_no; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Student Name: </th>
                            <td><input type="text" name="student_name" value="<?php echo $students[0]->student_name; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Father Name: </th>
                            <td><input type="text" name="student_father_name" value="<?php echo $students[0]->student_father_name; ?>" /></td>
                        </tr>

                        <tr>
                            <th>Date Of Birth: </th>
                            <td><input type="date" name="student_data_of_birth" value="<?php echo $students[0]->student_data_of_birth; ?>" /></td>
                        </tr>

                        <tr>
                            <th>Form B No:</th>
                            <td><input type="text" name="form_b" value="<?php echo $students[0]->form_b; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Admission Date:</th>
                            <td><input type="date" name="admission_date" value="<?php echo $students[0]->admission_date; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td><input type="text" name="student_address" value="<?php echo $students[0]->student_address; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Father CNIC No:</th>
                            <td><input type="text" name="father_nic" value="<?php echo $students[0]->father_nic; ?>" /></td>
                        </tr>
                        <tr>
                            <th>CNIC Issue Date:</th>
                            <td><input type="date" name="nic_issue_date" value="<?php echo $students[0]->nic_issue_date; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Contact No:</th>
                            <td><input type="text" name="father_mobile_number" value="<?php echo $students[0]->father_mobile_number; ?>" /></td>
                        </tr>

                        <tr>
                            <th>Father Occupation:</th>
                            <td><input type="text" name="guardian_occupation" value="<?php echo $students[0]->guardian_occupation; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Religion:</th>
                            <td><input type="text" name="religion" value="<?php echo $students[0]->religion; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Nationality:</th>
                            <td><input type="text" name="nationality" value="<?php echo $students[0]->nationality; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Private / Public School:</th>

                            <td>
                                <input type="radio" name="private_public_school" value="G" <?php if ($students[0]->private_public_school == 'G') { ?>checked<?php } ?> />
                                Government
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="private_public_school" value="P" <?php if ($students[0]->private_public_school == 'P') { ?>checked<?php } ?> />
                                Private
                            </td>

                        </tr>
                        <tr>
                            <th>School Name:</th>
                            <td><input type="text" name="school_name" value="<?php echo $students[0]->school_name; ?>" /></td>
                        </tr>
                        <tr>
                            <th>Orphan: </th>
                            <td>

                                <input type="radio" name="orphan" value="Yes" <?php if ($students[0]->orphan == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="orphan" value="No" <?php if ($students[0]->orphan == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>


                        <tr>
                            <th>Vaccinated: </th>
                            <td>
                                <input type="radio" name="vaccinated" value="Yes" <?php if ($students[0]->vaccinated == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="vaccinated" value="No" <?php if ($students[0]->vaccinated == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>

                        <tr>
                            <th>Is Disable: </th>
                            <td>
                                <input type="radio" name="is_disable" value="Yes" <?php if ($students[0]->is_disable == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="is_disable" value="No" <?php if ($students[0]->is_disable == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>

                        <tr>
                            <th>Ehsaas Program: </th>
                            <td>
                                <input type="radio" name="ehsaas" value="Yes" <?php if ($students[0]->ehsaas == 'Yes') { ?>checked<?php } ?> />
                                Yes
                                <span style="margin-left: 20px;"></span>

                                <input type="radio" name="ehsaas" value="No" <?php if ($students[0]->ehsaas == 'No') { ?>checked<?php } ?> />
                                No
                            </td>
                        </tr>




                        <td colspan="2">
                            <input type="submit" class="btn btn-success btn-sm" value="Update Profile" />
                            </tr>
                    </table>




                </form>

            </div>

        </div>
    </div>
</div>

<script>
    function update_profile() {
        $('#update_profile').modal('show');
    }
</script>



<div id="re_admit" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="readmit_model_title">Title</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <h4 id="re_admit_body">Please Wait .....</h4>
                <p style="text-align: center;">


                <form action="<?php echo site_url(ADMIN_DIR . "admission/re_admit_again") ?>" method="post" style="text-align: center;">
                    <input type="hidden" name="student_id" id="studentID" value="" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                    <input type="hidden" name="redirect_page" value="view_student_profile" />
                    Admission No: <input type="text" name="admission_no" id="admission_no" value="" />
                    <br />
                    Re-Admission Detail:
                    <input required type="text" class="form-control" style="margin: 10px;" name="re_admit_again_reason" />
                    <input type="submit" class="btn btn-success btn-sm" value="Admit Again" />
                </form>
                </p>
            </div>

        </div>
    </div>
</div>

<script>
    function re_admit(student_id, name, father_name, add_no) {
        $('#readmit_model_title').html("Student Re Admit Form");
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
        $('#admission_no').val(add_no);

        $('#studentID').val(student_id);
        $('#re_admit_body').html(body);
        $('#re_admit').modal('show');
    }
</script>

<div id="withdrawal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="withdrawal_model_title">Title</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <h4 id="withdrawal_admit_body">Please Wait .....</h4>
                <p style="text-align: center;">
                <form action="<?php echo site_url(ADMIN_DIR . "admission/withdraw_student") ?>" method="post" style="text-align: center;">
                    <input type="hidden" name="student_id" id="stID" value="" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                    <input type="hidden" name="redirect_page" value="view_student_profile" />
                    <table class="" style="width: 100%;">

                        <tr>
                            <td>Admission No:</td>
                            <td><input type="text" required name="admission_no" id="adNo" value="" /></td>
                        </tr>
                        <tr>
                            <td>Admission Date:</td>
                            <td><input type="date" required name="admission_date" id="add_date" value="" /></td>
                        </tr>
                        <tr>
                            <td>Schoool Leaving Date:</td>
                            <td> <input type="date" required name="school_leaving_date" id="school_leaving_date" value="" />
                            </td>
                        </tr>
                        <tr>
                            <td>SLC Issue Date:</td>
                            <td><input type="date" required name="slc_issue_date" id="slc_issue_date" value="" /></td>
                        </tr>
                        <tr>
                            <td>SLC File No:</td>
                            <td><input type="text" required name="slc_file_no" id="slc_file_no" value="" /></td>
                        </tr>
                        <tr>
                            <td>SLC Certificate No:</td>
                            <td><input type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" /></td>
                        </tr>
                        <tr>
                            <td>Withdrawal Reason:</td>
                            <td>
                                <textarea style="width: 100%;" name="withdraw_reason"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" class="btn btn-danger btn-sm" value="Withdraw" /></td>
                        </tr>
                    </table>
                </form>
                </p>
            </div>

        </div>
    </div>
</div>

<div id="general_model" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="general_model_body">


        </div>
    </div>
</div>
<script>
    function withdraw(student_id, name, father_name, add_no, admission_date) {
        $('#withdrawal_model_title').html("Student Withdraw Form");
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + '<br /> Admission Date: ' + admission_date + '<br /> ';
        $('#adNo').val(add_no);
        $('#add_date').val(admission_date);


        $('#stID').val(student_id);
        $('#withdrawal_admit_body').html(body);
        $('#withdrawal').modal('show');
    }

    function change_class_form(student_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(ADMIN_DIR . "admission/change_class_form"); ?>",
            data: {
                student_id: student_id
            }
        }).done(function(data) {

            $('#general_model_body').html(data);
        });

        $('#general_model').modal('show');
    }

    function change_section_form(student_id) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url(ADMIN_DIR . "admission/change_section_form"); ?>",
            data: {
                student_id: student_id
            }
        }).done(function(data) {

            $('#general_model_body').html(data);
        });

        $('#general_model').modal('show');
    }
</script>


<div id="struck_off" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="sof_model_title">Title</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <h4 id="struck_off_body">Please Wait .....</h4>
                <p style="text-align: center;">Stuck Off Reason:
                <form action="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/struck_off_student") ?>" method="post" style="text-align: center;">
                    <input type="hidden" name="student_id" id="student_ID" value="" />
                    <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
                    <input type="hidden" name="redirect_page" value="view_student_profile" />
                    <input required type="text" class="form-control" style="margin: 10px;" name="struck_off_reason" />
                    <input type="submit" class="btn btn-danger btn-sm" value="Struck Off" />
                </form>
                </p>
            </div>

        </div>
    </div>
</div>
<script>
    function struck_off_model(student_id, name, father_name, add_no) {
        $('#sof_model_title').html("Student Stuck Off Form");
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
        $('#student_ID').val(student_id);
        $('#struck_off_body').html(body);
        $('#struck_off').modal('show')
    }
</script>


<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li> <i class="fa fa-home"></i> Home </li>
                <li> <a href="<?php echo site_url(ADMIN_DIR . "admission/"); ?>"> Admission</a> </li>
                <li> <?php echo $students[0]->student_name . ""; ?> Profile</li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="col-md-4">
                <div class="clearfix">
                    <h6 class="content-title pull-left"> <?php echo strtoupper($students[0]->student_name) . ""; ?> </h6>
                </div>
                <!-- <div class="description" id="message"></div> -->
            </div>
            <div class="col-md-8">
                <h5 class="pull-right">
                    <?php
                    $student = $students[0];
                    if ($student->status == 1) { ?>
                        <button onclick="struck_off_model('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-warning btn-sm" aria-hidden="true">Struck Off</Button>
                        <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>

                    <?php  } ?>
                    <?php if ($student->status == 2) { ?>
                        <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>

                        <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>

                    <?php  } ?>
                    <?php if ($student->status == 3) { ?>
                        <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>

                    <?php  } ?>
                    <?php if ($student->status != 0) { ?>
                        <a class="btn btn-primary btn-sm" target="_new" href="<?php echo site_url(ADMIN_DIR . "admission/birth_certificate/" . $student->student_id); ?>"><i class="fa fa-print" aria-hidden="true"></i> Birth Certificate</a>
                        <button onclick="update_profile()" class="btn btn-success btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Edit Profile</button>

                        <button onclick="change_class_form('<?php echo $student->student_id; ?>')" class="btn btn-warning btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Change Class</button>
                        <button onclick="change_section_form('<?php echo $student->student_id; ?>')" class="btn btn-warning btn-sm"><i class="fa fa-edit" aria-hidden="true"></i> Change Section</button>

                        <a href="<?php echo site_url(ADMIN_DIR . "admission/delete_student_profile/$student->student_id"); ?>" onclick="return confirm('Are you sure? You want to remove student profile.')" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Delete Student</a>
                    <?php  } ?>
                    <?php if ($student->status == 0) { ?>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/restore_student_profile/$student->student_id"); ?>" onclick="return confirm('Are you sure? You want to restore student profile.')" class="btn btn-danger btn-sm"><i class="fa fa-undo" aria-hidden="true"></i> Restore Student Profile</a>
                    <?php  } ?>

                </h5>
            </div>

        </div>
    </div>
</div>


<style>
    .table_small>tbody>tr>td,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>td,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>thead>tr>th {
        padding: 1px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 9px;
        border: 0.1px solid gray !important;
        color: black !important;
    }
</style>


<div class="row">
    <div class="col-md-3">
        <div class="table-responsive">

            <!-- Profile Image -->
            <div style="text-align:center; margin-bottom:10px;">
                <img src="<?php echo site_url('uploads/gcmhs/' . htmlspecialchars($student->student_image, ENT_QUOTES, 'UTF-8')); ?>" width="120" />
            </div>

            <!-- Student Name -->
            <strong>
                <?php echo strtoupper($student->student_name); ?>
                S/O <?php echo strtoupper($student->student_father_name); ?>
            </strong>

            <!-- Admission No and Status -->
            <div style="font-size:20px; overflow:hidden; margin:10px 0;">
                <h5 class="pull-left">
                    <?php echo $this->lang->line('student_admission_no'); ?>:
                    <?php echo htmlspecialchars($student->student_admission_no, ENT_QUOTES, 'UTF-8'); ?>
                </h5>
                <h5 class="pull-right">
                    Status:
                    <?php
                    if ($student->status == 1) {
                        echo 'Admitted';
                    } elseif ($student->status == 2) {
                        echo 'Struck Off';
                    } elseif ($student->status == 3) {
                        echo 'SLC';
                    } elseif ($student->status == 0) {
                        echo 'Deleted';
                    }
                    ?>
                </h5>
            </div>

            <!-- Loop through students -->
            <?php foreach ($students as $s): ?>

                <!-- Class/Section Info -->
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="text-center"><?php echo $this->lang->line('student_class_no'); ?></th>
                        <th class="text-center"><?php echo $this->lang->line('Class_title'); ?></th>
                        <th class="text-center"><?php echo $this->lang->line('section_title'); ?></th>
                    </tr>
                    <tr>
                        <td class="text-center"><?php echo htmlspecialchars($s->student_class_no, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($s->Class_title, ENT_QUOTES, 'UTF-8'); ?></td>
                        <td class="text-center"><?php echo htmlspecialchars($s->section_title, ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                </table>

                <!-- Details Table -->
                <table class="table table-bordered table-striped" style="width:100%;">
                    <tbody>
                        <tr>
                            <td>Form B:</td>
                            <td><?php echo strtoupper($s->form_b); ?></td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td>
                            <td><?php echo date('d-m-Y', strtotime($s->student_data_of_birth)); ?></td>
                        </tr>
                        <tr>
                            <td>Date Of Admission</td>
                            <td><?php echo date('d-m-Y', strtotime($s->admission_date)); ?></td>
                        </tr>
                        <tr>
                            <td>Father Mobile No.</td>
                            <td><?php echo htmlspecialchars($s->father_mobile_number, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td>Father CNIC</td>
                            <td><?php echo htmlspecialchars($s->father_nic, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td>Father Occupation</td>
                            <td><?php echo htmlspecialchars($s->guardian_occupation, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td>Previous School</td>
                            <td><?php echo htmlspecialchars($s->private_public_school . ' - ' . $s->school_name, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td><?php echo htmlspecialchars($s->nationality, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td>Religion</td>
                            <td><?php echo htmlspecialchars($s->religion, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td>Orphan</td>
                            <td><?php echo htmlspecialchars($s->orphan, ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <?php echo $this->lang->line('student_address'); ?>:
                                <?php echo htmlspecialchars($s->student_address, ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">Created date: <?php echo date('d M Y', strtotime($s->created_date)); ?></td>
                        </tr>
                    </tbody>
                </table>

            <?php endforeach; ?>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="col-md-9">

        <!-- History -->
        <div class="col-md-4">
            <h3 class="title">History</h3>
            <?php
            $query = "SELECT *, s.section_title, c.class_title, se.session
                FROM student_history AS sh
                JOIN sections AS s ON sh.section_id = s.section_id
                JOIN classes AS c ON sh.class_id = c.class_id
                JOIN sessions AS se ON sh.session_id = se.session_id
                WHERE sh.student_id = ?";
            $student_history_list = $this->db->query($query, array($student->student_id))->result();

            foreach ($student_history_list as $student_history): ?>
                <div style="margin-bottom:5px;">
                    <span class="pull-left"><?php echo htmlspecialchars($student_history->history_type); ?></span>
                    <span class="pull-right"><?php echo date("d M, Y", strtotime($student_history->create_date)); ?></span><br />
                    <small>
                        <?php echo htmlspecialchars($student_history->remarks); ?>
                    </small>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Academic Summary -->
        <div class="col-md-8">
            <h3 class="title">Academic Summary</h3>
            <?php
            $query = "SELECT ex.year, ex.exam_id, ex.exam_data, ex.term,
                       c.class_title AS class, sec.section_title AS section,
                       SUM(exr.obtain_mark) AS obtain_mark,
                       SUM(exr.total_marks) AS total_marks
                FROM students_exams_subjects_marks exr
                JOIN exams ex ON ex.exam_id = exr.exam_id
                JOIN classes c ON c.class_id = exr.class_id
                JOIN sections sec ON sec.section_id = exr.section_id
                WHERE exr.student_id = ?
                GROUP BY exr.exam_id";
            $student_exam_records = $this->db->query($query, array($student->student_id))->result();
            ?>

            <?php if (!empty($student_exam_records)): ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Exam</th>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Obt. Marks</th>
                            <th>Total Marks</th>
                            <th>Per.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($student_exam_records as $record): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($record->year); ?></td>
                                <td><?php echo htmlspecialchars($record->term); ?></td>
                                <td><?php echo date("M-y", strtotime($record->exam_data)); ?></td>
                                <td><?php echo htmlspecialchars($record->class); ?></td>
                                <td><?php echo htmlspecialchars($record->section); ?></td>
                                <td class="text-center"><?php echo (int)$record->obtain_mark; ?></td>
                                <td class="text-center"><?php echo (int)$record->total_marks; ?></td>
                                <td class="text-center">
                                    <?php echo round((($record->obtain_mark * 100) / $record->total_marks), 2) . '%'; ?>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-success btn-sm"
                                        onclick="get_student_dmc(<?php echo (int)$student->student_id; ?>, <?php echo (int)$record->exam_id; ?>)">
                                        DMC
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No exam records found for this student.</p>
            <?php endif; ?>
        </div>

        <!-- Attendance -->
        <div class="col-md-12">
            <h4>Attendance History</h4>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Month / Days</th>
                        <?php for ($d = 1; $d <= 31; $d++): ?>
                            <th class="text-center"><?php echo $d; ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $monthNames = array(
                        '01' => 'January',
                        '02' => 'February',
                        '03' => 'March',
                        '04' => 'April',
                        '05' => 'May',
                        '06' => 'June',
                        '07' => 'July',
                        '08' => 'August',
                        '09' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December'
                    );
                    $currentYear = date('Y');

                    foreach ($monthNames as $monthNum => $monthName):
                        $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
                    ?>
                        <tr>
                            <th><?php echo $monthName; ?></th>
                            <?php for ($day = 1; $day <= 31; $day++): ?>
                                <?php
                                if ($day > $daysInMonth) {
                                    echo '<td></td>';
                                    continue;
                                }
                                $q = "SELECT * FROM students_attendance
                      WHERE student_id=? AND YEAR(date)=? AND MONTH(date)=? AND DAY(date)=?";
                                $att = $this->db->query($q, array($student->student_id, $currentYear, $monthNum, $day))->row();
                                $style = '';
                                if ($att) {
                                    if ($att->attendance == 'A') $style = 'background-color:#D8534E;';
                                    elseif ($att->attendance == 'P' && (empty($att->attendance2) || $att->attendance2 == 'P')) $style = 'background-color:#96AE5F;';
                                    elseif ($att->attendance == 'P' && $att->attendance2 == 'A') $style = 'background-color:#F0AD4E;';
                                }
                                ?>
                                <td style="text-align:center; <?php echo $style; ?>">
                                    <?php
                                    if ($att) {
                                        echo htmlspecialchars($att->attendance);
                                        if (!empty($att->attendance2)) echo ' - ' . htmlspecialchars($att->attendance2);
                                    }
                                    ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function get_student_dmc(student_id, exam_id) {
        $.post("<?php echo site_url(ADMIN_DIR . 'admission/get_student_dmc'); ?>", {
                student_id: student_id,
                exam_id: exam_id
            },
            function(resp) {
                $('#modal').modal('show');
                $('#modal_title').html('Initiate Scheme');
                $('#modal_body').html(resp);
            });
    }
</script>