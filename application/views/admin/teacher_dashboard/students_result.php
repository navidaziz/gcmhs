<div id="update_result" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title pull-left" id="">Update Result</h5>
        <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br />
      </div>
      <div class="modal-body">
        <?php echo $exam->year . " " . $exam->term; ?><br />
        <?php echo $students[0]->Class_title . " (" . $students[0]->section_title . ")"; ?> - Subject <?php echo $class_subject . ""; ?></h5>

        <h4 id="update_result_body">Please Wait .....</h4>
        <p style="text-align: center;">


        <form action="<?php echo site_url(ADMIN_DIR . "teacher_dashboard/update_student_subject_result") ?>" method="post" style="text-align: center;">
          <input type="hidden" name="student_exam_subject_mark_id" id="student_exam_subject_mark_id" value="" />
          <input type="hidden" name="class_id" id="class_id" value="<?php echo $class_id; ?>" />
          <input type="hidden" name="section_id" id="section_id" value="<?php echo $section_id; ?>" />
          <input type="hidden" name="exam_id" id="exam_id" value="<?php echo $exam_id; ?>" />

          <input type="hidden" name="class_subject_id" id="class_subject_id" value="<?php echo $class_subject_id; ?>" />

          <input type="hidden" name="subject_id" id="subject_id" value="<?php echo $subject_id; ?>" />




          <table style="width: 100%;">

            <tr>
              <td> Total Marks:
              </td>
              <td>
                <input readonly type="text" name="total_marks" id="total_marks" value="" />
              </td>
            </tr>
            <tr>
              <td> Obtain Marks:
              </td>
              <td>
                <input required class="result_entry" type="text" name="obtain_mark" id="obtain_mark" value="" />
              </td>
            </tr>
            <tr>
              <td colspan="2"><input type="submit" class="btn btn-success btn-sm" value="Update Result" /></td>
            </tr>

          </table>


        </form>
        </p>
      </div>

    </div>
  </div>
</div>

<script>
  function update_result(student_id, name, father_name, add_no, student_exam_subject_mark_id, total_marks, obtain_mark) {
    var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
    $("#student_exam_subject_mark_id").val(student_exam_subject_mark_id);
    $("#total_marks").val(total_marks);
    $("#obtain_mark").val(obtain_mark);
    $('#update_result_body').html(body);
    $('#update_result').modal('show');
  }
</script>

<script>
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

      student_marks = parseInt($('#obtain_mark').val());
      total_marks = parseInt($('#total_marks').val());
      if (isNaN(total_marks)) {
        alert("Enter Total Marks First In Number.");
        $('#obtain_mark').val("");
      } else {
        if (total_marks <= 0) {
          alert("Total marks must be greater than 0.");
          $('#obtain_mark').val("");
        }
      }
      if (student_marks < 0 || student_marks > total_marks) {
        alert("Student obtain marks must be greater or equal than 0 and less than total marks.");
        $('#obtain_mark').val("");

      }


    });
  });
</script>

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


        <table id="example" class="table1" cellspacing="0" width="100%" style="font-size:11px; text-align: left !important; ">

          <thead>
            <tr>

              <th>#</th>
              <th>C No.</th>
              <th>Add No.</th>
              <th>Name</th>
              <th>Total</th>
              <th>Obta.</th>
              <th>%age</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $count = 1;
            $student_id = '';
            foreach ($students as $student) :
            ?>
              <tr>

                <td><?php echo $count; ?></td>
                <td><?php echo $student->student_class_no; ?></td>
                <td><?php echo $student->student_admission_no; ?></td>
                <td> <a data-content="Father Name: <?php echo $student->student_father_name; ?>. Father NIC:  
                                        <?php echo $student->father_nic; ?>. Father Mobile No: <?php echo $student->father_mobile_number; ?> <br />
                                        " tabindex="<?php echo $count; ?>" role="button" data-toggle="popover" data-trigger="focus" class="pop-top" data-title="Top" data-toggle="popover" data-original-title="" title="<?php echo $student->student_name; ?>">
                    <?php echo $student->student_name; ?>

                    <i class="fa fa-info-circle pull-right" aria-hidden="true" style="margin-right: 15px;"></i>
                  </a></td>
                <?php if ($student->obtain_mark >= 0) { ?>
                  <td style="text-align: center;"><?php
                                                  $percentage  = @round(($student->obtain_mark * 100 / $student->total_marks));
                                                  echo $student->total_marks; ?></td>
                  <td style="text-align: center;">
                    <?php if ($percentage < 33) { ?>
                      <span style="  color: red; display: inline-block;
                                                        width: 20px;
                                                        min-height: 20px;
                                                        padding: 3px;
                                                        color: red;
                                                        line-height: 1;
                                                        vertical-align: baseline;
                                                        white-space: nowrap;
                                                        text-align: center;
                                                        border:1px solid red;
                                                        border-radius: 10px;">
                        <?php echo $student->obtain_mark; ?></span>
                    <?php } else { ?>
                      <?php echo $student->obtain_mark; ?>
                    <?php } ?>
                  </td>
                  <td style="text-align: center;
                <?php if ($percentage < 33) { ?>
                  color: red;
                <?php } ?>
                "><?php echo $percentage . " %"; ?></td>
                  <td>
                    <a href="#" onclick="update_result('<?php echo $student->student_id ?>', 
                    '<?php echo $student->student_name ?>', 
                    '<?php echo $student->student_father_name ?>', 
                    '<?php echo $student->student_admission_no ?>', 
                    '<?php echo $student->student_exam_subject_mark_id ?>','<?php echo $student->total_marks; ?>', '<?php echo $student->obtain_mark; ?>' )"> Edit</a>
                  </td>
                <?php } else { ?>
                  <td colspan="4">Result Not Added</td>
                <?php } ?>
              </tr>
            <?php
              $count++;

              $student_id .= $student->student_id . ", ";


            endforeach; ?>

          </tbody>
        </table>
        <?php echo form_close(); ?>

      </div>



    </div>
  </div>
  <!-- /MESSENGER -->
</div>