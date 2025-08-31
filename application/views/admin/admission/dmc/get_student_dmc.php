<table class="table" style="width: 100%; margin-top: 10px;">
    <tr>
        <th>Class No</th>
        <th>Admission No</th>
        <th>Student Name</th>
        <th>Father Name</th>
        <th>Date of Birth</th>
        <th>Age</th>
        <th>Form-B</th>
        <th>Status</th>
    </tr>
    <tr>
        <td><?php echo $student->student_class_no; ?></td>
        <td><?php echo $student->student_admission_no; ?></td>
        <td><?php echo $student->student_name; ?></td>
        <td><?php echo $student->student_father_name; ?></td>
        <td><?php echo date("d M, Y", strtotime($student->student_data_of_birth)); ?></td>
        <td><?php echo (new DateTime())->diff(new DateTime($student->student_data_of_birth))->y; ?></td>
        <td><?php echo $student->form_b; ?></td>
        <td>
            <?php
            switch ($student->status) {
                case 0:
                    echo "Deleted";
                    break;
                case 1:
                    echo "Admit";
                    break;
                case 2:
                    echo "Struck Off";
                    break;
                case 3:
                    echo "Withdraw";
                    break;
            }
            ?>
        </td>
    </tr>
</table>



<?php
$query = "SELECT 
            sub.subject_title,
            sub.short_title,
            exr.obtain_mark,
            exr.total_marks, 
            exr.passing_marks, 
            exr.percentage 
          FROM students_exams_subjects_marks AS exr 
          INNER JOIN exams AS ex ON ex.exam_id = exr.exam_id 
          INNER JOIN classes AS c ON c.class_id = exr.class_id 
          INNER JOIN sections AS sec ON sec.section_id = exr.section_id
          INNER JOIN subjects as sub ON sub.subject_id = exr.subject_id
          WHERE exr.student_id = ?
          AND exr.exam_id = ?";

$student_subjects_results = $this->db->query($query, array($student_id, $exam_id))->result();

// Initialize totals
$total_obtained = 0;
$total_marks    = 0;
$total_passing  = 0;
?>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Short Title</th>
            <th>Obtained Marks</th>
            <th>Total Marks</th>
            <!-- <th>Passing Marks</th> -->
            <th>Percentage</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($student_subjects_results)) { ?>
            <?php foreach ($student_subjects_results as $row) {
                // Add to totals
                $total_obtained += $row->obtain_mark;
                $total_marks    += $row->total_marks;
                $total_passing  += $row->passing_marks;
            ?>
                <tr>
                    <td><?php echo $row->subject_title; ?></td>
                    <td><?php echo $row->short_title; ?></td>
                    <td><?php echo $row->obtain_mark; ?></td>
                    <td><?php echo $row->total_marks; ?></td>
                    <!-- <td><?php echo $row->passing_marks; ?></td> -->
                    <td><?php echo number_format($row->percentage, 2); ?>%</td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr>
                <td colspan="6" class="text-center">No records found.</td>
            </tr>
        <?php } ?>
    </tbody>
    <?php if (!empty($student_subjects_results)) {
        $overall_percentage = $total_marks > 0 ? ($total_obtained / $total_marks) * 100 : 0;
    ?>
        <tfoot>
            <tr>
                <th colspan="2" class="text-right">Total</th>
                <th><?php echo $total_obtained; ?></th>
                <th><?php echo $total_marks; ?></th>
                <!-- <th><?php echo $total_passing; ?></th> -->
                <th><?php echo number_format($overall_percentage, 2); ?>%</th>
            </tr>
        </tfoot>
    <?php } ?>
</table>