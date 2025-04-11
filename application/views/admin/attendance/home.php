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
                              WHERE s.status IN(1,2) and s.class_id IN (2,3,4,5,6)";
                              echo $this->db->query($query)->result()[0]->total;
                              ?>
                      </small>

                    </th>
                    <th>Total</th>
                    <th title="struck Off"> Struck Off - <?php $query = "SELECT COUNT(*) as total FROM students as s
                              WHERE s.status IN(2)";
                                                          echo $this->db->query($query)->result()[0]->total;
                                                          ?>
                    </th>

                    <!-- <th><i class="fa fa-edit"></i></th> -->
                    <th style="text-align: center;">
                      <i class="fa fa-users" aria-hidden="true"></i>

                    </th>
                    <th>Promote</th>
                    <th style="text-align: center;">
                      <i class="fa fa-bar-chart-o"></i>
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


                      <!-- <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/view_students") . "/$class->class_id/$section->section_id"; ?>">
                          <i class="fa fa-edit"></i> </a>
                      </td> -->

                      <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/students_list") . "/$class->class_id/$section->section_id"; ?>">
                          <i class="fa fa-user" aria-hidden="true"></i> View Students</a>
                      </td>
                      <td>
                        <a href="<?php echo site_url(ADMIN_DIR . "admission/promote_students") . "/$class->class_id/$section->section_id"; ?>">
                          Promote</a>
                      </td>

                      <!-- <td>
                        <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/award_list") . "/$class->class_id/$section->section_id"; ?>">
                          Award List</a>
                      </td> -->

                      <td>
                        <a target="new" href="<?php echo site_url(ADMIN_DIR . "admission/results") . "/$class->class_id/$section->section_id"; ?>">
                          <i class="fa fa-bar-chart-o"></i> Progress Report</a>
                      </td>
                    </tr>
                  <?php } ?>


                <?php } ?>
              </table>

            </div>


          </div>



        </div>


      </div>

    </div>
  </div>
  <!-- /MESSENGER -->
</div>