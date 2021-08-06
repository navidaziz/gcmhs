<div class="row" style="height: 38px !important;">
    <div class="col-sm-12">
        <div class="page-header" style="min-height: 30px !important">
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li><?php echo $teachers[0]->teacher_name; ?> - <?php echo $teachers[0]->teacher_designation; ?></li>
            </ul>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row" style="margin-left: -25px; margin-right: -23px;">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box-body" style="background-color: white !important; margin-top: 10px; text-align: center;">

            <div style="padding-top: 15px;">

                <?php $query = "SELECT `class_id`, `section_id`, Class_title, section_title, color 
                                        FROM `classes_time_tables`  
                                        WHERE `classes_time_tables`.`class_teacher`='1' 
                                        and teacher_id='" . $this->session->userdata('teacher_id') . "'";
                $class_teacher = $this->db->query($query)->result();
                if ($class_teacher) {
                    echo '<a href="add_student_attendance/' . $class_teacher[0]->class_id . '/' . $class_teacher[0]->section_id . '" ><div class="btn btn-warning btn-sm">Add ';
                    echo $class_teacher[0]->Class_title . " - " . $class_teacher[0]->section_title;
                    echo ' Attendance </div></a>';
                }
                ?>

                <div class="btn btn-success btn-sm"> Add Test / Exam Result </div>
            </div>
            <h6>

                <?php foreach ($teachers as $teacher) { ?>
                    <div class="table-res ponsive" style="padding: 5px;">
                        <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <h5>Time Table</h5>
                                <tr>
                                    <th>Days</th>
                                    <?php
                                    $weeks = array(
                                        "mon" => "Monday",
                                        "tue" => "Tuesday",
                                        "wed" => "Wednesday",
                                        "thu" => "Thursday",
                                        "fri" => "Friday",
                                        "sat" => "Saturday",
                                    );
                                    foreach ($weeks as $w_index => $week) { ?>
                                        <th>
                                            <?php echo strtoupper(substr($week, 0, 3)); ?>
                                            <?php //echo $period->period_title;  
                                            ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                error_reporting(14);

                                foreach ($periods as $period) { ?>
                                    <tr>
                                        <td><?php echo $period->period_title; ?></td>
                                        <?php foreach ($weeks as $w_index => $week) { ?>

                                            <?php $query = "SELECT * FROM `classes_time_tables` 
                                        WHERE period_id='" . $period->period_id . "'
                                        AND `" . $w_index . "` = '1'
                                        AND `teacher_id` = '" . $teacher->teacher_id . "'";
                                            $teacher_subjects = $this->db->query($query)->result();
                                            if ($teacher_subjects) { ?>

                                                <?php foreach ($teacher_subjects as $teacher_subject) { ?>
                                                    <td style="background-color:  <?php echo $teacher_subject->color ?>;">
                                                        <div>
                                                            <?php if ($teacher_subject->short_title != 'Nazira') { ?>
                                                                <?php echo substr($teacher_subject->short_title, 0, 4); ?>-
                                                            <?php } ?>


                                                            <?php echo str_replace("th", "", $teacher_subject->Class_title);  ?>-<?php echo substr($teacher_subject->section_title, 0, 1);  ?>
                                                            <br />
                                                        </div>
                                                    </td>
                                                <?php } ?>

                                            <?php } else { ?>
                                                <td>-</td>
                                            <?php } ?>

                                        <?php } ?>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                    <br />
                    <br />
                    <br />
                    <br />
                <?php } ?>

            </h6>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>