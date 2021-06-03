<!-- PAGE HEADER-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url("student/class_and_section/"); ?>"> Classes and Sections</a> </li>
        <li><?php echo $title; ?></li>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="row"> </div>
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
        <h4><i class="fa fa-bell"></i> <?php echo $students[0]->Class_title . ""; ?> <?php echo $title; ?></h4>
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
        <div class="table-responsive">
          <div id="message"> </div>
          <?php
          $students = array();
          foreach ($sections as $section_name => $students) {

          ?>
            <div class="col-md-6">
              <div>
                <h3>
                  <style>
                    .dot {
                      height: 25px;
                      width: 25px;
                      background-color: #bbb;
                      border-radius: 50%;
                      display: inline-block;
                    }
                  </style>
                  <span class="dot" style="background:<?php echo $section_name  ?>;  "></span><?php echo $section_name ?>
                </h3>

              </div>
              <table class="table table-bordered " style="font-size:12px !important">
                <thead>
                  <tr>
                    <td colspan="2"><?php
                                    $add_form_attr = array("class" => "form-horizontal");
                                    echo form_open_multipart("student/save_student_data/", $add_form_attr);
                                    ?>

                      <input type="hidden" name="student_data_of_birth" value="1-1-2000" id="student_data_of_birth" class="form-control" style="" required="required" title="Data Of Birth" placeholder="Data Of Birth">
                      <input type="hidden" name="student_address" value="NULL" id="student_address" class="form-control" style="" title="Address" required="required" placeholder="Address" />

                      <input type="hidden" name="student_image" value="" id="student_image" class="form-control" style="" title="Image" placeholder="Image">
                      <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
                      <input type="hidden" name="section_id" value="<?php echo $students[0]->section_id ?>" />
                      <input style="width:40px !important" type="text" name="student_class_no" value="" id="student_class_no" class="" style="" required="required" title="Class No" placeholder="Class No">
                    </td>

                    <td><input style="width:50px !important" type="text" name="student_admission_no" value="00000" id="student_admission_no" class="fo rm-control" style="" required="required" title="Admission No" placeholder="Admission No"></td>

                    <td><input type="text" name="student_name" value="" id="student_name" class="" style="" required="required" title="Student Name" placeholder="Student Name"></td>
                    <td><input type="text" name="student_father_name" value="" id="student_father_name" class="f orm-control" style="" required="required" title="Father Name" placeholder="Father Name"></td>

                    <td><input type="submit" name="submit" value="Add" class="bt n btn-pri mary" style="">
                      <?php echo form_close(); ?></td>
                  </tr>
                </thead>
              </table>

              <table class="table table-bordered " id="<?php echo $section_name  ?>" style="font-size:12px !important">
                <thead>

                  <tr>
                    <td></td>
                    <td>#</td>
                    <th><?php echo $this->lang->line('student_class_no'); ?></th>
                    <th><?php echo $this->lang->line('student_admission_no'); ?></th>
                    <th><?php echo $this->lang->line('student_name'); ?></th>

                    <!-- <th><?php echo $this->lang->line('student_father_name'); ?></th>
                <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
                <th><?php echo $this->lang->line('student_address'); ?></th>
                <th><?php echo $this->lang->line('student_admission_no'); ?></th>
                <th><?php echo $this->lang->line('student_image'); ?></th>
                <th><?php echo $this->lang->line('Class_title'); ?></th>-->
                    <th><?php echo $this->lang->line('section_title'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // var_dump($students);
                  $count = 1;
                  foreach ($students as $student) :
                  ?>
                    <tr <?php if ($student->status == 0) { ?>style="background-color: coral;" <?php } ?>>
                      <td>
                        <!-- <a class="btn btn-danger btn-sm" onclick="return confirm('are you sure? may remove student over data?')" href="<?php echo site_url(ADMIN_DIR . "students/remove_student/$exam_id/$class_id/$section_id/$class_subject_id/$subject_id/$student->student_id") ?>" >Remove student</a> -->

                        <?php if ($student->status == 0) { ?>
                          <a href="<?php echo site_url("student/active_student/$class_id/$section_id/$student->student_id") ?>"><i class="fa fa-undo"></i></a>
                        <?php } else { ?>

                          <a href="<?php echo site_url("student/dormant_student/$class_id/$section_id/$student->student_id") ?>"><i class="fa fa-times"></i></a>
                        <?php   } ?>



                      </td>
                      <td><?php echo $count++; ?></td>
                      <td><?php echo $student->student_class_no; ?>
                        <input style="width:40px !important" onkeyup="update_student_info('<?php echo $student->student_id; ?>')" id="student_class_no_<?php echo $student->student_id; ?>" type="number" name="student_class_no" value="<?php echo $student->student_class_no; ?>" />
                      </td>

                      <td><?php echo $student->student_admission_no; ?>
                        <input onkeyup="update_student_admission_no('<?php echo $student->student_id; ?>')" id="student_admission_no_<?php echo $student->student_id; ?>" type="number" name="student_admission_no" value="<?php echo $student->student_admission_no; ?>" />
                      </td>

                      <td><?php echo $student->student_name; ?>
                        <input onkeyup="update_student_info('<?php echo $student->student_id; ?>')" id="student_name_<?php echo $student->student_id; ?>" type="text" name="student_name" value="<?php echo $student->student_name; ?>" />
                      </td>

                      <td><?php echo $student->section_title; ?>
                        <?php

                        $sections = $this->student_model->getList("sections", "section_id", "section_title", $where = "");

                        ?>
                        <form action="<?php echo site_url("student/update_student_section") ?>" method="post">
                          <input type="hidden" name="student_id" value="<?php echo $student->student_id ?>" />
                          <input type="hidden" name="class_id" value="<?php echo $student->class_id ?>" />
                          <input type="hidden" name="section_id" value="<?php echo $student->section_id ?>" />
                          <?php
                          echo form_dropdown("student_section_id", array("0" => "Select Section") + $sections, "", "class=\"for m-control\" style=\"width:60px !important\" required  onchange=\"this.form.submit()\" ");
                          ?>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach;  ?>
                </tbody>
              </table>
            </div>
            <script>
              $(document).ready(function() {
                $('#<?php echo $section_name  ?>').DataTable({
                  "pageLength": 50,
                  "lengthChange": false
                });
              });
            </script>
          <?php } ?>
          <?php echo $pagination; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER -->
</div>
<script>
  function update_student_info(student_id) {

    var student_class_no = $('#student_class_no_' + student_id).val();
    var student_name = $('#student_name_' + student_id).val();
    $.ajax({
      type: "POST",
      url: "<?php echo site_url("student/update_student_info") ?>/" + student_id,
      data: {
        student_class_no: student_class_no,
        student_name: student_name
      }
    }).done(function(msg) {
      $("#message").html(msg);
      $("#message").fadeIn('slow');
      $("#message").delay(5000).fadeOut('slow');
    });

  }







  function update_student_admission_no(student_id) {

    var student_admission_no = $('#student_admission_no_' + student_id).val();

    $.ajax({
      type: "POST",
      url: "<?php echo site_url("student/update_student_admission_no") ?>/" + student_id,
      data: {
        student_admission_no: student_admission_no
      }
    }).done(function(msg) {
      /*//alert(msg);  
      						$("#message").html(msg);
      						$("#message").fadeIn('slow');
      						$("#message").delay(5000).fadeOut('slow');*/
    });

  }
</script>



<link href="<?php echo site_url(); ?>/assets/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" />