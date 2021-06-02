<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."academical_evaluations/view/"); ?>"><?php echo $this->lang->line('Academical Evaluations'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $academical_evaluations[0]->academical_evaluation_title; ?></h3>
          </div>
          <div class="description"><?php echo $academical_evaluations[0]->academical_evaluation_date; ?></div>
        </div>
        <!--<div class="col-md-6">
          <div class="pull-right"> <a class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."academical_evaluations/add"); ?>"><i class="fa fa-plus"></i> <?php echo $this->lang->line('New'); ?></a> <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR."academical_evaluations/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a> </div>
        </div>--> 
      </div>
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
        <h4><i class="fa fa-bell"></i> <?php echo $academical_evaluations[0]->academical_evaluation_title; ?></h4>
        
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <div class="row"> 
            <!-- MESSENGER -->
            
            <?php foreach($classes as $class){ ?>
            <div class="col-md-12">
              <h3 class="pull-left"><?php echo $class->Class_title; ?></h3>
              <table class="table table-bordered">
                <thead>
                </thead>
                <tbody>
                  <tr>
                    <th style="background-color:#FF0; color:#000;">Subjects</th>
                    <?php foreach($class->subjects as $subject): ?>
                    <th style="background-color:#FF0; color:#000;"><?php echo $subject->subject_title; ?> </th>
                    <?php endforeach; ?>
                  </tr>
                  <?php foreach($class->sections as $section){ ?>
                  <tr>
                    <th style="background-color:<?php echo $section->color; ?>;"><?php echo $section->section_title; ?> </th>
                    <?php foreach($class->subjects as $subject): ?>
                    <?php 
				
				
				
				$query="SELECT 
							  COUNT(`student_exam_subject_mark_id`) AS total 
							FROM `students_exams_subjects_marks`
							WHERE `class_id` = '".$class->class_id."'
							AND `section_id` = '".$section->section_id."'
							AND `subject_id` = '".$subject->subject_id."'
							AND `exam_id` = '".$exam->exam_id."';";
							$result = $this->db->query($query);
							
				
				
				
				 $query="SELECT * FROM `class_subject_teacher` WHERE `exam_id` ='".$exam_id."' and `class_subject_id` ='".$subject->class_subject_id."' and `section_id` = '".$section->section_id."'";
				   $teacher_result = $this->db->query($query);
				    if($teacher_result->num_rows){
				
				//var_dump($subject);
				if($result->result()[0]->total==0){ ?>
                    <td><a class="link link-view" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/add_students_subject_result/".$exam->exam_id."/".$class->class_id."/".$section->section_id."/".$subject->class_subject_id."/".$subject->subject_id); ?>">Add Result </a>
                      <?php //echo $subject->subject_title; ?>
                      <?php }else{ ?>
                    <td style="background-color:#3F6;"><a  class="link link-view" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/update_students_subject_result/".$exam->exam_id."/".$class->class_id."/".$section->section_id."/".$subject->class_subject_id."/".$subject->subject_id); ?>">Update Result </a>
                      <?php 
				$query="SELECT
				COUNT(`student_exam_subject_mark_id`) AS total
				FROM
				`students_exams_subjects_marks` 
				WHERE  `exam_id` = '".$exam_id."'
				AND `section_id` = '".$section->section_id."'
				AND `subject_id` ='".$subject->subject_id."'
				AND `class_id` ='".$class->class_id."';";
				$query_result = $this->db->query($query);
				echo $query_result->result()[0]->total;				
				?>
                      <br />
                      <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/view_subject_result/".$exam->exam_id."/".$class->class_id."/".$section->section_id."/".$subject->class_subject_id."/".$subject->subject_id); ?>" >View Result</a>
                      <?php }?>
                      <?php }else{ ?>
                    <td><a style="color:gray" class="llink llink-edit" onclick="add_subject_teacher('<?php echo "Add <strong>Teacher</strong> For Class <strong>".$class->Class_title."</strong> Section <strong>".$section->section_title."</strong> Subject <strong>".$subject->subject_title."</strong>" ?>', '<?php echo $exam_id; ?>', '<?php echo $subject->class_subject_id; ?>', '<?php echo $section->section_id; ?>')"  href="javascript:void(0);"> Add Teacher</a></td>
                    <?php } ?>
                      </td>
                    <?php endforeach; ?>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
