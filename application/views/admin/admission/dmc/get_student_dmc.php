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
// Example data from your query
$student_name = "Ali Khan";
$class = "6th";
$section = "B";
$exam = "Mid Term 2025";

$subjects = array(
    array("subject" => "Math", "obtain" => 65, "total" => 100),
    array("subject" => "English", "obtain" => 45, "total" => 100),
    array("subject" => "Science", "obtain" => 75, "total" => 100),
    array("subject" => "Urdu", "obtain" => 55, "total" => 100),
    array("subject" => "Computer", "obtain" => 85, "total" => 100),
);

// Helper function for grade
function get_grade($percentage)
{
    if ($percentage >= 80) return "A+";
    elseif ($percentage >= 70) return "A";
    elseif ($percentage >= 60) return "B";
    elseif ($percentage >= 50) return "C";
    elseif ($percentage >= 40) return "D";
    else return "F";
}

// Table
$total_obtained = 0;
$total_marks = 0;

echo "<h3>Student Report Card</h3>";
echo "<p><strong>Name:</strong> $student_name<br>";
echo "<strong>Class:</strong> $class<br>";
echo "<strong>Section:</strong> $section<br>";
echo "<strong>Exam:</strong> $exam</p>";

echo "<table border='1' cellpadding='6' cellspacing='0'>
        <tr>
            <th>Subject</th>
            <th>Obtained Marks</th>
            <th>Total Marks</th>
            <th>Percentage</th>
            <th>Grade</th>
        </tr>";

foreach ($subjects as $s) {
    $percentage = round(($s["obtain"] / $s["total"]) * 100, 2);
    $grade = get_grade($percentage);

    echo "<tr>
            <td>{$s['subject']}</td>
            <td>{$s['obtain']}</td>
            <td>{$s['total']}</td>
            <td>{$percentage}%</td>
            <td>{$grade}</td>
          </tr>";

    $total_obtained += $s["obtain"];
    $total_marks += $s["total"];
}

$overall_percentage = round(($total_obtained / $total_marks) * 100, 2);
$overall_grade = get_grade($overall_percentage);

echo "<tr style='font-weight:bold; background:#f2f2f2'>
        <td>Total</td>
        <td>$total_obtained</td>
        <td>$total_marks</td>
        <td>$overall_percentage%</td>
        <td>$overall_grade</td>
      </tr>";
echo "</table>";

// Performance Analysis
$strong = array();
$weak = array();

foreach ($subjects as $s) {
    $percentage = ($s["obtain"] / $s["total"]) * 100;
    if ($percentage >= 70) {
        $strong[] = $s["subject"];
    } elseif ($percentage < 50) {
        $weak[] = $s["subject"];
    }
}

echo "<h4>Performance Analysis</h4>";
echo "<p>$student_name showed excellent performance in <strong>" . implode(", ", $strong) . "</strong>.</p>";

if (!empty($weak)) {
    echo "<p>However, the student needs improvement in <strong>" . implode(", ", $weak) . "</strong>.</p>";
} else {
    echo "<p>No weak subjects identified. Overall performance is consistent.</p>";
}

echo "<p><strong>Final Remarks:</strong> Based on the overall grade <strong>$overall_grade</strong> ($overall_percentage%), the student ";
if ($overall_grade == "A+" || $overall_grade == "A") {
    echo "is performing excellently. Keep up the great work!";
} elseif ($overall_grade == "B") {
    echo "is doing well but can push for higher achievement.";
} elseif ($overall_grade == "C") {
    echo "has shown average performance and needs more focus.";
} elseif ($overall_grade == "D") {
    echo "is struggling and should dedicate extra time to studies.";
} else {
    echo "needs serious improvement and consistent effort.";
}
echo "</p>";
?>