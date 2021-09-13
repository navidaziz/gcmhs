<?php

$class_id = $students[0]->class_id;
$section_id = $students[0]->section_id;

?>

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
                            <th>Admission No:</th>
                            <td><input type="text" required name="admission_no" id="adNo" value="" /></td>
                        </tr>
                        <tr>
                            <th>Admission Date:</th>
                            <td><input type="date" required name="admission_date" id="add_date" value="" /></td>
                        </tr>
                        <tr>
                            <th>Schoool Leaving Date:</th>
                            <td> <input type="date" required name="school_leaving_date" id="school_leaving_date" value="" />
                            </td>
                        </tr>
                        <tr>
                            <th>SLC Issue Date:</th>
                            <td><input type="date" required name="slc_issue_date" id="slc_issue_date" value="" /></td>
                        </tr>
                        <tr>
                            <th>SLC File No:</th>
                            <td><input type="text" required name="slc_file_no" id="slc_file_no" value="" /></td>
                        </tr>
                        <tr>
                            <th>SLC Certificate No:</th>
                            <td><input type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" /></td>
                        </tr>
                        <tr>
                            <th>Withdrawal Reason:</th>
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
            <div class="col-md-6">
                <div class="clearfix">
                    <h3 class="content-title pull-left"> <?php echo $students[0]->student_name . ""; ?> Profile</li>
                    </h3>
                </div>
                <div class="description" id="message"></div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12" style="background-color: white; padding: 5px;">

    </div>
</div>



<div class="row" style="background-color: white; padding: 5px;">
    <div class="col-md-3">
        <div class="table-responsive">
            <h3 class="title"><?php echo $title; ?> <span style="font-size:20px !important;"> </h3>
            <?php foreach ($students as $student) : ?>
                <h5>
                    <?php if ($students[0]->status == 1) { ?> Admitted
                        <button onclick="struck_off_model('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-warning btn-sm" aria-hidden="true">Struck Off</Button>
                        <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>

                    <?php  } ?>
                    <?php if ($students[0]->status == 2) { ?> Struck Off
                        <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>

                        <button onclick="withdraw('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>', '<?php echo $student->admission_date; ?>')" class="btn btn-danger btn-sm" aria-hidden="true">Withdraw</button>

                    <?php  } ?>
                    <?php if ($students[0]->status == 3) { ?> SLC
                        <button onclick="re_admit('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="btn btn-success btn-sm" aria-hidden="true"> Re-admit</button>

                    <?php  } ?>
                    <?php if ($students[0]->status == 0) { ?> Deleted <?php  } ?>
                </h5>


                <table class="table">
                    <thead>
                    </thead>
                    <tbody>

                        <tr>
                            <th><?php echo $this->lang->line('student_admission_no'); ?></th>
                            <td><?php echo $student->student_admission_no; ?></td>
                        </tr>

                        <tr>
                            <th><?php echo $this->lang->line('student_name'); ?></th>
                            <td><?php echo $student->student_name; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('student_father_name'); ?></th>
                            <td><?php echo $student->student_father_name; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
                            <td><?php echo $student->student_data_of_birth; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('student_address'); ?></th>
                            <td><?php echo $student->student_address; ?></td>
                        </tr>

                        <tr>
                            <th>Student Image</th>
                            <td><?php
                                echo file_type(base_url("assets/uploads/" . $student->student_image));
                                ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('student_class_no'); ?></th>
                            <td><?php echo $student->student_class_no; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo $this->lang->line('Class_title'); ?></th>
                            <td><?php echo $student->Class_title; ?></td>
                        </tr>

                        <tr>
                            <th><?php echo $this->lang->line('section_title'); ?></th>
                            <td><?php echo $student->section_title; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>

    <div class="col-md-9">
        <h3 class="title">Tests</h3>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('test_type'); ?></th>
                    <th><?php echo $this->lang->line('test_title'); ?></th>

                    <th><?php echo $this->lang->line('subject_title'); ?></th>
                    <th>Total Que.</th>
                    <th>Attempt Que.</th>
                    <th>Obtain Marks</th>
                    <th><?php echo $this->lang->line('Action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tests as $test) : ?>
                    <tr>
                        <td><?php echo $test->test_type; ?></td>
                        <td><?php echo $test->test_title; ?></td>
                        <td><?php echo $test->subject_title; ?></td>
                        <td><?php
                            if ($test->result->total_test_questions) {
                                echo  $test->result->total_test_questions;
                            } ?></td>

                        <td><?php
                            if ($test->result->total_questions) {
                                echo  $test->result->total_questions;
                            } ?></td>
                        <td><?php echo  $test->result->got_marks ?></td>
                        <td>
                            <?php if ($this->session->userdata('logged_in')) { ?>

                                <?php if ($test->result->total_questions) { ?>

                                    <?php if ($test->result->total_questions >= $test->result->total_test_questions) { ?>
                                        Completed
                                    <?php } ?>
                                    <?php if ($test->result->total_questions < $test->result->total_test_questions) { ?>
                                        <a class="llink llink-view" href="<?php echo site_url("student/test/" . $test->test_id . "/"); ?>"> Resume </a>

                                    <?php     } ?>

                                <?php } else { ?>
                                    <a class="llink llink-view" href="<?php echo site_url("student/test/" . $test->test_id . "/"); ?>"> Start Test </a>
                                <?php } ?>



                            <?php } else { ?> <em><span style="font-size:9px !important;">Need Login</span></em> <?php } ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>