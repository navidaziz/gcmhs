<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detailed Marks Certificate</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            background: #ccc;
        }


        @media print {
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            body,
            page {
                margin: 0;
                box-shadow: none;
            }

            page {
                page-break-before: always;
            }
        }

        page {
            background: #fff;
            display: block;
            margin: 0 auto 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
            color: black;
        }

        page[size="A4"] {
            width: 100%;
            height: auto;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: none;
            }

            page {
                page-break-before: always;
            }
        }

        .table,
        .table th,
        .table td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 2px;
            font-size: 12px;
        }

        .table_small th,
        .table_small td {
            font-size: 9px;
            padding: 2px;
            border: 0.1px solid gray;
            font-weight: bold;
        }

        .fail {
            display: inline-block;
            min-width: 19px;
            padding: 2px;
            border: 1px solid black;
            border-radius: 10px;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>

<body>
    <table style="width: 100%;">
        <tr>
            <td style="width: 80px;"><img src="<?php echo site_url("assets/log_outline.png"); ?>" alt="Logo" style="width:70px; height:70px;"></td>
            <td style="text-align: center;">
                <h4><strong>Government Centennial Model High School Boys Chitral</strong></h4>
                <h5><strong>Class <?php echo $class->Class_title; ?>, Section <?php echo $section->section_title; ?></strong></h5>
            </td>
        </tr>
    </table>

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

    <h2>Detailed Marks Certificate</h2>

    <?php

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
        WHERE exr.student_id = ? AND exr.exam_id = ? GROUP BY exr.exam_id";

    $exam_info = $this->db->query($query, [$student_id, $exam_id])->row();


    ?>
    <h3><?php echo $exam_info->year ?> | <?php echo $exam_info->term ?> </h3>
    <h4>Class: <?php echo $exam_info->Class_title ?> Section: <?php echo $exam_info->section_title ?></h4>
    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Subject</th>
                <th>Marks Obtained</th>
                <th>Total Marks</th>
                <th>Percentage</th>
                <th style="text-align: center;">Grade</th>
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
                    <th style="text-align: center;"><?php echo $row->grade; ?></th>
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
                <th>
                    <?php
                    $overall_percentage = $total_marks > 0 ? round(($total_obtained / $total_marks) * 100, 2) : 0;
                    echo $overall_percentage . '%';
                    ?>
                </th>
                <th style="text-align: center;">
                    <?php  // Overall grade
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

    <h4>Attendance History</h4>
    <table class="table_small" style="width:100%; font-size: 8px;">
        <thead>
            <tr>
                <th>Month / Days</th>
                <?php for ($day = 1; $day <= 31; $day++) { ?>
                    <th><?php echo $day; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php
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

            $currentYear = date('Y'); // This will be 2025

            foreach ($monthNames as $monthNum => $monthName) {
                $daysInMonth = date('t', mktime(0, 0, 0, $monthNum, 1, $currentYear));
            ?>
                <tr>
                    <th><?php echo $monthName; ?></th>
                    <?php
                    for ($day = 1; $day <= 31; $day++) {
                        if ($day > $daysInMonth) {
                            echo '<td></td>';
                            continue;
                        }

                        $query = "SELECT * FROM `students_attendance` WHERE `student_id` = ? 
                              AND YEAR(`date`) = ? 
                              AND MONTH(`date`) = ? 
                              AND DAY(`date`) = ?";
                        $students_attendance = $this->db->query($query, [
                            $student->student_id,
                            $currentYear,
                            $monthNum,
                            $day
                        ])->row();
                    ?>
                        <td style="text-align:center; 
                                <?php
                                if (!empty($students_attendance)) {
                                    // Set background color based on attendance status
                                    if ($students_attendance->attendance == 'A') {
                                        echo 'background-color: #D8534E;';  // Red for absent
                                    } elseif ($students_attendance->attendance == 'P') {
                                        if (empty($students_attendance->attendance2) || $students_attendance->attendance2 == 'P') {
                                            echo 'background-color: #96AE5F;';  // Green for present
                                        } elseif ($students_attendance->attendance2 == 'A') {
                                            echo 'background-color: #F0AD4E;';  // Orange for partial absence
                                        }
                                    }
                                }
                                ?>">
                            <small>
                                <?php
                                if (!empty($students_attendance)) {
                                    echo $students_attendance->attendance;
                                    if (!empty($students_attendance->attendance2)) {
                                        echo "-" . htmlspecialchars($students_attendance->attendance2);
                                    }
                                }
                                ?>
                            </small>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>