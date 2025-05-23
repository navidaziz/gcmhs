<style>
  .image-tooltip {
    position: relative;
    display: inline-block;
  }

  .image-tooltip .tooltip {
    visibility: hidden;
    width: 150px;
    background-color: transparent;
    position: absolute;
    z-index: 100;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s;
  }

  .image-tooltip:hover .tooltip {
    visibility: visible;
    opacity: 1;
  }
</style>
<style>
  .table_small>thead>tr>th,
  .table_small>tbody>tr>th,
  .table_small>tfoot>tr>th,
  .table_small>thead>tr>td,
  .table_small>tbody>tr>td,
  .table_small>tfoot>tr>td {
    padding: 4px;
    line-height: 1;
    vertical-align: top;
    border-top: 1px solid #ddd;
    font-size: 10px !important;
    color: black;
    margin: 0px !important;
  }

  .panel-heading {
    padding: 5px;
  }
</style>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<div class="row" style="background-color: white; padding-top: 10px;">
  <div class="col-md-12">
    <table class="table table-striped table-bordered table_small" id="today_attendance" cellpadding="5" cellspacing="0" style="width:100%; margin-bottom:20px;">
      <thead>
        <tr>
          <th>#</th>
          <th>STUDENT ID</th>
          <th>CLASS NO.</th>
          <th>STUDENT</th>
          <th>ADMISSION NO.</th>
          <th>CONTACT</th>
          <th>IMAGE</th>
          <th>STATUS</th>
          <th>CLASS</th>
          <th>SECTION</th>
          <?php
          for ($i = 7; $i >= 0; $i--) {
            $date = new DateTime();
            $date->modify("-$i days");
          ?>
            <th><?php echo $date->format('d, F'); ?> - M</th>
            <th><?php echo $date->format('d, F'); ?> - E</th>
          <?php } ?>
          <th>M-P</th>
          <th>M-A</th>
          <th>M-L</th>
          <th>E-A</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM `students_attendance_list` WHERE `students_attendance_list`.`status` IN(1,2)";
        $students_attendance = $this->db->query($query)->result();
        $count = 1;
        foreach ($students_attendance as $sa):
        ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $sa->student_id; ?></td>
            <td><?php echo $sa->class_no; ?></td>
            <td><?php echo $sa->name; ?> S/O <?php echo $sa->father_name; ?></td>
            <td><?php echo $sa->admission_no; ?></td>
            <th><?php echo $sa->contact_no; ?></th>
            <td><?php if ($sa->image) { ?>
                <span class="image-tooltip">
                  <img src="<?php echo site_url('uploads/gcmhs/' . $sa->image); ?>" width="30" height="30" />
                  <span class="tooltip">
                    <img src="<?php echo site_url('uploads/gcmhs/' . $sa->image); ?>" width="150" style="border: 2px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.3);" />
                  </span>
                </span>
              <?php } ?>
            </td>
            <td><?php
                if ($sa->status == 1) {
                  echo "Admit";
                }
                if ($sa->status == 2) {
                  echo "Struck Off";
                }

                if ($sa->status == 3) {
                  echo "SLC";
                }

                if ($sa->status == 0) {
                  echo "Deleted";
                }

                //echo $sa->status; 
                ?></td>


            <td><?php echo $sa->class_title; ?></td>
            <td style="color: <?php echo $sa->section_title; ?>;"><strong>
                <?php echo $sa->section_title; ?> </strong>
            </td>
            <?php
            for ($i = 7; $i >= 0; $i--) {
              $date = new DateTime();
              $date->modify("-$i days");
              $formatted_date = $date->format('Y-m-d');
              if ($date->format('w') == 0) { ?>
                <td style="background-color: gray;"></td>
                <td style="background-color: gray;"></td>
              <?php } else {
                $query = "SELECT * FROM `students_attendance` 
              WHERE `student_id` = ? AND DATE(`date`) = ?";
                $students_attendance = $this->db->query($query, [$sa->student_id, $formatted_date])->row();
              ?>
                <td style="background-color: <?php if ($students_attendance->attendance == 'P') {
                                                echo '#28a745';
                                              } ?>
                                              <?php if ($students_attendance->attendance == 'A') {
                                                echo '#dc3545';
                                              } ?>;">
                  <?php
                  echo isset($students_attendance->attendance) ? $students_attendance->attendance : '<small style="font-size:5px">NULL</small>';
                  ?>
                </td>
                <?php if ($date->format('w') == 5) {  ?>
                  <td style="background-color: gray;"></td>
                <?php } else { ?>
                  <td style="background-color:<?php if ($students_attendance->attendance2 == 'A') {
                                                echo '#fd7e14';
                                              } ?>
                                              <?php if ($students_attendance->attendance2 == 'P') {
                                                echo '#28a745';
                                              } ?>">
                    <?php
                    echo isset($students_attendance->attendance2) ? $students_attendance->attendance2 : '<small style="font-size:5px">NULL</small>';
                    ?>
                  </td>
                <?php } ?>
              <?php } ?>
            <?php } ?>

            <td><?php echo $sa->m_p; ?></td>
            <td><?php echo $sa->m_a; ?></td>
            <td><?php echo $sa->m_l; ?></td>
            <td><?php echo $sa->e_a; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>

    </table>
  </div>






  <script>
    $(document).ready(function() {
      var table = $('#today_attendance').DataTable({
        bPaginate: false,
        dom: 'Bfrtip',
        searching: true, // Disable search box
        buttons: ['excel', 'pdf'], // Add Excel and PDF buttons
        columnDefs: [{
          searchable: false,
          orderable: false,
          targets: 0 // First column (Serial No.) not sortable/searchable
        }],
        order: [] // Optional: avoid initial sorting
      });

      // Auto-indexing the first column (Serial No.)
      table.on('order.dt search.dt draw.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
          })
          .nodes()
          .each(function(cell, i) {
            cell.innerHTML = i + 1;
          });
      }).draw();
    });
  </script>