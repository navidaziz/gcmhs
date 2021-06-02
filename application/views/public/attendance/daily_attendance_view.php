

  <div class="row" style="font-size:10px !important">
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
         <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
 
 
 
 <?php foreach($classes as $class){ ?>

 <?php 
 
 $count=0;
 foreach($class->sections as $section){ 
 $query='SELECT * FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class->class_id.'
					AND `section_id` ='.$section->section_id;
			$query_result = $this->db->query($query);
			$today_attendance = $query_result->result()[0];
			//var_dump($today_attendance);
 ?>


    <tr style="padding:0px !important; margin:0px !important;" >
    <?php if($count==0){ ?>
    <td style="padding:3px !important; margin:0px !important;" rowspan="<?php echo count($class->sections) ?>" ><?php echo $class->Class_title; ?></td>
    <?php  $count++; }  ?>
      <td style="padding:3px !important; margin:0px !important; background-color:<?php echo $section->color; ?>;" ><?php echo $section->section_title; ?></th>
      <td style="padding:3px !important; margin:0px !important;"><?php echo $today_attendance->present; ?></td>
      <td style="padding:3px !important; margin:0px !important;"><?php echo $today_attendance->absent; ?></td>
      <td style="padding:3px !important; margin:0px !important;"><?php echo $today_attendance->leave; ?></td>
      <td style="padding:3px !important; margin:0px !important;"><?php echo $today_attendance->sick; ?></td>
      <td style="padding:3px !important; margin:0px !important;"><?php echo $today_attendance->total; ?></td>
      <td style="padding:3px !important; margin:0px !important;"><a href="javascript:;" onclick="update_record('Update <?php echo $class->Class_title; ?> / <?php echo $section->section_title; ?> Attendance Record', '<?php echo $today_attendance->daily_attendance_id; ?>', '<?php echo $today_attendance->present; ?>', '<?php echo $today_attendance->absent; ?>','<?php echo $today_attendance->leave; ?>','<?php echo $today_attendance->sick; ?>','<?php echo $today_attendance->total; ?>',  )" >Edit</a></td>
    </tr>
 

  <?php } ?>
  
  <tr style="padding:0px !important; margin:0px !important;" >
   <td style="padding:3px !important; margin:0px !important;"  ></td>
      <th style="padding:3px !important; margin:0px !important;" >Total</th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`present`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class->class_id;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?></th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`absent`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class->class_id;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?></th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`leave`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class->class_id;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?>
      </th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`sick`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class->class_id;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?></th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`total`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session.'
					AND `class_id` ='.$class->class_id;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?></th>
       <th></th>
    </tr>
  <tr>
    <td colspan="8" style="padding:1px !important; margin:0px !important;">
   <hr style="margin:0px !important; padding:0px !important" />
    </td>
    </tr>
 <?php } ?>
  <tr style="padding:0px !important; margin:0px !important;" >
   <td style="padding:3px !important; margin:0px !important;"  ></td>
      <th style="padding:3px !important; margin:0px !important;" >Total</th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`present`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
			
			$total_present = $query_result->result()[0]->total;
	  
	   ?></th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`absent`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?></th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`leave`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?>
      </th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`sick`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
	  
	   ?></th>
      <th style="padding:3px !important; margin:0px !important;"><?php 
	  		$query='SELECT SUM(`total`) as `total` FROM `daily_attendances` 
					WHERE DATE(`created_date`) = CURDATE()
					AND `session_id` ='.$current_session;
			$query_result = $this->db->query($query);
			echo $query_result->result()[0]->total;
			
			$total_student = $query_result->result()[0]->total;
	  
	   ?></th>
       <th></th>
       
    </tr>
    
    <tr><td clospna="7"><?php echo round(($total_present*100)/$total_student,2); ?>% Students Present today</td></tr>
 
  </tbody>
</table>
 </form>
</div>
</div>
</div>



<script>

function update_record(title, daily_attendance_id, present, absent,leave, sick, total ){
	//alert(daily_attendance_id);
	
	$('#present').val(present);
	$('#absent').val(absent);
	$('#leave').val(leave);
	$('#sick').val(sick);
	$('#total').val(total);
	
	$('#daily_attendance_id').val(daily_attendance_id);
	$('#update_record_model_title').html(title);
	$('#update_record_model').modal('show');
	
	}

function update_total(){
	//alert();
	var present = $('#present').val();
	var absent = $('#absent').val();
	//var leave = $('#leave_'+class_id+'_'+section_id).val();
	//var sick = $('#sick_'+class_id+'_'+section_id).val();
	var total = parseInt(present)+parseInt(absent);
	$('#total').val(total);
	}

</script>




  <!-- Modal -->
  <div class="modal fade" id="update_record_model" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 id="update_record_model_title" class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          
          
          
          
          <form action="<?php echo site_url("attendance/update_attandance"); ?>" method="post" >
          
          <input type="hidden" id="daily_attendance_id" name="daily_attendance_id" value="0"  />

<table class="table" style="width:100% !important">
  <thead>
    
  </thead>
  <tbody>
 <tr>
      <th scope="col">Present</th>
      <td><input type="text" onkeyup="update_total()" id="present" name="present"  /></td>
      </tr>
      <tr>
      <th scope="col">Absent</th>
      <td><input type="text" onkeyup="update_total()" id="absent" name="absent"  /></td>
      </tr>
      <tr>
      <th scope="col">leave</th>
      <td><input type="text" id="leave" name="leave"  /></td>
      </tr>
      <tr>
       <th scope="col">Sick</th>
       <td><input type="text" id="sick" name="sick"  /></td>
      </tr>
      <tr>
        <th scope="col">Total</th>
        <td><input readonly="readonly" type="text" id="total" name="total"  /></td>
      </tr>
     <tr>
        <th scope="col">Update</th>
        <td><input  type="submit" value="Update" name="Update"  /></td>
      </tr>
 
  </tbody>
</table>
 </form>
          
          
          
          
          
          
          
        </div>
        <!--<div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>-->
      </div>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>