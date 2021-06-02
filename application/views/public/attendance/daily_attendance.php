

<!-- MESSENGER -->

<script>
function update_total(class_id, section_id){
	//alert();
	var present = $('#present_'+class_id+'_'+section_id).val();
	var absent = $('#absent_'+class_id+'_'+section_id).val();
	//var leave = $('#leave_'+class_id+'_'+section_id).val();
	//var sick = $('#sick_'+class_id+'_'+section_id).val();
	var total = parseInt(present)+parseInt(absent);
	$('#total_'+class_id+'_'+section_id).val(total);
	}
</script>

  <div class="row" style="font-size:9px !important">
<div class="col-md-3">

<div class="list-group">
<h5 style="text-align:center !important">GCMHS Boys Chitral Today Attendance</h5>
 <form action="<?php echo site_url("attendance/save_today_attendance"); ?>" method="post" >

<table class="table" style="width:100% !important">
  <thead>
    <tr>
    <th></th>
      <th scope="col">Section</th>
      <th scope="col">Present</th>
      <th scope="col">Absent</th>
      <th scope="col">leave</th>
       <th scope="col">Sick</th>
        <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>
 
 
 
 <?php foreach($classes as $class){ ?>

 <?php 
 
 $count=0;
 foreach($class->sections as $section){ ?>


    <tr style="padding:0px !important; margin:0px !important;" >
    <?php if($count==0){ ?>
    <td style="padding:3px !important; margin:0px !important;" rowspan="<?php echo count($class->sections) ?>" ><?php echo $class->Class_title; ?></td>
    <?php  $count++; }  ?>
      <td style="padding:3px !important; margin:0px !important; background-color:<?php echo $section->color; ?>;" ><?php echo $section->section_title; ?></th>
      <td style="padding:3px !important; margin:0px !important;"><input onfocus="this.value = this.value;" onkeyup="update_total(<?php echo $class->class_id; ?>, <?php echo $section->section_id; ?>)"  type="text" value="0" id="present_<?php echo $class->class_id; ?>_<?php echo $section->section_id; ?>" name="daily_attendance[<?php echo $class->class_id; ?>][<?php echo $section->section_id; ?>][present]" style="width:30px !important" data-dependency="absent" /></td>
      <td style="padding:3px !important; margin:0px !important;"><input onfocus="this.value = this.value;" onkeyup="update_total(<?php echo $class->class_id; ?>, <?php echo $section->section_id; ?>)" type="text" value="0" id="absent_<?php echo $class->class_id; ?>_<?php echo $section->section_id; ?>" name="daily_attendance[<?php echo $class->class_id; ?>][<?php echo $section->section_id; ?>][absent]" style="width:30px !important" data-dependency="leave" /></td>
      <td style="padding:3px !important; margin:0px !important;"><input onfocus="this.value = this.value;" onkeyup="update_total(<?php echo $class->class_id; ?>, <?php echo $section->section_id; ?>)" type="text" value="0" name="daily_attendance[<?php echo $class->class_id; ?>][<?php echo $section->section_id; ?>][leave]"  id="leave_<?php echo $class->class_id; ?>_<?php echo $section->section_id; ?>" style="width:30px !important" data-dependency="sick" /></td>
      <td style="padding:3px !important; margin:0px !important;"><input onfocus="this.value = this.value;" onkeyup="update_total(<?php echo $class->class_id; ?>, <?php echo $section->section_id; ?>)" type="text" value="0" id="sick_<?php echo $class->class_id; ?>_<?php echo $section->section_id; ?>" name="daily_attendance[<?php echo $class->class_id; ?>][<?php echo $section->section_id; ?>][sick]" style="width:30px !important" data-dependency="total" /></td>
      <td style="padding:3px !important; margin:0px !important;"><input   type="text" value="0" id="total_<?php echo $class->class_id; ?>_<?php echo $section->section_id; ?>" name="daily_attendance[<?php echo $class->class_id; ?>][<?php echo $section->section_id; ?>][total]" style="width:50px !important" readonly="readonly" /></td>
    </tr>
 

  <?php } ?>
  <tr>
    <td colspan="7" style="padding:1px !important; margin:0px !important;">
   <hr style="margin:0px !important; padding:0px !important" />
    </td>
    </tr>
 <?php } ?>
  <tr>
    <td colspan="7" style="text-align:center !important; padding:5px !important; margin:0px !important;">
    <input class="btn btn-success btn-sm" type="submit" name="save" value="Add Today Attendance" />
    </td>
    </tr>
 
  </tbody>
</table>
 </form>
</div>
</div>
</div>






