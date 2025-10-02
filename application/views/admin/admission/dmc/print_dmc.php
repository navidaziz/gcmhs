<!-- ================= Student Info ================= -->
<h2 class="text-center" style="margin-bottom:20px;">Detailed Marks Certificate</h2>

<table class="table table-bordered table-striped" style="width: 100%; margin-bottom: 20px; font-size: 13px;">
    <thead style="background: #f5f5f5; font-weight: bold;">
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
    </thead>
    <tbody>
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
                        echo "<span class='label label-danger'>Deleted</span>";
                        break;
                    case 1:
                        echo "<span class='label label-success'>Admit</span>";
                        break;
                    case 2:
                        echo "<span class='label label-warning'>Struck Off</span>";
                        break;
                    case 3:
                        echo "<span class='label label-info'>Withdraw</span>";
                        break;
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>


<!-- ================= Exam Info ================= -->
<h3 class="text-center" style="margin-top:30px; margin-bottom:5px;">
    <?php echo $exam_info->year ?> | <?php echo $exam_info->term ?>
</h3>
<h4 class="text-center" style="margin-bottom:20px;">
    Class: <?php echo $exam_info->Class_title ?> &nbsp; | &nbsp; Section: <?php echo $exam_info->section_title ?>
</h4>


<!-- ================= Marks Table ================= -->
<table class="table table-bordered" style="width:100%; font-size: 13px; margin-bottom:20px;">
    <thead style="background: #efefef; text-align: center;">
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:30%;">Subject</th>
            <th style="width:15%;">Marks Obtained</th>
            <th style="width:15%;">Total Marks</th>
            <th style="width:15%;">Percentage</th>
            <th style="width:10%;">Grade</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1;
        foreach ($result as $row): ?>
            <tr>
                <td class="text-center"><?php echo $count++; ?></td>
                <td><?php echo $row->subject_title; ?></td>
                <td class="text-center">
                    <?php
                    if ($row->obtain_mark === 'A') {
                        echo "<span class='text-danger'><b>Absent</b></span>";
                        $absent_subjects[] = $row->subject_title;
                    } else {
                        echo $row->obtain_mark;
                    }
                    ?>
                </td>
                <td class="text-center"><?php echo $row->total_marks; ?></td>
                <td class="text-center"><?php echo ($row->obtain_mark === 'A') ? '-' : $row->percentage . '%'; ?></td>
                <td class="text-center"><b><?php echo $row->grade; ?></b></td>
            </tr>
        <?php
            $total_obtained += $row->obtain_mark;
            $total_marks += $row->total_marks;
            if ($row->percentage < 50) $weak_subjects[] = $row->subject_title;
            elseif ($row->percentage >= 70) $strong_subjects[] = $row->subject_title;
        endforeach; ?>
    </tbody>
    <tfoot style="font-weight:bold; background:#f9f9f9;">
        <tr>
            <td></td>
            <td>Total</td>
            <td class="text-center"><?php echo $total_obtained; ?></td>
            <td class="text-center"><?php echo $total_marks; ?></td>
            <td class="text-center">
                <?php
                $overall_percentage = $total_marks > 0 ? round(($total_obtained / $total_marks) * 100, 2) : 0;
                echo $overall_percentage . '%';
                ?>
            </td>
            <td class="text-center">
                <?php echo $overall_grade; ?>
            </td>
        </tr>
    </tfoot>
</table>


<!-- ================= Remarks ================= -->
<div style="margin-top:20px; margin-bottom:30px;">
    <h3>Performance Analysis</h3>
    <p style="line-height:1.6; font-size:13px;"><?php echo $remarks; ?></p>
</div>


<!-- ================= Attendance ================= -->
<h4 style="margin-top:30px;">Attendance History</h4>
<table class="table table-bordered table-condensed" style="width:100%; font-size: 10px; text-align:center;">
    <thead style="background:#f5f5f5;">
        <tr>
            <th style="width:80px;">Month / Days</th>
            <?php for ($day = 1; $day <= 31; $day++) { ?>
                <th style="width:18px;"><?php echo $day; ?></th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($monthNames as $monthNum => $monthName): ?>
            <tr>
                <td style="font-weight:bold;"><?php echo $monthName; ?></td>
                <?php
                $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
                for ($day = 1; $day <= 31; $day++) {
                    if ($day > $daysInMonth) {
                        echo "<td></td>";
                        continue;
                    }
                    $students_attendance = $this->db->query($query, [
                        $student->student_id,
                        $currentYear,
                        $monthNum,
                        $day
                    ])->row();
                    $cellStyle = "";
                    if (!empty($students_attendance)) {
                        if ($students_attendance->attendance == 'A') $cellStyle = "background:#D9534F;color:#fff;";
                        elseif ($students_attendance->attendance == 'P') {
                            if (empty($students_attendance->attendance2) || $students_attendance->attendance2 == 'P')
                                $cellStyle = "background:#5CB85C;color:#fff;";
                            elseif ($students_attendance->attendance2 == 'A')
                                $cellStyle = "background:#F0AD4E;color:#fff;";
                        }
                    }
                    echo "<td style='$cellStyle; font-size:9px;'>";
                    if (!empty($students_attendance)) {
                        echo $students_attendance->attendance;
                        if (!empty($students_attendance->attendance2)) {
                            echo "-" . htmlspecialchars($students_attendance->attendance2);
                        }
                    }
                    echo "</td>";
                }
                ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>