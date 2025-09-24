<div class="row" style="height: 38px !important;">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 30px !important">
      <ul class="breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
        </li>
        <li>Result Marks Entry Form</li>
      </ul>


    </div>
  </div>
</div>

<div class="row" style="margin-left: -25px; margin-right: -23px;">
  <!-- MESSENGER -->
  <div class="col-md-12">
    <div class="box-body" style="background-color: white !important; margin-top: 10px; text-align: center; padding: 3px;">
      <style>
        .table1 tr,
        td {
          padding: 1px;
          border-collapse: collapse;
          border-bottom: 1px solid #D3D3D3;
        }
      </style>

      <div class="table-res ponsive" style="padding: 5px;">
        <h5>
          <?php echo $exam->year . " " . $exam->term; ?><br />
          <?php echo $students[0]->Class_title . " (" . $students[0]->section_title . ")"; ?> - Subject <?php echo $class_subject . ""; ?></h5>

        <script>
          function validate_data(id) {
            student_marks = parseInt($('#student_marks_' + id).val());
            total_marks = parseInt($('#total_marks').val());
            if (isNaN(total_marks)) {
              alert("Enter Total Marks First In Number.");
              $('#student_marks_' + id).val("");
            } else {
              if (total_marks <= 0) {
                alert("Total marks must be greater than 0.");
                $('#student_marks_' + id).val("");
              }
            }
            if (student_marks < 0 || student_marks > total_marks) {
              alert("Student obtain marks must be greater or equal than 0 and less than total marks.");
              $('#student_marks_' + id).val("");

            }

          }
          $(document).ready(function() {
            $(".result_entry").on('keyup', function() {
              var value = $(this).val();
              if (isNaN(value)) {
                if (value.toUpperCase() != 'A') {
                  $(this).val("");
                } else {
                  $(this).val("A");
                }
              }
              if (value == '00') {
                $(this).prop("type", "text");
                $(this).val("A");

              }
            });
          });
        </script>


        <?php
        $add_form_attr = array("class" => "form-horizontal");
        echo form_open_multipart(ADMIN_DIR . "teacher_dashboard/save_student_result", $add_form_attr);
        ?>
        <span style="margin:5px;" class="pull-right">
          <input required="required" type="hidden" name="class_teacher" value="NULL" placeholder="Class Teacher">
          <input required="required" type="hidden" name="paper_checked_by" value="NULL" placeholder="Paper Checked By">
        </span>
        <input type="hidden" name="class_id" value="<?php echo $class_id ?>" />
        <input type="hidden" name="section_id" value="<?php echo $section_id ?>" />
        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
        <input type="hidden" name="exam_id" value="<?php echo $exam_id ?>" />
        <input type="hidden" name="class_subject_id" value="<?php echo $class_subject_id; ?>" />
        <h6 style="color:red; border: 1px dashed red; border-radius: 5px; padding: 3px;">Note: For Absent students just write 00.</h6>

        Subject Test / Exam Total Marks <input readonly inputmode="numeric" type="number" id="total_marks" value="100" name="total_marks" style="width: 70px;" />
        <table id="example" class="table1" cellspacing="0" width="100%" style="font-size:11px; text-align: left !important; ">

          <thead>
            <tr>

              <th>#</th>
              <th>C No.</th>
              <!-- <th>Add No.</th> -->
              <th>Name</th>
              <th>MCQs Results</th>
              <th>Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            $student_id = '';
            foreach ($students as $student) : ?>
              <tr>

                <td><?php echo $count; ?></td>
                <td><?php echo $student->student_class_no; ?></td>
                <!-- <td><?php echo $student->student_admission_no; ?></td> -->
                <td> <a data-content="Father Name: <?php echo $student->student_father_name; ?>. Father NIC:  
                                        <?php echo $student->father_nic; ?>. Father Mobile No: <?php echo $student->father_mobile_number; ?> <br />
                                        " tabindex="<?php echo $count; ?>" role="button" data-toggle="popover" data-trigger="focus" class="pop-top" data-title="Top" data-toggle="popover" data-original-title="" title="<?php echo $student->student_name; ?>">
                    <?php echo $student->student_name; ?>

                    <i class="fa fa-info-circle pull-right" aria-hidden="true" style="margin-right: 15px;"></i>
                  </a></td>
                <th>
                  <?php
                  $query = "SELECT * FROM `students_exams_subjects_marks` 
                  WHERE exam_id = 20 
                  AND class_subjec_id = ?
                  AND student_id = ?";
                  $mcqs_result = $this->db->query($query, [$class_subject_id, $student->student_id])->row();
                  if ($mcqs_result) {
                    $mcqResult = $mcqs_result->obtain_mark;
                    //echo $mcqs_result->obtain_mark . "/" . $mcqs_result->total_marks;
                  } else {
                    //echo "N/A";
                    $mcqResult = 'M';
                  }

                  ?>
                  <?php echo $mcqResult; ?>
                  <?php if ($mcqResult != 'A' or $mcqResult != 'M') { ?>

                    <input style="width: 50px;" min="0" max="30" type="number" name="mcq_marks" id="mcq_marks_<?php echo $student->student_id; ?>" value="<?php echo $mcqResult; ?>" /> +

                  <?php } else { ?>

                    <input style="width: 50px;" min="0" max="30" type="hidden" name="mcq_marks" id="mcq_marks_<?php echo $student->student_id; ?>" value="0" /> +

                  <?php } ?>
                  <input style="width: 50px;" min="0" max="70" type="number" name="semester_result" id="semester_result_<?php echo $student->student_id; ?>" onkeyup="add_mcqs_semester_result('<?php echo $student->student_id; ?>')" />
                </th>
                <td><input inputmode="numeric" class="result_entry" required="required" onkeyup="validate_data('<?php echo $student->student_id; ?>')" style="width: 50px;" min="0" max="100" tabindex="<?php echo $count; ?>" id="student_marks_<?php echo $student->student_id; ?>" name="student_marks[<?php echo $student->student_id; ?>][marks]" value="" /></td>
              </tr>
            <?php
              $count++;

              $student_id .= $student->student_id . ", ";


            endforeach; ?>
            <tr>
              <td colspan="5" style="text-align: center;"><?php
                                                          $submit = array(
                                                            "type"  =>  "submit",
                                                            "name"  =>  "submit",
                                                            "value" =>  "Save Student Result",
                                                            "class" =>  "btn btn-primary",
                                                            "style" =>  ""
                                                          );
                                                          echo form_submit($submit);
                                                          ?></td>
            </tr>
          </tbody>
        </table>
        <?php echo form_close(); ?>

      </div>



    </div>
  </div>
  <!-- /MESSENGER -->
</div>
<script>
  function add_mcqs_semester_result(student_id) {

    var mcq_marks = parseInt($('#mcq_marks_' + student_id).val());
    var semester_result = parseInt($('#semester_result_' + student_id).val());

    if (!isNaN(mcq_marks) && !isNaN(semester_result)) {
      var total = mcq_marks + semester_result;
      $('#student_marks_' + student_id).val(total);
    } else {
      $('#student_marks_' + student_id).val("");
    }
  }
  // $(document).ready(function() {
  //   $(".result_entry").on('keyup', function() {
  //     var value = $(this).val();
  //     if (isNaN(value)) {
  //       if (value.toUpperCase() != 'A') {
  //         $(this).val("");
  //       } else {
  //         $(this).val("A");
  //       }
  //     }
  //     if (value == '00') {
  //       $(this).prop("type", "text");
  //       $(this).val("A");

  //     }
  //   });
  // });
</script>