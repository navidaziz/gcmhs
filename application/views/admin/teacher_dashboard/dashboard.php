<div class="row">
    <div class="col-sm-12">
        <div class="hea der" style="min-height: 50px !important; width:100% !important; background-color: white; margin: 2px; margin-bottom: 5px;">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb pull-left">
                <li>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>">
                        <img src="<?php echo site_url("assets/uploads/" . $system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:30px !important;"></a>


                </li>
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>

            <ul class="nav navb ar-nav pull-right" style="margin-left: -10px;">


                <li class="dropdow n us er" id="header-user"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img style="width: 20px;" alt="" src="<?php echo site_url("assets/uploads/" . $this->session->userdata("user_image")); ?>" /> <span class="username"><?php echo $this->session->userdata("user_title"); ?></span> <i class="fa fa-angle-down"></i> </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo site_url(ADMIN_DIR . "users/update_profile"); ?>"><i class="fa fa-user"></i> Update Profile</a></li>
                        <!--<li><a href="#"><i class="fa fa-cog"></i> Account Settings</a></li>
          <li><a href="#"><i class="fa fa-eye"></i> Privacy Settings</a></li>-->
                        <li><a href="<?php echo site_url(ADMIN_DIR . "users/logout"); ?>"><i class="fa fa-power-off"></i> Log Out</a></li>

                    </ul>

                </li>



                <!-- END USER LOGIN DROPDOWN -->
            </ul>

        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
                <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
            </div>
            <div class="box-body">

                <h6>

                    <?php foreach ($teachers as $teacher) { ?>
                        <div class="table-res ponsive">
                            <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th colspan="11" style="text-align: left !important;">
                                            <strong><?php echo $teacher->teacher_name; ?> - <?php echo $teacher->teacher_designation; ?></strong>
                                            <span style="float: right;">
                                                <?php $query = "SELECT Class_title, section_title, color 
                                                        FROM `classes_time_tables`  
                                                        WHERE `classes_time_tables`.`class_teacher`='1' 
                                                        and teacher_id='" . $teacher->teacher_id . "'";
                                                $class_teacher = $this->db->query($query)->result();
                                                if ($class_teacher) {
                                                    echo '<span style="float:right"> Incharge Teacher: Class ';
                                                    echo $class_teacher[0]->Class_title . " - " . $class_teacher[0]->section_title;
                                                    echo '</span>';
                                                }
                                                ?>
                                            </span>
                                        </th>
                                    </tr>
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
    </div>
    <!-- /MESSENGER -->
</div>