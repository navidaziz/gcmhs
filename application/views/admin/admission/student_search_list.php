<table class="table table-bordered">
  <thead>
    <tr>
      <th>Student ID</th>
      <th><?php echo $this->lang->line('student_admission_no'); ?></th>
      <th><?php echo $this->lang->line('student_name'); ?></th>
      <th><?php echo $this->lang->line('student_father_name'); ?></th>
      <th><?php echo $this->lang->line('student_data_of_birth'); ?></th>
      <th><?php echo $this->lang->line('student_address'); ?></th>
      <th><?php echo $this->lang->line('Class_title'); ?></th>
      <th><?php echo $this->lang->line('section_title'); ?></th>
      <th>status</th>
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


        <td><?php echo $student->class_title; ?></td>
        <td><?php echo $student->section_title; ?></td>
        <td><?php echo $student->status; ?></td>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>