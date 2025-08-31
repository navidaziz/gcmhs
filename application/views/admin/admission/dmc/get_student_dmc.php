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
            exr.percentage,
            CASE 
                WHEN exr.obtain_mark = 'A' THEN 'Absent'
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
        WHERE exr.student_id = ? AND exr.exam_id = ?;";

$result = $this->db->query($query, [$student_id, $exam_id])->result();

$total_obtained = 0;
$total_marks = 0;
$weak_subjects = [];
$strong_subjects = [];
$absent_subjects = [];

?>

<h2>Student Performance Report</h2>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Subject</th>
            <th>Marks Obtained</th>
            <th>Total Marks</th>
            <th>Percentage</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $count = 1;
        foreach ($result as $row): ?>
            <tr>
                <th><?php echo $count++; ?></th>
                <td><?php echo $row->subject_title; ?></td>
                <td>
                    <?php
                    if ($row->obtain_mark === 'A') {
                        echo "<span style='color:red;font-weight:bold;'>Absent</span>";
                        $absent_subjects[] = $row->subject_title;
                    } else {
                        echo $row->obtain_mark;
                    }
                    ?>
                </td>
                <td><?php echo $row->total_marks; ?></td>
                <td>
                    <?php echo ($row->obtain_mark === 'A') ? '-' : $row->percentage . '%'; ?>
                </td>
                <td><?php echo $row->grade; ?></td>
            </tr>

            <?php
            // accumulate totals only if not absent
            //if ($row->obtain_mark !== 'A') {
            $total_obtained += $row->obtain_mark;
            $total_marks += $row->total_marks;

            // classify subjects
            if ($row->percentage < 50) {
                $weak_subjects[] = $row->subject_title;
            } elseif ($row->percentage >= 70) {
                $strong_subjects[] = $row->subject_title;
            }
            //}
            ?>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th>Total</th>
            <th><?php echo $total_obtained; ?></th>
            <th><?php echo $total_marks; ?></th>
            <th colspan="2">
                <?php
                $overall_percentage = $total_marks > 0 ? round(($total_obtained / $total_marks) * 100, 2) : 0;
                echo $overall_percentage . '%';
                ?>
            </th>
        </tr>
    </tfoot>
</table>

<?php
// Overall grade
if ($overall_percentage >= 80) $overall_grade = 'A+';
elseif ($overall_percentage >= 70) $overall_grade = 'A';
elseif ($overall_percentage >= 60) $overall_grade = 'B';
elseif ($overall_percentage >= 50) $overall_grade = 'C';
elseif ($overall_percentage >= 40) $overall_grade = 'D';
else $overall_grade = 'F';

// Build English remarks
$remarks = "The student achieved an overall percentage of <b>{$overall_percentage}%</b>, securing an overall grade of <b>{$overall_grade}</b>. ";

if (!empty($strong_subjects)) {
    $remarks .= "Strong performance was observed in <b>" . implode(", ", $strong_subjects) . "</b>, showing good understanding and consistency in these areas. ";
}

if (!empty($weak_subjects)) {
    $remarks .= "However, there is a need for improvement in <b>" . implode(", ", $weak_subjects) . "</b>, where the performance was below expectations. Extra effort and practice are recommended. ";
}

if (!empty($absent_subjects)) {
    $remarks .= "The student was absent in <b>" . implode(", ", $absent_subjects) . "</b>, which negatively impacted the overall performance. Attendance in all exams is strongly advised. ";
}

if (empty($weak_subjects) && empty($absent_subjects)) {
    $remarks .= "Overall, the student has performed well in all subjects without any major weaknesses.";
}
?>

<h3>Performance Analysis</h3>
<p><?php echo $remarks; ?></p>