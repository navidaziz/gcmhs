<table class="table table-bordered table_small">
  <thead>
    <tr>
      <th>S-ID</th>
      <th>Add No.</th>
      <th>Name</th>
      <th>Father Name</th>
      <th>DOB</th>
      <th>Address</th>
      <td>Session</td>
      <th>Class</th>
      <th>Section</th>
      <th>Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($students_list as $student) : ?>
      <tr>

        <td><?php echo $student->student_id; ?></td>
        <td><?php echo $student->student_admission_no; ?></td>
        <td><?php echo $student->student_name; ?></td>
        <td><?php echo $student->student_father_name; ?></td>
        <td><?php echo $student->student_data_of_birth; ?></td>
        <td><?php echo $student->student_address; ?></td>

        <td><?php $query = "SELECT `session` FROM session WHERE session_id = '" . $student->session_id . "'";
            echo $this->db->query($query)->result()[0]->session;
            ?></td>
        <td><?php echo $student->class_title; ?></td>
        <td><?php echo $student->section_title; ?></td>
        <td><?php //echo $student->status;
            if ($student->status == 1) {
              echo "Admit";
            }
            if ($student->status == 2) {
              echo "Struck Off";
            }

            if ($student->status == 3) {
              echo "SLC";
            }

            ?></td>
        <td><a href="<?php echo site_url(ADMIN_DIR . "admission/view_student_profile/" . $student->student_id) ?>">View</a></td>

        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>