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
// Query with grade calculation
$query = "
    SELECT 
        sub.subject_title,
        sub.short_title,
        exr.obtain_mark,
        exr.total_marks, 
        exr.percentage,
        CASE
            WHEN exr.percentage >= 80 THEN 'A+'
            WHEN exr.percentage >= 70 THEN 'A'
            WHEN exr.percentage >= 60 THEN 'B'
            WHEN exr.percentage >= 50 THEN 'C'
            WHEN exr.percentage >= 40 THEN 'D'
            ELSE 'F'
        END AS grade
    FROM students_exams_subjects_marks AS exr 
    INNER JOIN exams AS ex ON ex.exam_id = exr.exam_id 
    INNER JOIN classes AS c ON c.class_id = exr.class_id 
    INNER JOIN sections AS sec ON sec.section_id = exr.section_id
    INNER JOIN subjects as sub ON sub.subject_id = exr.subject_id
    WHERE exr.student_id = ?
      AND exr.exam_id = ? ;
";

$student_subjects_results = $this->db->query($query, array($student_id, $exam_id))->result();

// Initialize totals
$total_obtain   = 0;
$total_marks    = 0;
$total_percent  = 0;
$count_subjects = 0;
?>

<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Short Title</th>
            <th>Obtained Marks</th>
            <th>Total Marks</th>
            <th>Percentage %</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($student_subjects_results as $row): ?>
            <tr>
                <td><?php echo $row->subject_title; ?></td>
                <td><?php echo $row->short_title; ?></td>
                <td><?php echo $row->obtain_mark; ?></td>
                <td><?php echo $row->total_marks; ?></td>
                <td><?php echo $row->percentage; ?>%</td>
                <td><?php echo $row->grade; ?></td>
            </tr>
            <?php
            $total_obtain   += $row->obtain_mark;
            $total_marks    += $row->total_marks;
            $total_percent  += $row->percentage;
            $count_subjects++;
            ?>
        <?php endforeach; ?>

        <?php
        // Calculate overall percentage
        $overall_percentage = $count_subjects > 0 ? round($total_percent / $count_subjects, 2) : 0;

        // Determine final grade
        if ($overall_percentage >= 80) {
            $final_grade = "A+";
            $remarks = "Excellent performance!";
        } elseif ($overall_percentage >= 70) {
            $final_grade = "A";
            $remarks = "Very good, keep it up!";
        } elseif ($overall_percentage >= 60) {
            $final_grade = "B";
            $remarks = "Good, but can improve further.";
        } elseif ($overall_percentage >= 50) {
            $final_grade = "C";
            $remarks = "Satisfactory, needs improvement.";
        } elseif ($overall_percentage >= 40) {
            $final_grade = "D";
            $remarks = "Below average, work harder.";
        } else {
            $final_grade = "F";
            $remarks = "Poor performance, needs serious attention.";
        }
        ?>

        <!-- Final row -->
        <tr style="font-weight:bold;">
            <td colspan="2" align="right">Total:</td>
            <td><?php echo $total_obtain; ?></td>
            <td><?php echo $total_marks; ?></td>
            <td><?php echo $overall_percentage; ?>%</td>
            <td><?php echo $final_grade; ?></td>
        </tr>
    </tbody>
</table>

<p><strong>Remarks:</strong> <?php echo $remarks; ?></p>