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
            <h5><?php echo date("d M, Y") ?> <?php echo $title; ?> </h5>

            <?php
            
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
                                
                                 <th style="text-align: center;">Morning</th>
                                 <?php if($evening_attendance){ ?>
                                    <th style="text-align: center;">E-P</th>
                                    <th style="text-align: center;">E-L</th>
                                    <th style="text-align: center;">E-A</th>
                                    <?php } ?>
                            </tr>

                            <!-- <tr>
                                <td colspan="4" style="text-align:center"> </td>


                                <?php if ($today_attendance == 0) { ?>
                                    <th colspan="4"></th>
                                    <?php } else {
                                    for ($i = 5; $i >= 0; $i--) {
                                    ?>
                                        <?php if (date('N', strtotime("-$i days")) == 7) { ?>
                                            <th style="text-align: center;"></th>
                                        <?php } else {

                                            $query = "SELECT COUNT(*) as total 
                                                          FROM `students_attendance`
                                                          WHERE `date` = '" . date('Y-m-d', strtotime("-$i days")) . "'
                                                          AND class_id= $class_id
                                                          AND section_id = $section_id";
                                            $attendance_count = $this->db->query($query)->result()[0]->total;


                                        ?>

                                            <th style="text-align: center;">
                                                <?php if ($attendance_count == 0) { ?>
                                                    <a style="color:green" href="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/add_student_attendance_form/$class_id/$section_id/" . date('Y-m-d', strtotime("-$i days"))); ?>">
                                                        <i class="fa fa-plus" aria-hidden="true"></i></a>
                                                <?php } else { ?>
                                                    <a style="color:blue" href="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/edit_student_attendance_form/$class_id/$section_id/" . date('Y-m-d', strtotime("-$i days"))); ?>">
                                                        <i class="fa fa-edit" aria-hidden="true"></i></a>
                                                <?php } ?>

                                            </th>



                                        <?php } ?>

                                    <?php } ?>

                                <?php } ?>

                            </tr> -->
                        </thead>
                        <tbody>

                            <?php
                            $count = 1;
                            foreach ($students as $student) { ?>
                            <tr <?php if ($student->status != 1) { ?>style="text-decoration: line-through !important; <?php } ?>">
                                    <td><?php //echo $student->student_class_no; 

                                        echo $count; ?></td>
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
                                    <?php   ?>
                                                <td style="text-align:center">
                                                    <?php
                                                    $other_arrtibute = "";
                                                    $color = "black";
                                                    if ($student->attendance == 'A') {
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
                                                    <?php if ($student->attendance == 'L') {
                                                        $color = "green";
                                                    } ?>
                                                    <?php if ($student->attendance == 'C' or $student->attendance == 'CL') {
                                                        $color = "gray";
                                                    } ?>
                                                    <strong style="  color: <?php echo $color ?>; <?php echo $other_arrtibute; ?>">
                                                        <?php echo $student->attendance; ?>
                                                    </strong>
                                                    <?php if ($student->attendance2 == 'A') { ?>
                                                        - <span style="color: red ;"><strong>A</strong></span>
                                                    <?php } ?>
                                                </td>
                                         <?php if($evening_attendance){ ?>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_attendance_id ?>]" <?php if ($student->attendance == 'P') { ?> checked="checked" <?php } ?> value="P" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_attendance_id ?>]" <?php if ($student->attendance == 'L') { ?> checked="checked" <?php } ?> value="L" /></td>
                                        <td style="text-align: center;"><input type="radio" name="attendance[<?php echo $student->student_attendance_id ?>]" <?php if ($student->attendance == 'A') { ?> checked="checked" <?php } ?> value="A" /></td>
                                  <?php } ?>
                                </tr>
                            <?php } ?>
                            <?php if($evening_attendance){ ?>
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