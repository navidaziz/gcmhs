<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> <a href="<?php echo site_url(ADMIN_DIR.$this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a> </li>
        <li> <i class="fa fa-table"></i> <a href="<?php echo site_url(ADMIN_DIR."exams/view/"); ?>"><?php echo $this->lang->line('Exams'); ?></a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-6">
          <div class="clearfix">
            <h3 class="content-title pull-left"><?php echo $title; ?></h3>
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <div class="col-md-6">
          <div class="pull-right"> <a target="new" class="btn btn-primary btn-sm" href="<?php echo site_url(ADMIN_DIR."exam_list/paper_collection_report/".$exams[0]->exam_id); ?>">Print</a> </div>
        </div>
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
        <div class="table-responsive" style="font-size:11px !important;">
          <table class="table">
            <thead>
            </thead>
            <tbody>
              <?php foreach($exams as $exam): ?>
              <tr>
                <th><?php echo $this->lang->line('year'); ?></th>
                <th><?php echo $this->lang->line('term'); ?></th>
                <th><?php echo $this->lang->line('passing_percentage'); ?></th>
                <th><?php echo $this->lang->line('promotion_percentage'); ?></th>
                <th><?php echo $this->lang->line('exam_data'); ?></th>
                <th><?php echo $this->lang->line('Status'); ?></th>
              </tr>
              <tr>
                <td><?php echo $exam->year; ?></td>
                <td><?php echo $exam->term; ?></td>
                <td><?php echo $exam->passing_percentage; ?></td>
                <td><?php echo $exam->promotion_percentage; ?></td>
                <td><?php echo $exam->exam_data; ?></td>
                <td><?php echo status($exam->status); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div class="row"> 
            <!-- MESSENGER -->
            
            <?php 
            
             $completed_subjects=0;
                  $total_subjects=0;
            
            foreach($classes as $class){ ?>
            <div class="col-md-12">
              <h3 class="pull-left"><?php echo $class->Class_title; ?></h3>
              <h5 class="pull-right"><a href="<?php 
				echo site_url(ADMIN_DIR."exam_list/award_list/".$exam->exam_id."/".$class->class_id); ?>" target="new">Award List</a>
                -
                <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/view_class_result/".$exam->exam_id."/".$class->class_id."/"); ?>" >Over All Class </a> -  <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/class_dashboard/".$exam->exam_id."/".$class->class_id."/"); ?>" >Class Dashboard </a>
                </h5>
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
                  <?php 
                  
                 
                  
                  
                  foreach($class->sections as $section){ ?>
                  <tr>
                    <th style="background-color:<?php echo $section->color; ?>;"><?php echo $section->section_title; ?> <br />
                     <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/attendance_sheet/".$exam->exam_id."/".$class->class_id."/".$section->section_id); ?>" >Attendance Sheet</a>
                <br />
                      <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/view_subjects_result/".$exam->exam_id."/".$class->class_id."/".$section->section_id); ?>" >View Results</a>
                
                <br />
                <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/class_dmcs/".$exam->exam_id."/".$class->class_id."/".$section->section_id); ?>" >View DMC's</a>
                
                <br />
                <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/secction_wise_result/".$exam->exam_id."/".$class->class_id."/".$section->section_id); ?>" >% Results</a>
                 <a target="new" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/section_dashboard/".$exam->exam_id."/".$class->class_id."/".$section->section_id); ?>" >Dashboard </a>
                 </th>
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
							
				$total_subjects++;
				
				
				 $query="SELECT * FROM `class_subject_teacher` WHERE `exam_id` ='".$exam_id."' and `class_subject_id` ='".$subject->class_subject_id."' and `section_id` = '".$section->section_id."'";
				   $teacher_result = $this->db->query($query);
				    if($teacher_result->num_rows){
				
				//var_dump($subject);
				if($result->result()[0]->total==0){ ?>
                    <td><a class="link link-view" href="<?php 
				echo site_url(ADMIN_DIR."exam_list/add_students_subject_result/".$exam->exam_id."/".$class->class_id."/".$section->section_id."/".$subject->class_subject_id."/".$subject->subject_id); ?>">Add Result </a>
                      <?php //echo $subject->subject_title; ?>
                      <?php 
                      
                      
                      
                      }else{ 
                      
                      $completed_subjects++;
                      
                      ?>
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
            
             <p style="text-align:center;"><h5> Total Subjects = <?php echo $total_subjects; ?>
                   Entry Completed <?php echo  $completed_subjects; 
                   
                  echo "<br /><b>";
                   echo round(($completed_subjects*100/$total_subjects),2);
                   echo "</b>";
                   ?>
                   
                   % Work Completed.
                 
                 
                
                 
                  </h5></p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<script>
function add_subject_teacher(modal_title, exam_id, class_subject_id,  section_id ){
	$('#title').html(modal_title);
	$('#exam_id').val(exam_id);
	$('#class_subject_id').val(class_subject_id);
	$('#section_id').val(section_id);
	
 $('#add_subject_teacher_modal').modal('toggle');
	}
</script><div class="modal" id="add_subject_teacher_modal" data-backdrop="static" >
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title" id="title">Add Teacher</h4>
      </div>
      <div class="modal-body" id="customer_location_body">
      
      
      <?php
	  $query = "SELECT DISTINCT `class_teacher` FROM `class_subject_teacher` Order BY `class_teacher` ASC";
	  $query_result = $this->db->query($query);
	  $teachers = $query_result->result();
	  $count=1;
	  ?>
      
        <h5  id="customer_location_title"></h5>
       
        <?php $edit_form_attr = array("id" => "customer_location_form");
echo form_open_multipart(ADMIN_DIR."exam_list/add_class_teacher", $edit_form_attr);  ?>
<input type="hidden" required="required" id="exam_id" name="exam_id" />
<input type="hidden" required="required" id="class_subject_id" name="class_subject_id" />
<input type="hidden" required="required" id="section_id" name="section_id" />

        <table width="100%">
          <tr>
          <th>Select Teacher</th>
          <th>Total Marks</th>
          <th>Passing Marks</th>
          </tr>
          <tr>
          <td>
          <select required name="techer_name">
              <option value="NULL">NULL</option>
          <option value="">Select Teacher</option>
         <?php  foreach($teachers as $teacher){ ?>
         <option value="<?php echo $teacher->class_teacher; ?>"><?php echo $teacher->class_teacher; ?></option>
      
      <?php } ?>
          </select>
          </td>
          <td><input type="number" value="100" required="required" name="total_marks" /></td>
           <td><input value="33" type="number" required="required" name="passing_marks" /></td>
          </tr>
          <tr>
          <td>
          <input type="submit"   name="submit" value="Add Teacher" />
          </td>
          </tr>
        </table>
        </form>
      </div>
      <!-- <div class="modal-footer"> <a href="#" data-dismiss="modal" class="btn btn-primary">Close</a></div>--> 
    </div>
  </div>
</div>