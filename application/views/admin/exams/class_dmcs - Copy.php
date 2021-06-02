<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />
<!-- JQUERY -->
<script src="<?php echo site_url("assets/".ADMIN_DIR."js/jquery/jquery-2.0.3.min.js"); ?>"></script>

<!-- BOOTSTRAP -->
<script  src="<?php echo site_url("assets/".ADMIN_DIR."bootstrap-dist/js/bootstrap.min.js"); ?>"></script>
<head>
</head>
<body>

<!-- /PAGE HEADER --> 

<!-- PAGE MAIN CONTENT -->
<div class="row" style='font-size:12px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif; '>
<!-- MESSENGER -->
<div class="col-md-12">
<div class="container">
<section>
<style>
table {
    border-collapse: collapse;
}

thead {
  font-weight:bold;
}

table, th, td {
    border: 1px solid #CCC !important;
	padding:2px !important;
}
      </style>
<?php 
			  $count=1;
			  foreach($students as $student): ?>
              
              
              
              <div style="width:22% !important; float:left;  margin-right:20px !important;  margin-bottom:15px !important; border:1px dashed #999999; padding:5px">
              <div style="text-align:center !important; margin-bottom:10px !important">
              
               
              
              <img src="<?php echo site_url("assets/admin/images/kpese.png"); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:30px !important; float:right;">
              
              
              <img src="<?php echo site_url("assets/uploads/".$system_global_settings[0]->sytem_admin_logo); ?>" alt="<?php echo $system_global_settings[0]->system_title ?>" title="<?php echo $system_global_settings[0]->system_title ?>" class="img-responsive " style="width:30px !important; float:left;"> 
              
               <h4 style="margin:5px !important;">GCMHS For Boys Chitral</h4>
        <h5 style="margin:1px !important;"> DMC <?php echo $class_name; ?> (<?php echo $section_title; ?>) <?php echo $exam->term. " ".$exam->year  ?> </h5>
        
       
              
              </div>
              <div style="margin:3px !important">
              Class No: <strong><?php echo $student->student_class_no; ?></strong> <br />
        Student Name: <strong><?php echo $student->student_name; ?></strong>
              </div>
              <table style="width:100% !important; font-size:11px"  >
  
  <tbody>
    
    <tr><th>Subjects</th><th>Total Marks</th><th>Obtain Marks</th></tr>
    <?php  
			  $promoted = 0;
			  $passed = 0;
			  $fail = 0;
			  $total_subject_marks =0;
			 // foreach($class_subjects as $class_subject){?>
    <?php  
			 $grant_total = 0;
			// var_dump($class_subjects);
			 foreach($class_subjects as $class_subject){?>
    <tr>
      <td><?php   echo $class_subject->subject_title; ?></td>
      <td><?php  $total_subject_marks+=$class_subject->marks; echo $class_subject->marks; ?></td>
      <td
             <?php if($student->subjects[$class_subject->class_subject_id]['passing_mark']=='M' || $student->subjects[$class_subject->class_subject_id]['passing_mark']=='A' ){ ?>
             style=" font-style:oblique; font-weight:bold"
             <?php } ?>
             ><?php  
			 $grant_total+=$student->subjects[$class_subject->class_subject_id]['passing_mark'];
			 echo $student->subjects[$class_subject->class_subject_id]['passing_mark']; ?></td>
      <?php } ?>
    </tr>
    <tr>
      <?php //} ?>
      <td style="text-align:right !important"> <strong>Total</strong></td>
      <td><?php echo $total_subject_marks; ?></td>
      <td><strong><?php echo $grant_total; ?></strong></td>
    </tr>
    <tr>
      <td colspan="2">Percentage </td>
      <td><?php echo $percentage = round((($grant_total*100)/$total_subject_marks),2); ?> %</td>
    </tr>
    <tr>
      <td>Remarks</td>
      <td colspan="2"><em>
        <?php 
			  if($percentage>=33){
				  $passed++;
				  //echo "<strong>Passed</strong>";
				  }else{
					 if($percentage>18.5){
						 $promoted++;
						// echo "<strong>Promoted</strong>";
						 }else{
							 $fail++;
							//echo "Failed"; 
							 } 
					  
					  }
			  ?>
        </em></td>
    </tr>
  </tbody>
</table>
              
              </div>
              
              

<?php endforeach; ?>
