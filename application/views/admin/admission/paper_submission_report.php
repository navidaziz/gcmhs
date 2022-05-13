<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>" />

<head>
</head>

<body>

  <!-- /PAGE HEADER -->

  <!-- PAGE MAIN CONTENT -->
  <div class="row" style="font-size:12px !important; font-family: Open Sans !important">

    <div class="col-md-12">



      <style>
        table {
          border-collapse: collapse;
          width: 100%;
        }

        thead {
          font-weight: bold;
        }

        table,
        th,
        td {
          border: 1px solid black;
        }
      </style>






      <div class="box border blue" id="messenger">
        <div class="box-title">
          <h4><i class="fa fa-bell"></i> <?php echo $title; ?></h4>
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
          <div class="table-responsive" style="font-size:11px !important;">
            <table class="table">
              <thead>
              </thead>
              <tbody>
                <?php foreach ($exams as $exam) : ?>
                  <tr>
                    <th><?php echo $this->lang->line('year'); ?></th>
                    <th><?php echo $this->lang->line('term'); ?></th>
                    <th><?php echo $this->lang->line('passing_percentage'); ?></th>
                    <th><?php echo $this->lang->line('promotion_percentage'); ?></th>
                    <th><?php echo $this->lang->line('exam_data'); ?></th>
                    <th><?php echo $this->lang->line('Status'); ?></th>
                  </tr>
                  <tr>
                    <td><?php echo $exam->year; ?></td>
                    <td><?php echo $exam->term; ?></td>
                    <td><?php echo $exam->passing_percentage; ?></td>
                    <td><?php echo $exam->promotion_percentage; ?></td>
                    <td><?php echo $exam->exam_data; ?></td>
                    <td><?php echo status($exam->status); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            <div class="row">
              <!-- MESSENGER -->


              <div class="col-md-12">





                <?php foreach ($classes as $class) { ?>

                  <h3>
                    <?php echo $class->Class_title; ?></th>
                  </h3>
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Subjects</th>
                        <?php foreach ($subjects as $subject) : ?>
                          <th><?php echo $subject->subject_title; ?></th>
                        <?php endforeach; ?>
                      </tr>
                    </thead>
                    <tbody>

                      <?php foreach ($class->sections as $section) { ?>
                        <tr>

                          <th><?php echo $section->section_title; ?></th>

                          <?php foreach ($subjects as $subject) {
                            $query = "SELECT count(*) as total FROM `students_exams_subjects_marks`
                            
                            WHERE class_id = $class->class_id
                            AND section_id= $section->section_id
                            AND subject_id= $subject->subject_id
                            AND  exam_id = '" . $exam_id . "'";
                            $result = $this->db->query($query)->result()[0]->total;

                          ?>
                            <th>
                              <?php
                              if ($result) {
                              } else {


                                $query = "SELECT t.teacher_name FROM `classes_time_tables` as ctt
                                    INNER JOIN teachers as t ON (t.teacher_id = ctt.teacher_id)
                                    WHERE class_id = $class->class_id
                                    AND section_id= $section->section_id
                                    AND subject_id= $subject->subject_id";
                                echo $tacher_name = $this->db->query($query)->result()[0]->teacher_name;
                              }
                              ?>
                            </th>
                          <?php } ?>

                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                <?php } ?>



              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /MESSENGER -->
  </div>
  </div>
  <!-- /MESSENGER -->
  </div>
</body>

</html>