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
                <td><?php echo $student->student_admission_no; ?></td>
                <td> <a data-content="Father Name: <?php echo $student->student_father_name; ?>. Father NIC:  
                                        <?php echo $student->father_nic; ?>. Father Mobile No: <?php echo $student->father_mobile_number; ?> <br />
                                        " tabindex="<?php echo $count; ?>" role="button" data-toggle="popover" data-trigger="focus" class="pop-top" data-title="Top" data-toggle="popover" data-original-title="" title="<?php echo $student->student_name; ?>">
                    <?php echo $student->student_name; ?>

                    <i class="fa fa-info-circle pull-right" aria-hidden="true" style="margin-right: 15px;"></i>
                  </a></td>
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