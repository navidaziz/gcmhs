<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url("student/class_and_section/"); ?>">Annual School Census Report</a> </li>
        <li>Annual School Census Report</li>


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
        <h4><i class="fa fa-bell"></i> Annual School Census Report</h4>
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
          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th>Nurery</th>
                <th>Prep</th>
                <th>1th</th>
                <th>2th</th>
                <th>3th</th>
                <th>4th</th>
                <th>5th</th>
                <?php

                $classes = array(
                  "2" => "6th",
                  "3" => "7th",
                  "4" => "8th",
                  "5" => "9th",
                  "6" => "10th"
                );
                foreach ($classes as $class_id => $class) { ?>

                  <th><?php echo $class ?></th>
                <?php } ?>
                <th>11th</th>
                <th>12th</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>Error</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <?php foreach ($classes as $class_id => $class) { ?>
                  <td><?php
                      $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE  
                             age NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20) and class_id= '" . $class_id . "'";
                      if ($this->db->query($query)->result()[0]->total_student > 0) {
                        echo $this->db->query($query)->result()[0]->total_student;
                      } ?></td>

                <?php } ?>
                <td></td>
                <td></td>
                <td><?php
                    $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE age NOT IN (1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)";
                    if ($this->db->query($query)->result()[0]->total_student > 0) {
                      echo $this->db->query($query)->result()[0]->total_student;
                    } ?></td>
              </tr>
              <?php
              $ages = array(
                "1" => "1",
                "2" => "2",
                "3" => "3",
                "4" => "4",
                "5" => "5",
                "5" => "5",
                "6" => "6",
                "7" => "7",
                "8" => "8",
                "9" => "9",
                "10" => "10",
                "11" => "11",
                "12" => "12",
                "13" => "13",
                "14" => "14",
                "15" => "15",
                "16" => "16",
                "17" => "17",
                "18" => "18",
                "19" => "19",
                "20" => "20",
                "21" => "21",


              );
              foreach ($ages as $age_id => $age) { ?>
                <tr>
                  <th><?php echo $age ?></th>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <?php foreach ($classes as $class_id => $class) { ?>
                    <td><?php
                        $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE age='" . $age . "' and class_id= '" . $class_id . "'";
                        if ($this->db->query($query)->result()[0]->total_student > 0) {
                          echo $this->db->query($query)->result()[0]->total_student;
                        } ?></td>

                  <?php } ?>
                  <td></td>
                  <td></td>
                  <td><?php
                      $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE  age='" . $age . "'";
                      if ($this->db->query($query)->result()[0]->total_student > 0) {
                        echo $this->db->query($query)->result()[0]->total_student;
                      } ?></td>
                </tr>
              <?php } ?>
              <tr>
                <th>Total</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <?php foreach ($classes as $class_id => $class) { ?>
                  <td><?php
                      $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE  class_id= '" . $class_id . "'";
                      if ($this->db->query($query)->result()[0]->total_student > 0) {
                        echo $this->db->query($query)->result()[0]->total_student;
                      } ?></td>

                <?php } ?>
                <td></td>
                <td></td>
                <td><?php
                    $query = "SELECT COUNT(age) as total_student FROM students_age_wise";
                    if ($this->db->query($query)->result()[0]->total_student > 0) {
                      echo $this->db->query($query)->result()[0]->total_student;
                    } ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER -->
</div>