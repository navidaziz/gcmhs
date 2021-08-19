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
                }
            </style>
            <h5><?php echo date("d M, Y") ?> <?php echo $title; ?> </h5>

            <?php
            $evening_attendance = 0;
            $query = "SELECT COUNT(*) as total FROM `students_attendance` WHERE 
            class_id = '" . $class_id . "' and section_id = '" . $section_id . "'
            AND attendance2 IS NOT NULL  
            AND date = DATE(NOW())";
            $today_evening_attendance = $this->db->query($query)->result()[0]->total;

            if ($today_evening_attendance == 0) {
                $evening_attendance = 1;
            }
            $today_attendance = 0;
            $query = "SELECT COUNT(*) as total FROM `students_attendance` 
            WHERE class_id = '" . $class_id . "' 
            and section_id = '" . $section_id . "' 
            AND date = DATE(NOW())";
            $today_attendance = $this->db->query($query)->result()[0]->total;
            if ($today_attendance or date('N') == 7) {
                $today_attendance = 1;
            }
            if (date('N') == 7) {
                echo "<h4 style=\"color:red;\">Sunday ! School off.</h4>";
            }

            ?>
            <div class="table-res ponsive" style="padding: 5px;" style="font-size: 9px;">
                <form action="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/add_attendance") ?>" method="post">
                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>" />
                    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>" />
                    <table id="example" class="table1" cellspacing="0" width="100%" style="font-size:11px; text-align: left !important; ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Add No.</th>
                                <th>Student Name</th>
                                <!-- <th>Father Name</th> -->
                                <?php if ($today_attendance == 0) { ?>
                                    <th style="text-align: center;">Y.day</th>
                                    <th style="text-align: center;">P</th>
                                    <th style="text-align: center;">CL</th>
                                    <th style="text-align: center;">L</th>
                                    <th style="text-align: center;">A</th>
                                    <?php } else {
                                    for ($i = 5; $i >= 0; $i--) {
                                    ?>
                                        <?php if ($i == 0) { ?>
                                            <th style="text-align: center;">T.day</th>
                                        <?php } else { ?>
                                            <th style="text-align: center;"><?php echo date('d', strtotime("-$i days")); ?></th>
                                        <?php } ?>

                                    <?php } ?>

                                <?php } ?>
                                <?php if ($evening_attendance == 1  and $today_attendance == 1) { ?>
                                    <th style="text-align: center;">E-P</th>
                                    <th style="text-align: center;">E-A</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $count = 1;
                            foreach ($students as $student) { ?>
                                <tr>
                                    <td><?php echo $student->student_class_no; ?></td>
                                    <td><?php echo $student->student_admission_no; ?></td>
                                    <td>
                                        <a data-content="Father Name: <?php echo $student->student_father_name; ?>. Father NIC:  
                                        <?php echo $student->father_nic; ?>. Father Mobile No: <?php echo $student->father_mobile_number; ?> <br />
                                        " tabindex="<?php echo $count++; ?>" role="button" data-toggle="popover" data-trigger="focus" class="pop-top" data-title="Top" data-toggle="popover" data-original-title="" title="<?php echo $student->student_name; ?>">
                                            <?php echo $student->student_name; ?>

                                            <i class="fa fa-info-circle pull-right" aria-hidden="true" style="margin-right: 15px;"></i>
                                        </a>
                                    </td>
                                    <!-- <td><?php echo $student->student_father_name; ?></td> -->
                                    <?php if ($today_attendance == 0) { ?>

                                        <?php $query = "SELECT `attendance`, `student_attendance_id` 
                                            FROM students_attendance
                                            WHERE student_id = '" . $student->student_id . "'
                                            AND section_id = '" . $section_id . "'
                                            AND class_id = '" . $class_id . "'
                                            AND date = DATE_SUB(CURDATE(),INTERVAL 1 DAY)";
                                        $query_result = $this->db->query($query)->result();
                                        if ($query_result) { ?>
                                            <td style="text-align:center">
                                                <?php
                                                $other_arrtibute = "";
                                                $color = "black";
                                                if ($query_result[0]->attendance == 'A') {
                                                    $color = "red";
                                                    $other_arrtibute = "display: inline-block;
                                                        min-width: 10px;
                                                        padding: 1px 3px;
                                                        font-size: 12px;
                                                        font-weight: bold;
                                                        color: #ffffff;
                                                        line-height: 1;
                                                        vertical-align: baseline;
                                                        white-space: nowrap;
                                                        text-align: center;
                                                        background-color: red;
                                                        border-radius: 10px;";
                                                } ?>
                                                <?php if ($query_result[0]->attendance == 'L') {
                                                    $color = "green";
                                                } ?>
                                                <?php if ($query_result[0]->attendance == 'C' or $query_result[0]->attendance == 'CL') {
                                                    $color = "gray";
                                                } ?>
                                                <strong style="  color: <?php echo $color ?>; <?php echo $other_arrtibute; ?>">
                                                    <?php echo $query_result[0]->attendance; ?>
                                                </strong>

                                            </td>
                                        <?php  } else { ?>
                                            <td style="text-align: center">-</td>
                                        <?php }
                                        $present = "";
                                        $corona_leave = "";
                                        if ($query_result[0]->attendance == 'P') {
                                            $corona_leave = 'checked="checked"';
                                        } else {
                                            $present = 'checked="checked"';
                                        }

                                        ?>

                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_id ?>]" <?php echo $present; ?> value="P" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_id ?>]" <?php echo $corona_leave; ?> value="CL" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_id ?>]" value="L" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_id ?>]" value="A" /></td>
                                        <?php } else {
                                        for ($i = 5; $i >= 0; $i--) {
                                            $query = "SELECT `attendance`, `student_attendance_id`, `attendance2` 
                                            FROM students_attendance
                                            WHERE student_id = '" . $student->student_id . "'
                                            AND section_id = '" . $section_id . "'
                                            AND class_id = '" . $class_id . "'
                                            AND date = DATE_SUB(CURDATE(),INTERVAL $i DAY)";
                                            $query_result = $this->db->query($query)->result();
                                            if ($query_result) { ?>
                                                <td style="text-align:center">
                                                    <?php
                                                    $other_arrtibute = "";
                                                    $color = "black";
                                                    if ($query_result[0]->attendance == 'A') {
                                                        $color = "red";
                                                        $other_arrtibute = "display: inline-block;
                                                        min-width: 10px;
                                                        padding: 1px 3px;
                                                        font-size: 12px;
                                                        font-weight: bold;
                                                        color: #ffffff;
                                                        line-height: 1;
                                                        vertical-align: baseline;
                                                        white-space: nowrap;
                                                        text-align: center;
                                                        background-color: red;
                                                        border-radius: 10px;";
                                                    } ?>
                                                    <?php if ($query_result[0]->attendance == 'L') {
                                                        $color = "green";
                                                    } ?>
                                                    <?php if ($query_result[0]->attendance == 'C' or $query_result[0]->attendance == 'CL') {
                                                        $color = "gray";
                                                    } ?>
                                                    <strong style="  color: <?php echo $color ?>; <?php echo $other_arrtibute; ?>">
                                                        <?php echo $query_result[0]->attendance; ?>
                                                    </strong>
                                                    <?php if ($query_result[0]->attendance2 == 'A') { ?>
                                                        - <span style="color: red ;"><strong>A</strong></span>
                                                    <?php } ?>
                                                </td>

                                            <?php  } else { ?>
                                                <td style="text-align: center">-</td>
                                            <?php } ?>
                                    <?php }
                                    } ?>

                                    <?php if ($evening_attendance == 1  and $today_attendance == 1 and $query_result[0]->attendance == 'P') { ?>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $query_result[0]->student_attendance_id ?>]" <?php if ($query_result[0]->attendance == 'P') { ?> checked="checked" <?php } ?> value="P" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $query_result[0]->student_attendance_id ?>]" <?php if ($query_result[0]->attendance == 'A') { ?> checked="checked" <?php } ?> value="A" /></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                            <?php if ($today_attendance == 0) { ?>
                                <tr>
                                    <td colspan="7" style="text-align:center">
                                        <input class="btn btn-success btn-sm" type="submit" name="Add_Today_Attendance" value="Add Today Attendance" />
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php
                            if ($evening_attendance == 1 and $today_attendance == 1) { ?>
                                <tr>
                                    <td colspan="10" style="text-align:center">
                                        <input class="btn btn-danger btn-sm" type="submit" name="Add_Evening_Attendance" value="Add Evening Attendance" />
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>



        </div>
    </div>
    <!-- /MESSENGER -->
</div>