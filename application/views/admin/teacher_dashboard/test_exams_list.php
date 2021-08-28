<div class="row" style="height: 38px !important;">
    <div class="col-sm-12">
        <div class="page-header" style="min-height: 30px !important">
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li>Test / Exams list</li>
            </ul>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row" style="margin-left: -25px; margin-right: -23px;">
    <!-- MESSENGER -->
    <div class="col-md-12">





        <?php

        foreach ($exams as $exam) { ?>
            <div class="box-body" style="background-color: white !important; margin-top: 10px; text-align: center; min-height:50px; padding: 5px;">
                <h4>
                    <?php echo $exam->year; ?> - <?php echo $exam->term; ?>
                </h4>
                <small style="color:gray; margin: 5px; padding: 5px;">Test / Exam Instructions:</small>

                <ul class="list-group">
                    <?php foreach ($teacher_subjects as $teacher_subject) {
                        $query = "SELECT COUNT(*) as total FROM students_exams_subjects_marks
                                WHERE exam_id = '" . $exam->exam_id . "'
                                AND class_id = '" . $teacher_subject->class_id . "'
                                AND section_id = '" . $teacher_subject->section_id . "'
                                AND subject_id = '" . $teacher_subject->subject_id . "'";
                        $result_entered = $this->db->query($query)->result()[0]->total;
                        if ($result_entered) { ?>
                            <li class="list-group-item" style="border-left-style: solid;
  border-left-color:  <?php echo $teacher_subject->color; ?>; border-left-width: 30px; padding: 10px; min-height: 50px; text-align: left; ">
                                <strong>
                                    <a href="<?php echo site_url(ADMIN_DIR) . "/teacher_dashboard/students_result/$exam->exam_id/$teacher_subject->class_id/$teacher_subject->section_id/$teacher_subject->class_subject_id/$teacher_subject->subject_id"; ?>">
                                        <span class="">
                                            <?php echo $teacher_subject->Class_title . " - " . $teacher_subject->section_title . " " . $teacher_subject->subject_title;; ?>

                                        </span>

                                        <span class="pull-right label label-success label-sm">Submitted</span>
                                </strong>
                                </a>
                            </li>
                        <?php } else {
                        ?>
                            <li class="list-group-item" style="border-left-style: solid;
  border-left-color:  <?php echo $teacher_subject->color; ?>; border-left-width: 30px; padding: 10px; min-height: 50px; text-align: left; ">
                                <strong>
                                    <a href="<?php echo site_url(ADMIN_DIR) . "/teacher_dashboard/students_list/$exam->exam_id/$teacher_subject->class_id/$teacher_subject->section_id/$teacher_subject->class_subject_id/$teacher_subject->subject_id"; ?>">
                                        <span class="">
                                            <?php echo $teacher_subject->Class_title . " - " . $teacher_subject->section_title . " " . $teacher_subject->subject_title;; ?>

                                        </span>

                                        <span class="pull-right label label-warning label-sm">Pending</span>
                                </strong>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>

                </ul>
            </div>
        <?php } ?>




    </div>
    <!-- /MESSENGER -->
</div>