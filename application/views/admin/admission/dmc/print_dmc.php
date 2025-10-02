<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detailed Marks Certificate</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <style>
        body {
            background: #ccc;
            font-family: "Times New Roman", serif;
        }

        page {
            background: #fff;
            display: block;
            margin: 10px auto;
            padding: 25px 30px;
            width: 210mm;
            min-height: 297mm;
            box-shadow: 0 0 0.4cm rgba(0, 0, 0, 0.3);
            color: #000;
        }

        @page {
            margin: 15mm;
        }

        @media print {
            body {
                background: none;
            }

            page {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
            }
        }

        h2,
        h3,
        h4 {
            margin: 5px 0;
            font-weight: bold;
            text-align: center;
        }

        .header-table td {
            border: none !important;
        }

        .student-info th,
        .student-info td {
            font-size: 12px;
            padding: 5px;
        }

        .marks-table th {
            background: #f2f2f2;
            text-align: center;
            font-size: 15px;
        }

        .marks-table td {
            font-size: 15px;
            text-align: center;
        }

        .marks-table tfoot th {
            background: #eee;
            font-weight: bold;
        }

        .remarks {
            margin-top: 15px;
            font-size: 15px;
            text-align: justify;
        }

        .attendance-table th,
        .attendance-table td {
            font-size: 8px;
            text-align: center;
            padding: 0px;
            margin: 0px
        }

        .signature {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }

        .signature div {
            text-align: center;
            width: 30%;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        .table_small {
            width: 100%;
            border-collapse: collapse;
        }

        .table_small th,
        .table_small td {
            font-size: 9px;
            padding: 2px 4px;
            /* small padding but readable */
            border: 0.1px solid gray;
            text-align: center;
            font-weight: bold;
        }

        .table_small th {
            background: #f2f2f2;
            /* light gray for header */
        }

        .table_small tfoot th {
            background: #e9e9e9;
            font-weight: bold;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .table_small th,
            .table_small td {
                background-color: auto;
                -webkit-print-color-adjust: exact !important;
            }
        }
    </style>

</head>

<body>
    <page size="A4">
        <!-- HEADER -->
        <table class="header-table" style="width:100%;">
            <tr>
                <td style="width:80px;">
                    <img src="<?php echo site_url("assets/log_outline.png"); ?>" alt="Logo" style="width:100px; ">
                </td>
                <td style="text-align:center;">
                    <h3>Government Centennial Model High School Boys Chitral</h3>
                    <h4><strong>Detailed Marks Certificate</strong></h4>

                    <?php
                    // === QUERY: Exam Info ===
                    $query = "SELECT 
                        ex.year,
                        ex.term,
                        c.Class_title,
                        sec.section_title
                    FROM students_exams_subjects_marks AS exr 
                    INNER JOIN exams AS ex ON ex.exam_id = exr.exam_id 
                    INNER JOIN classes AS c ON c.class_id = exr.class_id 
                    INNER JOIN sections AS sec ON sec.section_id = exr.section_id
                    INNER JOIN subjects as sub ON sub.subject_id = exr.subject_id
                    WHERE exr.student_id = ? AND exr.exam_id = ? 
                    GROUP BY exr.exam_id";

                    $exam_info = $this->db->query($query, [$student_id, $exam_id])->row();
                    ?>

                    <h4><?php echo $exam_info->year ?> | <?php echo $exam_info->term ?> </h4>
                    <h4>Class: <?php echo $exam_info->Class_title ?> | Section: <?php echo $exam_info->section_title ?></h4>
                </td>
            </tr>
        </table>

        <!-- STUDENT INFO -->
        <table class="table table-bordered student-info" style="margin-top:10px;">
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
        // === QUERY: Subjects & Marks ===
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
        INNER JOIN subjects as sub ON sub.subject_id = exr.subject_id
        WHERE exr.student_id = ? AND exr.exam_id = ?;";

        $result = $this->db->query($query, [$student_id, $exam_id])->result();

        $total_obtained = 0;
        $total_marks = 0;
        $weak_subjects = [];
        $strong_subjects = [];
        $absent_subjects = [];
        ?>



        <!-- MARKS TABLE -->
        <table class="table table-bordered marks-table" style="margin-top:10px;">
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
                        <td><?php echo ($row->obtain_mark === 'A') ? '-' : $row->percentage . '%'; ?></td>
                        <th><?php echo $row->grade; ?></th>
                    </tr>

                    <?php
                    if ($row->obtain_mark !== 'A') {
                        $total_obtained += $row->obtain_mark;
                        $total_marks += $row->total_marks;

                        if ($row->percentage < 50) {
                            $weak_subjects[] = $row->subject_title;
                        } elseif ($row->percentage >= 70) {
                            $strong_subjects[] = $row->subject_title;
                        }
                    }
                    ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th>Total</th>
                    <th><?php echo $total_obtained; ?></th>
                    <th><?php echo $total_marks; ?></th>
                    <th>
                        <?php
                        $overall_percentage = $total_marks > 0 ? round(($total_obtained / $total_marks) * 100, 2) : 0;
                        echo $overall_percentage . '%';
                        ?>
                    </th>
                    <th>
                        <?php
                        if ($overall_percentage >= 80) $overall_grade = 'A+';
                        elseif ($overall_percentage >= 70) $overall_grade = 'A';
                        elseif ($overall_percentage >= 60) $overall_grade = 'B';
                        elseif ($overall_percentage >= 50) $overall_grade = 'C';
                        elseif ($overall_percentage >= 40) $overall_grade = 'D';
                        elseif ($overall_percentage > 33) $overall_grade = 'E';
                        else $overall_grade = 'F';
                        echo $overall_grade;
                        ?>
                    </th>
                </tr>
            </tfoot>
        </table>

        <?php
        // === Remarks generation ===
        $remarks = "The student achieved an overall percentage of <b>{$overall_percentage}%</b>, securing an overall grade of <b>{$overall_grade}</b>. ";
        if (!empty($strong_subjects)) {
            $remarks .= "Strong performance was observed in <b>" . implode(", ", $strong_subjects) . "</b>. ";
        }
        if (!empty($weak_subjects)) {
            $remarks .= "Improvement needed in <b>" . implode(", ", $weak_subjects) . "</b>. ";
        }
        if (!empty($absent_subjects)) {
            $remarks .= "Absent in <b>" . implode(", ", $absent_subjects) . "</b>, affecting performance. ";
        }
        if (empty($weak_subjects) && empty($absent_subjects)) {
            $remarks .= "Overall, the student performed consistently across all subjects.";
        }
        ?>

        <!-- REMARKS -->
        <div class="remarks">
            <h4>Performance Analysis</h4>
            <p><?php echo $remarks; ?></p>
        </div>

        <!-- ATTENDANCE -->
        <h4>Attendance History</h4>
        <table class="table_small" style="width: 100%;">
            <thead>
                <tr>
                    <th></th>
                    <?php for ($day = 1; $day <= 31; $day++) { ?>
                        <th><?php echo $day; ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $monthNames = [
                    '01' => 'Jan',
                    '02' => 'Feb',
                    '03' => 'Mar',
                    '04' => 'Apr',
                    '05' => 'May',
                    '06' => 'Jun',
                    '07' => 'July',
                    '08' => 'Aug',
                    '09' => 'Sep',
                    '10' => 'Oct',
                    '11' => 'Nov',
                    '12' => 'Dec'
                ];
                $currentYear = date('Y');

                foreach ($monthNames as $monthNum => $monthName) {
                    $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
                    echo "<tr><th>{$monthName}</th>";
                    for ($day = 1; $day <= 31; $day++) {
                        if ($day > $daysInMonth) {
                            echo '<td></td>';
                            continue;
                        }
                        $query = "SELECT * FROM `students_attendance` WHERE `student_id` = ? 
                          AND YEAR(`date`) = ? AND MONTH(`date`) = ? AND DAY(`date`) = ?";
                        $students_attendance = $this->db->query($query, [
                            $student->student_id,
                            $currentYear,
                            $monthNum,
                            $day
                        ])->row();
                        echo '<td style="';
                        if (!empty($students_attendance)) {
                            if ($students_attendance->attendance == 'A') {
                                echo 'background:#D8534E;'; // absent
                            } elseif ($students_attendance->attendance == 'P') {
                                if (empty($students_attendance->attendance2) || $students_attendance->attendance2 == 'P') {
                                    echo 'background:#96AE5F;'; // present
                                } elseif ($students_attendance->attendance2 == 'A') {
                                    echo 'background:#F0AD4E;'; // partial
                                }
                            }
                        }
                        echo '"><small style="font-size:8px !important">';
                        if (!empty($students_attendance)) {
                            echo $students_attendance->attendance;
                            if (!empty($students_attendance->attendance2)) {
                                echo "-" . htmlspecialchars($students_attendance->attendance2);
                            }
                        }
                        echo '</small></td>';
                    }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- SIGNATURES -->
        <div class="signature">
            <div>Class Teacher</div>
            <div>Exam Controller</div>
            <div>Principal</div>
        </div>
    </page>
</body>

</html>