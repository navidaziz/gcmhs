<!-- PAGE HEADER-->
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
    <script>
      function select_check_box() {

        if ($("#select_all").is(':checked')) {
          $('.student_id_ck_box').attr('checked', true);
        } else {
          $('.student_id_ck_box').attr('checked', false);
        }
      }
    </script>
    <form action="<?php echo site_url(ADMIN_DIR . "admission/promote_to_next_section") ?>" method="post">
      <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
      <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />


      <table class="table table-bordered" id="main_table" style="font-size:12px !important">
        <thead>

          <tr>
            <td><input onclick="select_check_box()" type="checkbox" name="select_all" id="select_all" /></td>

            <td>#</td>
            <th><?php echo $this->lang->line('student_class_no'); ?></th>
            <td>Status</td>
            <th><?php echo $this->lang->line('student_admission_no'); ?></th>
            <th><?php echo $this->lang->line('student_name'); ?></th>

            <th><?php echo $this->lang->line('student_father_name'); ?></th>
            <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
            <th><?php echo $this->lang->line('student_address'); ?></th>
            <th>Session</th>
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
              <tr <?php if ($student->status == 0) { ?>style="background-color: coral;" <?php } ?>>
                <td>
                  <?php
                  $query = "SELECT * FROM session WHERE status=1";
                  $current_session_id = $this->db->query($query)->row()->session_id;

                  if ($current_session_id != $student->session_id) {
                  ?>
                    <input class="student_id_ck_box" type="checkbox" name="students[]" value="<?php echo $student->student_id; ?>" />
                  <?php } ?>
                </td>
                <td id="count_number"><?php echo $count++; ?></td>
                <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td>
                <td><?php
                    if ($student->status == 2) {
                      echo "Struck Off";
                    }
                    ?></td>

                <td><span><?php echo $student->student_admission_no; ?></span></td>
                <td><span><?php echo $student->student_name;  ?></span></td>
                <td><?php echo $student->student_father_name;  ?></td>
                <td><?php echo $student->student_data_of_birth; ?> </td>
                <td><?php echo $student->student_address; ?></td>
                <td><?php
                    $query = "SELECT `session` FROM session WHERE session_id = '" . $student->session_id . "'";
                    echo  $this->db->query($query)->result()[0]->session;
                    ?></td>

              </tr>
            <?php endforeach;  ?>
          <?php } ?>
        </tbody>
      </table>
      <div style="margin: 10px; padding:5px; text-align:right; border:1px solid gray; border-radious:1px">
        Promote
        Session <?php
                $current_session = $this->student_model->getList("session", "session_id", "session", $where = "`session`.`status` IN (0) ORDER BY session_id DESC LIMIT 1");
                echo form_dropdown("current_session", $current_session, "", "class=\"form-co ntrol\" required style=\"\"");
                ?>

        Class <strong><?php echo $students[0]->Class_title; ?>
        </strong> - Section <strong><?php echo $students[0]->section_title . ""; ?> </strong>
        Students
        To Class: <?php
                  $classes = $this->student_model->getList("classes", "class_id", "Class_title", $where = "class_id = '" . ($class_id + 1) . "'");
                  echo form_dropdown("to_class", array("" => "Select Class") + $classes, "", "class=\"form-co ntrol\" required style=\"\"");
                  ?>
        Section
        <?php
        $to_section = $this->student_model->getList("sections", "section_id", "section_title", $where = "");
        echo form_dropdown("to_section", array("" => "Select Section") +  $to_section, "", "class=\"form-co ntrol\" required style=\"\"");
        ?>

        for new session <?php
                        $classes = $this->student_model->getList("session", "session_id", "session", $where = "`session`.`status` IN(1)");
                        echo form_dropdown("new_session", $classes, "", "class=\"form-co ntrol\" required style=\"\"");
                        ?>

        <input type="submit" value="Promote" name="Promote" />
      </div>
    </form>
  </div>
  <script>
    $(document).ready(function() {
      $('#main_table').DataTable({
        "pageLength": 300,
        "lengthChange": false
      });
    });
  </script>


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
      $('#class_number').html(student_class_no);
      $('#count_number').html(student_class_no);
      $("#message").html(msg);
      $("#message").fadeIn('slow');
      $("#message").delay(5000).fadeOut('slow');

    });

  }





  function update_student_record(student_id, field) {

    var value = $('#' + field + '_' + student_id).val();

    $.ajax({
      type: "POST",
      url: "<?php echo site_url(ADMIN_DIR . "admission/update_student_record") ?>/",
      data: {
        student_id: student_id,
        value: value,
        field: field
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