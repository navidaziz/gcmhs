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

$results = $this->db->query($query, [$student_id, $exam_id])->result();

$totalMarks = 0;
$totalObtained = 0;
$remarks = [];
$goodSubjects = [];
$weakSubjects = [];

foreach ($results as $row) {
    $totalMarks += $row->total_marks;
    $totalObtained += $row->obtain_mark;

    if ($row->grade == 'A+' || $row->grade == 'A') {
        $goodSubjects[] = $row->subject_title;
    } elseif ($row->grade == 'D' || $row->grade == 'F') {
        $weakSubjects[] = $row->subject_title;
    }
}

$overallPercentage = ($totalMarks > 0) ? round(($totalObtained / $totalMarks) * 100, 2) : 0;

if ($overallPercentage >= 80) {
    $overallGrade = "Excellent";
    $remarks[] = "The student has shown outstanding performance overall.";
} elseif ($overallPercentage >= 70) {
    $overallGrade = "Very Good";
    $remarks[] = "The student has performed very well with minor areas to improve.";
} elseif ($overallPercentage >= 60) {
    $overallGrade = "Good";
    $remarks[] = "The student has shown good performance but needs to focus more on weak areas.";
} elseif ($overallPercentage >= 50) {
    $overallGrade = "Fair";
    $remarks[] = "The student has passed but should work harder to improve.";
} else {
    $overallGrade = "Needs Improvement";
    $remarks[] = "The student needs significant improvement.";
}

// Subject-wise analysis
if (!empty($goodSubjects)) {
    $remarks[] = "Strong subjects include: " . implode(", ", $goodSubjects) . ".";
}
if (!empty($weakSubjects)) {
    $remarks[] = "Needs improvement in: " . implode(", ", $weakSubjects) . ".";
}

$finalRemarks = implode(" ", $remarks);

// Display Report
echo "<h3>Student Performance Report</h3>";
echo "<p><strong>Overall Percentage:</strong> {$overallPercentage}%</p>";
echo "<p><strong>Overall Grade:</strong> {$overallGrade}</p>";
echo "<p><strong>Remarks:</strong> {$finalRemarks}</p>";
?>