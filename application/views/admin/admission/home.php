<!-- PAGE HEADER-->
<div class="row">
  <div class="col-sm-12">
    <div class="page-header" style="min-height: 30px;">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li>
          <i class="fa fa-home"></i>
          <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
        </li>
        <li><?php echo $title; ?></li>
      </ul>


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
        <h4><i class="fa fa-book" aria-hidden="true"></i> <?php echo $title; ?></h4>
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
          <div class="row">
            <div class="col-md-6">
              <!-- MESSENGER -->

              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th colspan="2">Classes-Sections -
                      <small><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.status IN(1,2)";
                              echo $this->db->query($query)->result()[0]->total;
                              ?>
                      </small>

                    </th>
                    <th>Total</th>
                    <th>S-OFF - <small><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.status IN(2)";
                                        echo $this->db->query($query)->result()[0]->total;
                                        ?>
                      </small></th>

                    <th><i class="fa fa-edit"></i></th>
                    <th><i class="fa fa-eye"></i></th>
                    <!-- <th>Promote</th> -->
                    <th colspan="3" style="text-align: center;">

                      <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/all_students_data") . "/"; ?>">
                        <i class="fa fa-print"></i> Student Overall Data</a>
                    </th>
                  </tr>
                </thead>
                </body>
                <?php foreach ($classes as $class) { ?>

                  <?php
                  $count = 1;
                  foreach ($class->sections as $section) { ?>
                    <tr>
                      <?php if ($count == 1) { ?>
                        <th style="text-align: center;" rowspan="<?php echo count($class->sections); ?>"><?php echo $class->Class_title; ?>
                          <br />
                          <small><?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.class_id = $class->class_id
                              AND s.status IN(1,2)";
                                  echo $this->db->query($query)->result()[0]->total;
                                  ?>
                          </small>

                        </th>
                      <?php
                        $count++;
                      } ?>


                      <td style="background-color: <?php echo $section->color; ?>;"><?php echo $section->section_title; ?></td>

                      <th style="text-align: center;">
                        <?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.class_id = $class->class_id
                              AND s.section_id = $section->section_id
                              AND s.status = 1";
                        echo $this->db->query($query)->result()[0]->total;
                        ?>
                      </th>

                      <td style="text-align: center;">
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/struck_off_students") . "/$class->class_id/$section->section_id"; ?>">
                          <?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.class_id = $class->class_id
                              AND s.section_id = $section->section_id
                              AND s.status = 2";
                          echo $this->db->query($query)->result()[0]->total;
                          ?> <i class="fa fa-eye"></i></a>

                      </td>


                      <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/view_students") . "/$class->class_id/$section->section_id"; ?>">
                          <i class="fa fa-edit"></i> </a>
                      </td>
                      <!-- <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/promote_students") . "/$class->class_id/$section->section_id"; ?>">
                          Promote</a>
                      </td> -->
                      <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/students_list") . "/$class->class_id/$section->section_id"; ?>">
                          <i class="fa fa-eye"></i></a>
                      </td>
                      <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/age_wise_report") . "/$class->class_id/$section->section_id"; ?>">
                          Age Report</a>
                      </td>

                      <td>
                        <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/award_list") . "/$class->class_id/$section->section_id"; ?>">
                          Award List</a>
                      </td>

                      <td>
                        <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/results") . "/$class->class_id/$section->section_id"; ?>">
                          Results</a>
                      </td>
                    </tr>
                  <?php } ?>


                <?php } ?>
              </table>

            </div>

            <div class="col-md-6">
              <div style="padding: 5px; margin: 5px; border: 1px solid gray; border-radius: 5px;">
                Search Student from overall data: <input type="text" name="search_student" id="search_student" value="" onkeyup="search_student()" />
                <div id="student_search_result_list" style="padding: 10px; font-size: 10px;"></div>

              </div>
            </div>
            <script>
              function search_student() {
                var search_student = $('#search_student').val();
                if (search_student != "") {
                  $.ajax({
                    type: "POST",
                    url: "<?php echo site_url(ADMIN_DIR . "admission/search_student") ?>",
                    data: {
                      search_student: search_student
                    }
                  }).done(function(data) {
                    $("#student_search_result_list").html(data);
                  });

                } else {
                  $("#student_search_result_list").html("");

                }
              }
            </script>



          </div>



        </div>


      </div>

    </div>
  </div>
  <!-- /MESSENGER -->
</div>