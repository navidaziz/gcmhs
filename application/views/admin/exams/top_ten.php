<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />

<head>
</head>

<body>

  <!-- /PAGE HEADER -->

  <!-- PAGE MAIN CONTENT -->
  <div class="row" style='font-size:12px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;'>
    <!-- MESSENGER -->
    <div class="col-md-12">
      <div class="container">
        <section>
          <style>
            table {
              border-collapse: collapse;
            }

            thead {
              font-weight: bold;
            }

            table,
            th,
            td {
              border: 1px solid black;
              padding: 10px;
            }
          </style>
          <h1>GCMHS Boys Chitral</h1>
          <h2><?php echo $exam->year . " " . $exam->term; ?>, <br /> Top Ten Students List</h2>
          <div class="col-md-3">
            <h2>
              <table class="table table-bordered">
                <tr>
                  <th>#</th>
                  <th>Class No</th>
                  <th>Addmission No.</th>
                  <th>Student Name</th>
                  <th>Father Name</th>
                  <th>Contact No.</th>
                  <th>Class</th>
                  <th>Obtain Marks</th>
                  <th>Total Marks</th>
                  <th>%</th>
                </tr>
                <?php
                $count = 1;
                foreach ($top_ten_students as $top_ten_student) { ?>
                  <tr>
                    <td><?php echo $count++; ?></td>

                    <td><?php echo $top_ten_student->student_class_no; ?></td>
                    <td><?php echo $top_ten_student->student_admission_no; ?></td>

                    <td><?php echo $top_ten_student->student_name; ?></td>
                    <td><?php echo $top_ten_student->student_father_name; ?></td>
                    <td><?php $numbers = explode(',', $top_ten_student->contact_numbers); // convert to array
                        echo implode('<br />', array_map('trim', $numbers)); // join with <br> 
                        ?></td>
                    <td style="background-color:<?php echo $top_ten_student->color; ?>">
                      <?php echo $top_ten_student->Class_title; ?> (<?php echo $top_ten_student->section_title; ?>)</td>

                    <td><?php echo $top_ten_student->obtain_marks; ?></td>
                    <td><?php echo $top_ten_student->total_marks; ?></td>
                    <td><?php echo $top_ten_student->percentage; ?></td>
                  </tr>
                <?php } ?>
              </table>
            </h2>
          </div>
        </section>
      </div>
    </div>
  </div>
  </div>
  <!-- /MESSENGER -->
  </div>
</body>

</html>