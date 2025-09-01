<!-- PAGE HEADER-->

<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url(ADMIN_DIR . "admission"); ?>">Annual School Census Report</a> </li>
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
        <h4><i class="fa fa-bell"></i>Students Class / Age Wise Data</h4>

      </div>
      <div class="box-body">
        <div class="table-responsive">
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
            "21" => "21"
          );
          $classes = array(
            // "100" => "Play Group",
            // "101" => "Nursery",
            // "102" => "Prep / KG",
            // "103" => "1st",
            // "104" => "2nd",
            // "105" => "3rd",
            // "106" => "4th",
            "200" => "*",
            "107" => "5th",
            "2" => "6th",
            "3" => "7th",
            "4" => "8th",
            "5" => "9th",
            "6" => "10th",
            "108" => "11th",
            "109" => "12th"
          );
          ?>

          <table class="table table-bordered">
            <thead>
              <tr>
                <th></th>
                <th colspan="21" style="text-align: center;">Age Range </th>
              </tr>
              <tr>
                <th>Classes</th>
                <?php
                // $query = "SELECT age FROM students_age_wise GROUP BY age";
                // $ages = $this->db->query($query)->result();
                foreach ($ages as $age) { ?>
                  <th><?php echo $age ?></th>
                <?php } ?>
                <th>Total</th>
                <th>Non-Muslims</th>
                <th>Non-Pakistanis</th>
                <th>Orphan</th>
                <th>Disable</th>
                <th>Ehsaas</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($classes as $class_id => $class) { ?>
                <tr>
                  <th><?php echo $class ?></th>
                  <?php foreach ($ages as $age) { ?>

                    <td><?php
                        $query = "SELECT COUNT(age) as total_student 
                        FROM students_age_wise 
                        WHERE age='" . $age . "' 
                        AND class_id= '" . $class_id . "'
                        AND status=1";
                        if ($this->db->query($query)->result()[0]->total_student > 0) {
                          echo $this->db->query($query)->result()[0]->total_student;
                        } ?></td>

                  <?php } ?>
                  <th style="text-align:center"><?php
                                                $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE  class_id= '" . $class_id . "' AND status=1";
                                                if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                  echo $this->db->query($query)->result()[0]->total_student;
                                                } ?></th>
                  <th style="text-align:center"><?php
                                                $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE religion != 'Islam' and class_id= '" . $class_id . "' AND status=1";
                                                if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                  echo $this->db->query($query)->result()[0]->total_student;
                                                } ?></th>

                  <th style="text-align:center"><?php
                                                $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE nationality != 'Pakistani' and class_id= '" . $class_id . "' AND status=1";
                                                if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                  echo $this->db->query($query)->result()[0]->total_student;
                                                } ?></th>

                  <th style="text-align:center"><?php
                                                $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE orphan = 'Yes' and class_id= '" . $class_id . "' AND status=1";
                                                if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                  echo $this->db->query($query)->result()[0]->total_student;
                                                } ?></th>

                  <th style="text-align:center"><?php
                                                $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE is_disable = 'Yes' and class_id= '" . $class_id . "' AND status=1";
                                                if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                  echo $this->db->query($query)->result()[0]->total_student;
                                                } ?></th>
                  <th style="text-align:center"><?php
                                                $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE ehsaas = 'Yes' and class_id= '" . $class_id . "' AND status=1";
                                                if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                  echo $this->db->query($query)->result()[0]->total_student;
                                                } ?></th>
                </tr>

              <?php } ?>
              <tr>
                <th>Total</th>
                <?php foreach ($ages as $age) { ?>
                  <th><?php
                      $query = "SELECT COUNT(age) as total_student FROM students_age_wise WHERE age='" . $age . "'";
                      if ($this->db->query($query)->result()[0]->total_student > 0) {
                        echo $this->db->query($query)->result()[0]->total_student;
                      } ?></th>
                <?php } ?>
                <th style="text-align:center"><?php
                                              $query = "SELECT COUNT(age) as total_student FROM students_age_wise";
                                              if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                echo $this->db->query($query)->result()[0]->total_student;
                                              } ?></th>
                <th style="text-align:center"><?php
                                              $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE religion != 'Islam'";
                                              if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                echo $this->db->query($query)->result()[0]->total_student;
                                              } ?></th>

                <th style="text-align:center"><?php
                                              $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE nationality != 'Pakistani' ";
                                              if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                echo $this->db->query($query)->result()[0]->total_student;
                                              } ?></th>

                <th style="text-align:center"><?php
                                              $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE orphan = 'Yes' ";
                                              if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                echo $this->db->query($query)->result()[0]->total_student;
                                              } ?></th>

                <th style="text-align:center"><?php
                                              $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE is_disable = 'Yes'";
                                              if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                echo $this->db->query($query)->result()[0]->total_student;
                                              } ?></th>
                <th style="text-align:center"><?php
                                              $query = "SELECT COUNT(student_id) as total_student FROM students_age_wise WHERE ehsaas = 'Yes'";
                                              if ($this->db->query($query)->result()[0]->total_student > 0) {
                                                echo $this->db->query($query)->result()[0]->total_student;
                                              } ?></th>
              </tr>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!-- /MESSENGER -->
</div>