<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<head>
</head>
<body>

<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row" style="font-size:12px !important; font-family: Open Sans !important"> 

  <div class="col-md-12">
  
  
  
   <style>
table {
    border-collapse: collapse;
	width:100%;
}

thead {
  font-weight:bold;
}

table, th, td {
    border: 1px solid black;
}
      </style>
  
  
    
    
   
  
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
            
            <?php foreach($classes as $class){ ?>
            <div class="col-md-12">
              <h3><?php echo $class->Class_title; ?></h3>
              
              
            <table class="table table-bordered">
            <thead>
            </thead>
            <tbody>
             
              <tr>
              <th >Subjects</th>
               <?php foreach($class->subjects as $subject): ?>
                <th ><?php echo $subject->subject_title; ?></th>
                <?php endforeach; ?>
              </tr>
               <?php foreach($class->sections as $section){ ?>
              <tr>
             
              <th ><?php echo $section->section_title; ?>
             
              
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
							
				
				
				//var_dump($subject);
				if($result->result()[0]->total==0){ ?>
                <td>
                <?php 
				$query="SELECT * FROM `class_subject_teacher` WHERE `exam_id` ='".$exam_id."' and `class_subject_id` ='".$subject->class_subject_id."' and `section_id` = '".$section->section_id."'";
				   $result = $this->db->query($query);
				   if($result->num_rows){
				   $class_subject_teacher = $result->result()[0];
				   echo "<strong>".$class_subject_teacher->class_teacher."</strong>  <i>Wating</i> ...";
				   }
				
				?>
                
                
                <?php }else{ ?>
                
                <td >
				
					<?php }?>
                
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
</div>
<!-- /MESSENGER -->
</div>
</body>
</html>
