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
    <table border="1" id="today_attendance" cellpadding="5" cellspacing="0" style="width:100%; margin-bottom:20px;">
      <thead>
        <tr>
          <th>#</th>
          <th>STUDENT ID</th>
          <th>CLASS NO.</th>
          <th>STUDENT NAME</th>
          <th>FATHER NAME</th>
          <th>ADMISSION NO.</th>
          <th>IMAGE</th>
          <th>STATUS</th>
          <th>CLASS</th>
          <th>SECTION</th>
          <th>PRESENT</th>
          <th>ABSENT</th>
          <th>LEAVE</th>
          <th>EVE. ABSENT</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM `students_attendance_list`";
        $students_attendance = $this->db->query($query)->result();
        $count = 1;
        foreach ($students_attendance as $sa):
        ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo $sa->student_id; ?></td>
            <td><?php echo $sa->class_no; ?></td>
            <td><?php echo $sa->name; ?></td>
            <td><?php echo $sa->father_name; ?></td>
            <td><?php echo $sa->admission_no; ?></td>
            <td><?php echo $sa->image; ?></td>
            <td><?php echo $sa->status; ?></td>
            <td><?php echo $sa->class_title; ?></td>
            <td><?php echo $sa->section; ?></td>
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
        searching: false, // Disable search box
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