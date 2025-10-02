<?php
// --- Fetch Student Info ---
$student = $this->db->where('student_id', $student_id)->get('students')->row();

// --- Fetch Exam Info ---
$query = "SELECT 
            ex.year,
            ex.term,
            c.class_title,
            sec.section_title
          FROM students_exams_subjects_marks AS exr
          INNER JOIN exams AS ex ON ex.exam_id = exr.exam_id
          INNER JOIN classes AS c ON c.class_id = exr.class_id
          INNER JOIN sections AS sec ON sec.section_id = exr.section_id
          WHERE exr.student_id = ? AND exr.exam_id = ?
          GROUP BY exr.exam_id";

$exam_info = $this->db->query($query, [$student_id, $exam_id])->row();

// --- Fetch Subjects & Marks ---
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
                WHEN exr.percentage > 33 THEN 'E'
                ELSE 'F'
            END AS grade
          FROM students_exams_subjects_marks AS exr
          INNER JOIN exams AS ex ON ex.exam_id = exr.exam_id
          INNER JOIN classes AS c ON c.class_id = exr.class_id
          INNER JOIN sections AS sec ON sec.section_id = exr.section_id
          INNER JOIN subjects AS sub ON sub.subject_id = exr.subject_id
          WHERE exr.student_id = ? AND exr.exam_id = ?";

$result = $this->db->query($query, [$student_id, $exam_id])->result();

// --- Initialize Totals ---
$total_obtained = 0;
$total_marks    = 0;
$weak_subjects  = [];
$strong_subjects = [];
$absent_subjects = [];

// --- Month Names for Attendance ---
$monthNames = [
    '01' => 'January',
    '02' => 'February',
    '03' => 'March',
    '04' => 'April',
    '05' => 'May',
    '06' => 'June',
    '07' => 'July',
    '08' => 'August',
    '09' => 'September',
    '10' => 'October',
    '11' => 'November',
    '12' => 'December'
];
$currentYear = date('Y');
?>

<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    h2,
    h3,
    h4 {
        text-align: center;
        margin: 5px 0;
        font-weight: bold;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin: 10px 0;
    }

    th,
    td {
        border: 1px solid #333;
        padding: 6px;
        text-align: center;
    }

    th {
        background: #f5f5f5;
    }

    .student-info th {
        width: 15%;
        text-align: left;
        background: #f0f0f0;
    }

    .student-info td {
        text-align: left;
    }

    .remarks {
        border: 1px solid #333;
        padding: 10px;
        margin-top: 15px;
        font-size: 13px;
        line-height: 1.4;
    }

    .attendance-table th,
    .attendance-table td {
        font-size: 9px;
        padding: 2px;
    }

    .attendance-table th {
        background: #eee;
    }

    .text-left {
        text-align: left;
    }
</style>

<!-- Student Info -->
<h2>Detailed Marks Certificate</h2>
<table class="student-info">
    <tr>
        <th>Class No</th>
        <td><?= $student->student_class_no; ?></td>
        <th>Admission No</th>
        <td><?= $student->student_admission_no; ?></td>
    </tr>
    <tr>
        <th>Student Name</th>
        <td><?= $student->student_name; ?></td>
        <th>Father Name</th>
        <td><?= $student->student_father_name; ?></td>
    </tr>
    <tr>
        <th>Date of Birth</th>
        <td><?= date("d M, Y", strtotime($student->student_data_of_birth)); ?></td>
        <th>Age</th>
        <td><?= (new DateTime())->diff(new DateTime($student->student_data_of_birth))->y; ?> years</td>
    </tr>
    <tr>
        <th>Form-B</th>
        <td><?= $student->form_b; ?></td>
        <th>Status</th>
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

<!-- Exam Info -->
<h3><?= $exam_info->year ?> | <?= $exam_info->term ?></h3>
<h4>Class: <?= $exam_info->class_title ?> | Section: <?= $exam_info->section_title ?></h4>

<!-- Marks Table -->
<table>
    <thead>
        <tr>
            <th>#</th>
            <th class="text-left">Subject</th>
            <th>Marks Obtained</th>
            <th>Total Marks</th>
            <th>Percentage</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1;
        foreach ($result as $row): ?>
            <tr>
                <td><?= $count++; ?></td>
                <td class="text-left"><?= $row->subject_title; ?></td>
                <td>
                    <?php if ($row->obtain_mark === 'A'): ?>
                        <span style="color:red;font-weight:bold;">Absent</span>
                        <?php $absent_subjects[] = $row->subject_title; ?>
                    <?php else: ?>
                        <?= $row->obtain_mark; ?>
                        <?php
                        $total_obtained += $row->obtain_mark;
                        $total_marks += $row->total_marks;
                        if ($row->percentage < 50) $weak_subjects[] = $row->subject_title;
                        elseif ($row->percentage >= 70) $strong_subjects[] = $row->subject_title;
                        ?>
                    <?php endif; ?>
                </td>
                <td><?= $row->total_marks; ?></td>
                <td><?= ($row->obtain_mark === 'A') ? '-' : $row->percentage . '%'; ?></td>
                <td><?= $row->grade; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <?php
        $overall_percentage = $total_marks > 0 ? round(($total_obtained / $total_marks) * 100, 2) : 0;
        if ($overall_percentage >= 80) $overall_grade = 'A+';
        elseif ($overall_percentage >= 70) $overall_grade = 'A';
        elseif ($overall_percentage >= 60) $overall_grade = 'B';
        elseif ($overall_percentage >= 50) $overall_grade = 'C';
        elseif ($overall_percentage >= 40) $overall_grade = 'D';
        elseif ($overall_percentage > 33) $overall_grade = 'E';
        else $overall_grade = 'F';
        ?>
        <tr>
            <th colspan="2" style="text-align:right;">Total</th>
            <th><?= $total_obtained; ?></th>
            <th><?= $total_marks; ?></th>
            <th><?= $overall_percentage . '%'; ?></th>
            <th><?= $overall_grade; ?></th>
        </tr>
    </tfoot>
</table>

<!-- Remarks -->
<?php
$remarks = "The student achieved <b>{$overall_percentage}%</b>, securing grade <b>{$overall_grade}</b>. ";
if (!empty($strong_subjects)) $remarks .= "Strong in <b>" . implode(", ", $strong_subjects) . "</b>. ";
if (!empty($weak_subjects)) $remarks .= "Needs improvement in <b>" . implode(", ", $weak_subjects) . "</b>. ";
if (!empty($absent_subjects)) $remarks .= "Absent in <b>" . implode(", ", $absent_subjects) . "</b>. ";
if (empty($weak_subjects) && empty($absent_subjects)) $remarks .= "Overall good performance in all subjects.";
?>
<div class="remarks"><strong>Performance Analysis:</strong><br><?= $remarks; ?></div>

<!-- Attendance -->
<h4>Attendance History</h4>
<table class="attendance-table">
    <thead>
        <tr>
            <th>Month / Days</th>
            <?php for ($day = 1; $day <= 31; $day++): ?>
                <th><?= $day; ?></th>
            <?php endfor; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monthNames as $monthNum => $monthName): ?>
            <tr>
                <th><?= $monthName; ?></th>
                <?php
                $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
                for ($day = 1; $day <= 31; $day++):
                    if ($day > $daysInMonth) {
                        echo "<td></td>";
                        continue;
                    }
                    $query = "SELECT * FROM students_attendance WHERE student_id=? 
                          AND YEAR(date)=? AND MONTH(date)=? AND DAY(date)=?";
                    $att = $this->db->query($query, [$student->student_id, $currentYear, $monthNum, $day])->row();
                    $bg = "";
                    if (!empty($att)) {
                        if ($att->attendance == 'A') $bg = "background:#D8534E;color:#fff;";
                        elseif ($att->attendance == 'P' && (empty($att->attendance2) || $att->attendance2 == 'P')) $bg = "background:#96AE5F;color:#fff;";
                        elseif ($att->attendance2 == 'A') $bg = "background:#F0AD4E;color:#000;";
                    }
                ?>
                    <td style="text-align:center;<?= $bg; ?>">
                        <small>
                            <?php if (!empty($att)) {
                                echo $att->attendance;
                                if (!empty($att->attendance2)) echo "-" . htmlspecialchars($att->attendance2);
                            } ?>
                        </small>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>