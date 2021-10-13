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
                    <input type="hidden" name="student_id" id="studentID" value="" />
                    <input type="hidden" name="class_id" id="studentID" value="<?php echo $class_id ?>" />
                    <input type="hidden" name="section_id" id="studentID" value="<?php echo $section_id ?>" />
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
        $('#studentID').val(student_id);
        $('#struck_off_body').html(body);
        $('#struck_off').modal('show')
    }
</script>

<div class="row" style="height: 38px !important;">
    <div class="col-sm-12">
        <div class="page-header" style="min-height: 30px !important">
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row" style="margin-left: -25px; margin-right: -23px;">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box-body" style="background-color: white !important; margin-top: 10px; text-align: center; padding: 3px;">
            <style>
                .table1 tr,
                td {
                    padding: 1px;
                    border-collapse: collapse;
                    border-bottom: 1px solid #D3D3D3;
                }
            </style>
            <h5>Update <?php echo date("d M, Y", strtotime($attendance_date)) ?> <?php echo $title; ?> </h5>

            <div class="table-res ponsive" style="padding: 5px;" style="font-size: 9px;">
                <form action="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/update_attendance") ?>" method="post">
                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
                    <input type="hidden" name="attendance_date" value="<?php echo $attendance_date; ?>" />
                    <table id="example" class="table1" cellspacing="0" width="100%" style="font-size:11px; text-align: left !important; ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Add No.</th>
                                <th style="text-align: center;">S-Off</th>
                                <th>Student Name</th>
                                <!-- <th>Father Name</th> -->

                                <th style="text-align: center;">P</th>
                                <!-- <th style="text-align: center;">CL</th> -->
                                <th style="text-align: center;">L</th>
                                <th style="text-align: center;">A</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $count = 1;
                            foreach ($students as $student) { ?>
                                <tr <?php if ($student->status != 1) { ?>style="text-decoration: line-through !important; <?php } ?>">
                                    <td><?php //echo $student->student_class_no; 

                                        echo $count; ?></td>
                                    <td><?php echo $student->student_admission_no; ?></td>
                                    <td style="text-align: center;">
                                        <?php if ($student->status == 1) { ?>
                                            <i onclick="struck_off_model('<?php echo $student->student_id; ?>', '<?php echo $student->student_name; ?>', '<?php echo $student->student_father_name; ?>', '<?php echo $student->student_admission_no; ?>')" class="fa fa fa-times-circle" aria-hidden="true" style="color:red"></i>
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <a data-content="Father Name: <?php echo $student->student_father_name; ?>. Father NIC:  
                                        <?php echo $student->father_nic; ?>. Father Mobile No: <?php echo $student->father_mobile_number; ?> <br />
                                        " tabindex="<?php echo $count++; ?>" role="button" data-toggle="popover" data-trigger="focus" class="pop-top" data-title="Top" data-toggle="popover" data-original-title="" title="<?php echo $student->student_name; ?>">
                                            <?php echo $student->student_name; ?>

                                            <i class="fa fa-info-circle pull-right" aria-hidden="true" style="margin-right: 15px;"></i>
                                        </a>
                                    </td>
                                    <!-- <td><?php echo $student->student_father_name; ?></td> -->

                                    <?php

                                    $query = "SELECT `attendance`, `student_attendance_id` 
                                                FROM students_attendance
                                                WHERE student_id = '" . $student->student_id . "'
                                                AND section_id = '" . $section_id . "'
                                                AND class_id = '" . $class_id . "'
                                                AND date(created_date) = " . $this->db->escape($attendance_date) . "";
                                    $query_result = $this->db->query($query)->result();
                                    if ($query_result) {
                                        $present = "";
                                        $corona_leave = "";
                                        $leave = "";
                                        $absent = "";
                                        if (@$query_result[0]->attendance == 'P') {
                                            $present = 'checked="checked"';
                                        }

                                        if (@$query_result[0]->attendance == 'CL') {
                                            $corona_leave = 'checked="checked"';
                                        }

                                        if (@$query_result[0]->attendance == 'L') {
                                            $leave = 'checked="checked"';
                                        }

                                        if (@$query_result[0]->attendance == 'A') {
                                            $absent = 'checked="checked"';
                                        }


                                    ?>

                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo @$query_result[0]->student_attendance_id ?>]" <?php echo $present; ?> value="P" /></td>
                                        <!-- <td style="text-align: center;"><input type="radio" name="attendance[<?php echo @$query_result[0]->student_attendance_id ?>]" <?php echo $corona_leave; ?> value="CL" /></td> -->
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo @$query_result[0]->student_attendance_id ?>]" <?php echo $leave; ?> value="L" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo @$query_result[0]->student_attendance_id ?>]" <?php echo $absent; ?> value="A" /></td>
                                    <?php } ?>


                                </tr>
                            <?php } ?>

                            <tr>
                                <td colspan="7" style="text-align:center">
                                    <input class="btn btn-success btn-sm" type="submit" name="Update_Attendance" value="Update Attendance" />
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </form>
            </div>



        </div>
    </div>
    <!-- /MESSENGER -->
</div>