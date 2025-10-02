<style>
    body {
        font-family: "Arial", sans-serif;
        font-size: 12px;
        color: #000;
    }

    h2,
    h3,
    h4 {
        margin: 5px 0;
        text-align: center;
        font-weight: bold;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        margin: 10px 0;
    }

    table th,
    table td {
        border: 1px solid #333;
        padding: 6px;
        text-align: center;
    }

    table th {
        background: #f5f5f5;
        font-weight: bold;
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
        <td><?php echo $student->student_class_no; ?></td>
        <th>Admission No</th>
        <td><?php echo $student->student_admission_no; ?></td>
    </tr>
    <tr>
        <th>Student Name</th>
        <td><?php echo $student->student_name; ?></td>
        <th>Father Name</th>
        <td><?php echo $student->student_father_name; ?></td>
    </tr>
    <tr>
        <th>Date of Birth</th>
        <td><?php echo date("d M, Y", strtotime($student->student_data_of_birth)); ?></td>
        <th>Age</th>
        <td><?php echo (new DateTime())->diff(new DateTime($student->student_data_of_birth))->y; ?> years</td>
    </tr>
    <tr>
        <th>Form-B</th>
        <td><?php echo $student->form_b; ?></td>
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
<h3><?php echo $exam_info->year ?> | <?php echo $exam_info->term ?> </h3>
<h4>Class: <?php echo $exam_info->Class_title ?> | Section: <?php echo $exam_info->section_title ?></h4>

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
                <td><?php echo $count++; ?></td>
                <td class="text-left"><?php echo $row->subject_title; ?></td>
                <td>
                    <?php if ($row->obtain_mark === 'A'): ?>
                        <span style="color:red; font-weight:bold;">Absent</span>
                    <?php else: ?>
                        <?php echo $row->obtain_mark; ?>
                    <?php endif; ?>
                </td>
                <td><?php echo $row->total_marks; ?></td>
                <td><?php echo ($row->obtain_mark === 'A') ? '-' : $row->percentage . '%'; ?></td>
                <td><?php echo $row->grade; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="text-align:right;">Total</th>
            <th><?php echo $total_obtained; ?></th>
            <th><?php echo $total_marks; ?></th>
            <th><?php echo $overall_percentage . '%'; ?></th>
            <th><?php echo $overall_grade; ?></th>
        </tr>
    </tfoot>
</table>

<!-- Remarks -->
<div class="remarks">
    <strong>Performance Analysis:</strong><br>
    <?php echo $remarks; ?>
</div>

<!-- Attendance -->
<h4>Attendance History</h4>
<table class="attendance-table">
    <thead>
        <tr>
            <th>Month / Days</th>
            <?php for ($day = 1; $day <= 31; $day++) { ?>
                <th><?php echo $day; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monthNames as $monthNum => $monthName): ?>
            <tr>
                <th><?php echo $monthName; ?></th>
                <?php
                $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
                for ($day = 1; $day <= 31; $day++):
                    if ($day > $daysInMonth) {
                        echo "<td></td>";
                        continue;
                    }
                    $query = "SELECT * FROM students_attendance WHERE student_id=? 
                              AND YEAR(date)=? AND MONTH(date)=? AND DAY(date)=?";
                    $students_attendance = $this->db->query($query, [$student->student_id, $currentYear, $monthNum, $day])->row();
                    $bg = "";
                    if (!empty($students_attendance)) {
                        if ($students_attendance->attendance == 'A') $bg = "background:#D8534E; color:#fff;";
                        elseif ($students_attendance->attendance == 'P' && (empty($students_attendance->attendance2) || $students_attendance->attendance2 == 'P')) $bg = "background:#96AE5F; color:#fff;";
                        elseif ($students_attendance->attendance2 == 'A') $bg = "background:#F0AD4E; color:#000;";
                    }
                ?>
                    <td style="text-align:center; <?php echo $bg; ?>">
                        <small>
                            <?php if (!empty($students_attendance)) {
                                echo $students_attendance->attendance;
                                if (!empty($students_attendance->attendance2)) echo "-" . htmlspecialchars($students_attendance->attendance2);
                            } ?>
                        </small>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>