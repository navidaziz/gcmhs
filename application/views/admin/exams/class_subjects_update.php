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
            <h3 class="content-title pull-left">Class Sections Subjects Teachers</h3>
            
          </div>
          <div class="description"><?php echo $title; ?></div>
        </div>
        <div class="col-md-6"><span class="pull-right"><button onclick="$('.remove_button').show();" class="link">Remove Teacher</button></span></div>
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
         
      </div>
      <div class="box-body">
        <div class="table-responsive" style="font-size:11px !important;">
          <div class="row"> 
            <!-- MESSENGER -->
            <script>
              function update_subject_total_mark(class_subject_id){
				   var marks = $('#total_marks_'+class_subject_id).val();
		  			$.ajax({ 
					type: "POST",
					url: "<?php echo site_url(ADMIN_DIR."class_subjects/update_class_subject_mark"); ?>/"+class_subject_id,
				data:{ marks: marks }}).done(function( msg ) {  
											//$("#status-"+id).html(msg) 
											//alert(msg);
											});
				  
			  }
			  
			   function update_subject_passing_mark(class_subject_id){
				   var passing_mark = $('#passing_mark_'+class_subject_id).val();
		  			$.ajax({ 
					type: "POST",
					url: "<?php echo site_url(ADMIN_DIR."class_subjects/update_class_subject_passing_mark"); ?>/"+class_subject_id,
				data:{ passing_mark: passing_mark }}).done(function( msg ) {  
											//$("#status-"+id).html(msg) 
											//alert(msg);
											});
											
											
				  
			  }
			  
			  
			  function update_class_section_teacher(class_subject_teacher_id){
					 var class_teacher = $('#class_section_techer_'+class_subject_teacher_id).val();
					 $.ajax({ 
					type: "POST",
					url: "<?php echo site_url(ADMIN_DIR."class_subject_teacher/class_subject_teacher_update"); ?>/"+class_subject_teacher_id,
				data:{ class_teacher: class_teacher }}).done(function( msg ) {  
											$("#error").html(msg) 
											//alert(msg);
											});
					
					}

              
              </script>
            <?php foreach($classes as $class){ ?>
            
            <div class="col-md-12">
              <h3><?php echo $class->Class_title; ?>  </h3>
              
              <div id="error"></div>
              <table class="table table-bordered">
                <thead>
                </thead>
                <tbody>
                  <tr>
                  <th>Sections</th>
                    <?php foreach($class->subjects as $subject): ?>
                    <td style="background-color:#FF0; color:#000;"><strong><?php echo substr($subject->subject_title,0,15); ?></strong> <br />
                      Total Mark:
                      <input  onkeyup="update_subject_total_mark('<?php echo $subject->class_subject_id;  ?>')" style="width:100%" type="text" name="marks" value="<?php echo $subject->marks; ?>" id="total_marks_<?php echo $subject->class_subject_id;  ?>"   required="required" title="Marks" placeholder="Marks">
                      Passing Mark:
                      <input onkeyup="update_subject_passing_mark('<?php echo $subject->class_subject_id;  ?>')" style="width:100%" type="number" name="passing_mark" value="<?php echo $subject->passing_mark; ?>" id="passing_mark_<?php echo $subject->class_subject_id;  ?>"   required="required" title="Passing Mark" placeholder="Passing Mark"></td>
                    <?php endforeach; ?>
                  </tr>
                  <?php foreach($class->sections as $section){ ?>
                  <tr><td><?php echo $section->section_title; ?></td>
                   <?php foreach($class->subjects as $subject): 
				  /*$query="INSERT INTO `class_subject_teacher`( `exam_id`, `class_subject_id`, `section_id`, `class_teacher`, `paper_checked_by`) VALUES ('3', '".$subject->class_subject_id."', '".$section->section_id."', 'NULL', 'NULL')";
				   $this->db->query($query);*/
				  /* if($class->class_id==1){
				  $query="INSERT INTO `class_subject_teacher`( `exam_id`, `class_subject_id`, `section_id`, `class_teacher`, `paper_checked_by`) VALUES ('3', '".$subject->class_subject_id."', '".$section->section_id."', 'NULL', 'NULL')";
				   //$this->db->query($query);
				   }*/
				   
				   $query="SELECT * FROM `class_subject_teacher` WHERE `exam_id` ='".$exam_id."' and `class_subject_id` ='".$subject->class_subject_id."' and `section_id` = '".$section->section_id."'";
				   $result = $this->db->query($query);
				   
				   ?>
                   <td>
                   <?php if($result->num_rows){
				   $class_subject_teacher = $result->result()[0]; 
/*				   echo $query="SELECT * FROM `class_subject_teacher` WHERE `exam_id` ='".$exam_id."' and `class_subject_id` ='".$subject->class_subject_id."' and `section_id` = '".$section->section_id."'";
*/				   
				   ?>
                   Teacher Name
                    <input onkeyup="update_class_section_teacher('<?php echo $class_subject_teacher->class_subject_teacher_id;  ?>')" type="text" id="class_section_techer_<?php echo $class_subject_teacher->class_subject_teacher_id;  ?>" style="width:100%" value="<?php echo $class_subject_teacher->class_teacher; ?>">
                    <a class="remove_button" style="display:none" href="<?php echo site_url(ADMIN_DIR."class_subject_teacher/class_subject_teacher_remove/$class_subject_teacher->class_subject_teacher_id/$exam_id"); ?>" >Remove</a>
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
