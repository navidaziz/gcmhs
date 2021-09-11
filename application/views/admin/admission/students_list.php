<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dat aTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url(ADMIN_DIR . "admission/"); ?>"> Admission</a> </li>
        <li><?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> List</li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="col-md-6">
        <div class="clearfix">
          <h3 class="content-title pull-left"> <?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?> List</h3>
        </div>
        <div class="description" id="message"></div>
      </div>

    </div>
  </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-12" style="background-color: white; padding: 5px;">

    <table class="table table-bordered" id="main_table">
      <thead>

        <tr>

          <td>#</td>
          <th>C/No</th>
          <th>Add. No</th>
          <th>Name</th>

          <th>Father Name</th>
          <th>DOB</th>
          <th>Address</th>
          <th>Mobile No</th>
          <th>Father NIC</th>
          <th>Guardian Occupation</th>

          <th>Religion</th>
          <th>Nationality</th>
          <th>Admission Date</th>
          <th>Private / Public School</th>
          <th>School Name</th>
          <th>Orphan</th>

        </tr>
      </thead>
      <tbody>
        <?php
        $students = array();
        $all_sections = $sections;
        foreach ($sections as $section_name => $students) {
          $count = 1;
          foreach ($students as $student) :
        ?>
            <tr>

              <td id="count_number"><?php echo $count++; ?></td>
              <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td>
              <td><span><?php echo $student->student_admission_no; ?></span></td>
              <td><span><?php echo $student->student_name;  ?></span></td>
              <td><?php echo $student->student_father_name;  ?></td>
              <td><?php echo $student->student_data_of_birth; ?> </td>
              <td><?php echo $student->student_address; ?></td>
              <td><?php echo $student->father_mobile_number; ?></td>
              <td><?php echo $student->father_nic; ?></td>
              <td><?php echo $student->guardian_occupation; ?></td>
              <td><?php echo $student->religion; ?></td>
              <td><?php echo $student->nationality; ?></td>
              <td><?php echo $student->admission_date; ?></td>
              <td><?php echo $student->private_public_school; ?></td>
              <td><?php echo $student->school_name; ?></td>
              <td><?php echo $student->orphan; ?></td>

            </tr>
          <?php endforeach;  ?>
        <?php } ?>
      </tbody>
    </table>
  </div>
  <script>
    $(document).ready(function() {
      $('#main_table').DataTable({
        "pageLength": 65,
        "lengthChange": false
      });
    });
  </script>


</div>
<!-- /MESSENGER -->
</div>