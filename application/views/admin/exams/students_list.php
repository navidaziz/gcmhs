
<div class="row">
  <div class="col-sm-12">
    <div class="page-header"> 
      <!-- STYLER --> 
      
      <!-- /STYLER --> 
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li><a href="<?php echo site_url(ADMIN_DIR."exam_list/class_subjects_view/$exam_id"); ?>"> Exams List</a></li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4"> 
          <script> 
      function show_student_add_form(){
		  $('#student_add_form').toggle();
		  }
      </script>
          <button  onclick="show_student_add_form()" class="btn btn-primary pull-right">Add Student</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->

<div class="row" style="display:none;" id="student_add_form">
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
      <div class="box-title">
        <h4><i class="fa fa-bell"></i> Add New Student</h4>
      </div>
      <div class="box-body">
        <?php
  $add_form_attr = array("class" => "form-horizontal");
  echo form_open_multipart(ADMIN_DIR."students/save_student_data/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id", $add_form_attr);
  ?>
        <div class="form-group">
          <label for="student_class_no" class="col-md-2 control-label" style="">Class No</label>
          <div class="col-md-10">
            <input type="text" name="student_class_no" value="" id="student_class_no" class="form-control" style="" required="required" title="Class No" placeholder="Class No">
          </div>
        </div>
        <div class="form-group">
          <label for="student_name" class="col-md-2 control-label" style="">Name</label>
          <div class="col-md-10">
            <input type="text" name="student_name" value="" id="student_name" class="form-control" style="" required="required" title="Name" placeholder="Name">
          </div>
        </div>
        <input type="hidden" name="student_father_name" value="Null" id="student_father_name" class="form-control" style="" required="required" title="Father Name" placeholder="Father Name" >
        <input type="hidden" name="student_data_of_birth" value="1-1-2000" id="student_data_of_birth" class="form-control" style="" required="required" title="Data Of Birth" placeholder="Data Of Birth">
        <input type="hidden" name="student_address" value="NULL" id="student_address" class="form-control" style="" title="Address" required="required" placeholder="Address" />
        <input type="hidden" name="student_admission_no" value="00000" id="student_admission_no" class="form-control" style="" required="required" title="Admission No" placeholder="Admission No">
        <input type="hidden" name="student_image" value="" id="student_image" class="form-control" style="" title="Image" placeholder="Image">
        <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
        <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
        <div class="col-md-offset-2 col-md-10">
          <input type="submit" name="submit" value="Save" class="btn btn-primary" style="">
          <input type="reset" name="reset" value="Reset" class="btn btn-default" style="">
        </div>
        <div style="clear:both;"></div>
        <?php echo form_close(); ?> </div>
    </div>
  </div>
</div>
<div class="row"> 
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box border blue" id="messenger">
    
   
      <div class="box-title">
        <?php  //var_dump($exam); ?>
        <h4><i class="fa fa-bell"></i> <?php echo $students[0]->Class_title." (".$students[0]->section_title.")"; ?> <?php echo $exam->year." ".$exam->term." Term "." Exam Subject ".$class_subject." Marks Entry Form"; ?></h4>
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
      
      
       <input type="number"  name="assinged_total_marks"   id="assinged_total_marks" />
    <input type="number"  name="actual_marks_marks" id="actual_marks_marks" />
    <button onclick="convert_numbers()">Convert</button>
      
      
      
      
        <script>
    
	
	
	  function update_student_info(student_id){
		 var student_class_no = $('#student_class_no_'+student_id).val();
		var student_name = $('#student_name_'+student_id).val();
		$.ajax({ 
				type: "POST",
				url: "<?php echo site_url(ADMIN_DIR."students/update_student_info"); ?>/"+student_id,
				data:{ student_class_no: student_class_no,
					   student_name: student_name }}).done(function( msg ) {  
											//$("#status-"+id).html(msg) 
											//alert(msg);
											});

		  }
      
      </script>
        <div class="table-responsive">
          <?php
                $add_form_attr = array("class" => "form-horizontal");
                echo form_open_multipart(ADMIN_DIR."students_exams_subjects_marks/save_student_exam_data", $add_form_attr);
            ?>
          <span style="margin:5px;" class="pull-right">
          <input required="required" type="hidden" name="class_teacher" value="NULL"  placeholder="Class Teacher">
          <input required="required" type="hidden" name="paper_checked_by" value="NULL"  placeholder="Paper Checked By">
          </span>
          <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
          <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
          <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
          <input type="hidden" name="exam_id" value="<?php echo $exam_id ?>" />
          <input type="hidden" name="class_subject_id" value="<?php echo $class_subject_id; ?>" />
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Update Student Info </th>
                <th>S/No</th>
                <th><?php echo $this->lang->line('student_class_no'); ?></th>
                <th><?php echo $this->lang->line('student_name'); ?></th>
                <th><?php echo $class_subject; ?></th>
              </tr>
            </thead>
            <tbody>
              <?php 
			  $count=1;
			   $student_id='';
			  foreach($students as $student): ?>
              <tr>
                <td><!--<input class="btn btn-success btn-sm" type="button" name="Update Student Info" value="Update Student Info" onclick="update_student_info('<?php echo $student->student_id; ?>')" />--> 
                  <a class="btn btn-danger btn-sm" onclick="return confirm('are you sure? may remove student over data?')" href="<?php echo site_url(ADMIN_DIR."students/remove_student/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student->student_id") ?>" >Remove student</a> <a class="btn btn-primary btn-sm"  href="<?php echo site_url(ADMIN_DIR."students/dormant_student/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student->student_id") ?>" >Dormant</a></td>
                <td><?php echo $count; ?></td>
                <td><input onkeyup="update_student_info('<?php echo $student->student_id; ?>')" id="student_class_no_<?php echo $student->student_id; ?>" type="text" name="student_class_no" value="<?php echo $student->student_class_no; ?>" /></td>
                <td><input onkeyup="update_student_info('<?php echo $student->student_id; ?>')" id="student_name_<?php echo $student->student_id; ?>" type="text" name="student_name" value="<?php echo $student->student_name; ?>" /></td>
                <td><input min="0" max="100"  tabindex="<?php echo $count; ?>" type="text" id="student_marks_<?php echo $student->student_id; ?>" name="student_marks[<?php echo $student->student_id; ?>][marks]" value="0" /></td>
              </tr>
              <?php 
			  $count++;
			  
			  $student_id.= $student->student_id.", ";
			  
			  
			  endforeach; ?>
              <tr>
                <td colspan="4"><?php
                $submit = array(
                    "type"  =>  "submit",
                    "name"  =>  "submit",
                    "value" =>  $this->lang->line('Save'),
					 "class" =>  "btn btn-primary",
                    "style" =>  ""
                );
                echo form_submit($submit); 
            ?></td>
              </tr>
            </tbody>
          </table>
          <?php echo form_close(); ?> </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER --> 
</div>
<script>

function convert_numbers(){
	//alert();
		
		var numbers = [<?php echo $student_id; ?>];
numbers.forEach(myFunction);

function myFunction(value, index, array) {
	
	var assinged_total_marks = $('#assinged_total_marks').val();
		var actual_marks_marks = $('#actual_marks_marks').val();
	
   // txt = txt + value + "<br>"; 
   var student_obtain_marks = $('#student_marks_'+value).val();
   console.log(assinged_total_marks);
	$('#student_marks_'+value).val(Math.ceil((actual_marks_marks*student_obtain_marks)/assinged_total_marks));
	
}
		
		}

</script>