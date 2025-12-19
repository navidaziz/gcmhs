<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Detailed Marks Certificate</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <style>
        body {
            background: #ccc;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Base table */
        .table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            background-color: transparent;
            border-collapse: collapse;

        }

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            padding: 2px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
            font-size: 12px !important;
        }

        .table>thead>tr>th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
        }

        /* Bordered */
        .table-bordered {
            border: 1px solid #ddd;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
        }

        /* Striped */
        .table-striped>tbody>tr:nth-child(odd)>td,
        .table-striped>tbody>tr:nth-child(odd)>th {
            background-color: #f9f9f9;
        }

        /* Hover */
        .table-hover>tbody>tr:hover>td,
        .table-hover>tbody>tr:hover>th {
            background-color: #f5f5f5;
        }

        /* Condensed */
        .table-condensed th,
        .table-condensed td {
            padding: 5px;
        }

        /* Page wrapper */
        .page {
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

            .page {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
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
            font-size: 12px;
        }

        .marks-table td {
            font-size: 12px;
            text-align: center;
        }

        .marks-table tfoot th {
            background: #eee;
            font-weight: bold;
        }

        .remarks {
            margin-top: 18px;
            font-size: 12px;
            text-align: justify;
        }

        .attendance-table th,
        .attendance-table td {
            font-size: 8px;
            text-align: center;
            padding: 0;
            margin: 0;
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

        /* Small table */
        .table_small {
            width: 100%;
            border-collapse: collapse;
        }

        .table_small th,
        .table_small td {
            font-size: 9px;
            padding: 2px 4px;
            border: 0.1px solid gray;
            text-align: center;
            font-weight: bold;
        }

        .table_small th {
            background: #f2f2f2;
        }

        .table_small tfoot th {
            background: #e9e9e9;
            font-weight: bold;
        }

        .checkbox {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            vertical-align: middle;
            margin: 0 5px;
        }

        .checked {
            display: inline-block;
            width: 16px;
            height: 16px;
            border: 1px solid #000;
            vertical-align: middle;
            margin: 0 5px;
            color: #000;
        }
    </style>


    <style>
        .page-break {
            page-break-before: always;
            break-before: page;
        }
    </style>
</head>

<body>
    <div class="page">


        </head>

        <body>


            <?php foreach ($students as $student) {
                $student_id = $student->student_id;
                $query = "SELECT * FROM students WHERE student_id ='" . $student_id . "'";
                $student = $this->db->query($query)->row();
            ?>
                <page size="A4">
                    <!-- HEADER -->
                    <table class="header-table" style="width:100%;">
                        <tr>
                            <td style="width:80px;">
                                <img src="<?php echo site_url("assets/log_outline.png"); ?>" alt="Logo" style="width:100px; ">
                            </td>
                            <td style="text-align:center;">
                                <h2>Government Centennial Model High School Boys Chitral</h2>
                                <h5><strong>Progress Report</strong></h5>

                                <?php
                                // === QUERY: Exam Info ===
                                $query = "SELECT 
                            ex.year,
                            ex.term,
                            ex.exam_data,
                            ex.previous_semester_id,
                            ex.promotion_percentage,
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

                                <h3>Class: <?php echo $exam_info->Class_title ?> | Section: <?php echo $exam_info->section_title ?></h3>
                            </td>
                            <td>
                                <img src="https://cdn.vectorstock.com/i/1000v/31/70/kpese-elementary-secondary-education-department-vector-24843170.jpg" alt="Logo" style="width:100px; ">
                            </td>
                        </tr>
                    </table>

                    <!-- STUDENT INFO -->
                    <table class="table table-bordered" style="margin-top:10px; font-size: 12px; !important">

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
                                WHERE exr.student_id = ? AND exr.exam_id = ?
                                ORDER BY sub.subject_id;";

                    $current_semester_result = $this->db->query($query, [$student_id, $exam_id])->result();

                    $first_total_obtained = 0;
                    $first_total_marks = 0;
                    $weak_subjects = [];
                    $strong_subjects = [];
                    $absent_subjects = [];
                    ?>


                    <table>
                        <tr>
                            <td style="vertical-align: top; width: 50%;">
                                <?php
                                // === QUERY: Subjects & Marks (Previous Semester) ===
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
                            WHERE exr.student_id = ? AND exr.exam_id = ?
                            ORDER BY sub.subject_id;";

                                $previous_semester_result = $this->db
                                    ->query($query, [$student_id, $exam_info->previous_semester_id])
                                    ->result();
                                ?>
                                <div style="border: 2px solid black; padding: 5px;">

                                    <table class="table table-bordered" style="margin-top:10px; font-size:12px !important">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">S #</th>
                                                <th rowspan="2">SUBJECTS</th>
                                                <th style="text-align: center;" colspan="3">
                                                    <?php
                                                    $query = "SELECT * FROM exams WHERE exam_id = ?";
                                                    $previous_exam_info = $this->db
                                                        ->query($query, [$exam_info->previous_semester_id])
                                                        ->row();
                                                    ?>
                                                    <?php echo $previous_exam_info->year ?> | <?php echo $previous_exam_info->term ?>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Total Marks</th>
                                                <th>Marks Obtained</th>
                                                <th>Weightage <br />45%</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $serial_no = 1;
                                            $previous_total_marks = 0;
                                            $previous_total_obtained = 0;
                                            $current_total_marks = 0;
                                            $current_total_obtained = 0;
                                            $previous_weightage_total = 0;
                                            $first_semester_weightages = [];

                                            foreach ($previous_semester_result as $row): ?>
                                                <tr>
                                                    <th><?php echo $serial_no; ?></th>
                                                    <td style="width: 500px;"><?php echo $row->subject_title; ?></td>
                                                    <td><?php echo $row->total_marks; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($row->obtain_mark === 'A') {
                                                            echo "<span style='color:red;font-weight:bold;'>Absent</span>";
                                                            // $absent_subjects[] = $row->subject_title;
                                                        } else {
                                                            echo $row->obtain_mark;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        //echo $row->percentage . " - ";
                                                        $previous_weightage = round((($row->percentage * 45) / 100), 2);
                                                        $first_semester_weightages[] = $previous_weightage;
                                                        $previous_weightage_total += $previous_weightage;

                                                        echo ($row->obtain_mark === 'A') ? '-' : $previous_weightage . '%';
                                                        ?>
                                                    </td>
                                                </tr>

                                            <?php
                                                if ($row->obtain_mark !== 'A') {
                                                    $previous_total_obtained += $row->obtain_mark;
                                                    $previous_total_marks += $row->total_marks;

                                                    // if ($row->percentage < 50) {
                                                    //     $weak_subjects[] = $row->subject_title;
                                                    // } elseif ($row->percentage >= 70) {
                                                    //     $strong_subjects[] = $row->subject_title;
                                                    // }
                                                }
                                                $serial_no++;
                                            endforeach;
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th rowspan="4"></th>
                                                <th>G. TOTAL</th>
                                                <th><?php echo $previous_total_marks; ?></th>
                                                <th><?php echo $previous_total_obtained; ?></th>
                                                <th><?php //echo $previous_weightage_total; 
                                                    ?></th>
                                            </tr>

                                            <tr>
                                                <th colspan="2">PERCENTAGE</th>
                                                <th>
                                                    <?php
                                                    $overall_percentage = $previous_total_marks > 0
                                                        ? round(($previous_total_obtained / $previous_total_marks) * 100, 2)
                                                        : 0;
                                                    echo $overall_percentage . '%';
                                                    ?>
                                                </th>
                                                <th>
                                                    <?php
                                                    $overall_weighted_percentage = $previous_total_marks > 0
                                                        ? round(($previous_total_obtained / $previous_total_marks) * 45, 2)
                                                        : 0;
                                                    echo $overall_weighted_percentage . '%';
                                                    ?>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th colspan="2">GRADE</th>
                                                <th><?php echo get_grade($overall_percentage); ?></th>
                                                <th></th>
                                            </tr>

                                            <tr>
                                                <th colspan="2">POSITION</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <table class="table table-bordered" style="margin-top:10px; font-size:12px !important">
                                        <tr>
                                            <th>ATTENDANCE</th>
                                            <th>SEMESTER-I</th>
                                            <th>SEMESTER-II</th>
                                        </tr>
                                        <tr>
                                            <?php
                                            $query = "SELECT COUNT(*) AS total_attendance, 
                                                SUM(CASE WHEN attendance = 'P' THEN 1 ELSE 0 END) AS attended 
                                                FROM students_attendance 
                                                WHERE student_id = '" . $student_id . "' 
                                                AND `date` BETWEEN '" . date('Y', strtotime($exam_info->exam_data)) . "-03-01' 
                                                AND '" . date('Y', strtotime($exam_info->exam_data)) . "-06-30';";
                                            $first_semeter_attendance = $this->db->query($query)->row();

                                            $first_punctuality = $first_semeter_attendance->total_attendance > 0
                                                ? round(($first_semeter_attendance->attended / $first_semeter_attendance->total_attendance) * 100, 2)
                                                : 0;

                                            $query = "SELECT COUNT(*) AS total_attendance, 
                                                SUM(CASE WHEN attendance = 'P' THEN 1 ELSE 0 END) AS attended 
                                                FROM students_attendance 
                                                WHERE student_id = '" . $student_id . "' 
                                                AND `date` BETWEEN '" . date('Y', strtotime($exam_info->exam_data)) . "-08-01' 
                                                AND '" . date('Y', strtotime($exam_info->exam_data)) . "-12-30';";
                                            $second_semeter_attendance = $this->db->query($query)->row();
                                            $second_punctuality = $second_semeter_attendance->total_attendance > 0
                                                ? round(($second_semeter_attendance->attended / $second_semeter_attendance->total_attendance) * 100, 2)
                                                : 0;
                                            ?>
                                            <th>Total Working Days</th>
                                            <td><?php echo $first_semeter_attendance->total_attendance; ?></td>
                                            <td><?php echo $second_semeter_attendance->total_attendance; ?></td>

                                        </tr>
                                        <tr>
                                            <th>Days Attended </th>
                                            <td><?php echo $first_semeter_attendance->attended; ?></td>
                                            <td><?php echo $second_semeter_attendance->attended; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </td>

                            <td style="vertical-align: top; width: 50%;">
                                <div style="border: 2px solid black; padding: 5px;">
                                    <table class="table table-bordered" style="margin-top:10px; font-size:12px !important">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;" colspan="3">
                                                    <?php
                                                    $query = "SELECT * FROM exams WHERE exam_id = ?";
                                                    $current_exam_info = $this->db->query($query, [$exam_id])->row();
                                                    ?>
                                                    <?php echo $current_exam_info->year ?> | <?php echo $current_exam_info->term ?>
                                                </th>
                                                <th rowspan="2">
                                                    Aggregate Weightage I + II
                                                </th>
                                            </tr>

                                            <tr>
                                                <th>Total Marks</th>
                                                <th>Marks Obtained</th>
                                                <th>Weightage <br />55%</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            $subject_index = 0;
                                            $current_weightage_total = 0;

                                            foreach ($current_semester_result as $row):

                                            ?>
                                                <tr>
                                                    <td><?php echo $row->total_marks; ?></td>

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

                                                    <td>
                                                        <?php
                                                        // echo $row->percentage . " - ";
                                                        $current_weightage = round((($row->percentage * 55) / 100), 2);
                                                        $current_weightage_total += $current_weightage;

                                                        echo ($row->obtain_mark === 'A') ? '-' : $current_weightage . '%';
                                                        ?>
                                                    </td>

                                                    <td>
                                                        <?php
                                                        $aggregate_weightage =
                                                            $first_semester_weightages[$subject_index] + $current_weightage;

                                                        if ($aggregate_weightage < 50) {
                                                            $weak_subjects[] = $row->subject_title;
                                                        } elseif ($aggregate_weightage >= 70) {
                                                            $strong_subjects[] = $row->subject_title;
                                                        }

                                                        echo "{$first_semester_weightages[$subject_index]} + {$current_weightage} = {$aggregate_weightage}%";
                                                        ?>
                                                    </td>
                                                </tr>

                                            <?php
                                                if ($row->obtain_mark !== 'A') {
                                                    $current_total_obtained += $row->obtain_mark;
                                                    $current_total_marks += $row->total_marks;
                                                }
                                                $subject_index++;
                                            endforeach;
                                            ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <th><?php echo $current_total_marks; ?></th>
                                                <th><?php echo $current_total_obtained; ?></th>
                                                <th><?php //echo $current_weightage_total; 
                                                    ?></th>
                                                <th><?php echo $previous_total_obtained + $current_total_obtained;
                                                    echo " / ";
                                                    echo $previous_total_marks + $current_total_marks; ?></th>
                                            </tr>

                                            <tr>
                                                <th></th>
                                                <th>
                                                    <?php
                                                    $current_overall_percentage = $current_total_marks > 0
                                                        ? round(($current_total_obtained / $current_total_marks) * 100, 2)
                                                        : 0;
                                                    echo $current_overall_percentage . '%';
                                                    ?>
                                                </th>
                                                <th>
                                                    <?php
                                                    $current_overall_weighted_percentage = $current_total_marks > 0
                                                        ? round(($current_total_obtained / $current_total_marks) * 55, 2)
                                                        : 0;
                                                    echo $current_overall_weighted_percentage . '%';
                                                    ?>
                                                </th>
                                                <th><?php echo  $overall_weighted_percentage + $current_overall_weighted_percentage . '%'; ?></th>
                                            </tr>

                                            <tr>
                                                <th></th>
                                                <th><?php echo get_grade($current_overall_percentage); ?></th>
                                                <th> - </th>
                                                <th>

                                                    <?php

                                                    $overall_grade = get_grade($overall_weighted_percentage + $current_overall_weighted_percentage);
                                                    echo $overall_grade;
                                                    ?>
                                                </th>
                                            </tr>

                                            <tr>
                                                <th style="height:16px"></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>

                                    <table class="table table-bordered" style="margin-top:10px; font-size:12px !important">
                                        <thead>
                                            <tr>
                                                <th style="text-align:left;">TRAITS</th>
                                                <th>SEMESTER-I</th>
                                                <th>SEMESTER-II</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Punctuality</td>
                                                <td><?php echo $first_punctuality . "%";  ?></td>
                                                <td><?php echo $second_punctuality . "%";  ?></td>
                                            </tr>
                                            <tr>
                                                <td>Responsibility</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Sociability</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td>Tidy &amp; Neatness</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="final-row">
                                        Final Result:
                                        <?php if ($current_overall_percentage >= $exam_info->promotion_percentage) { ?>
                                            <span><strong> Promoted</strong></span>
                                        <?php } else { ?>
                                            <span><strong> Not Promoted</strong></span>
                                        <?php } ?>

                                    </div>
                                </div>
                            </td>


                        </tr>
                    </table>

                    <?php
                    // === Remarks generation ===
                    $over_all_agg = $overall_weighted_percentage + $current_overall_weighted_percentage;
                    $remarks = "The student achieved an overall percentage of <b>{$over_all_agg}%</b>, securing an overall grade of <b>{$overall_grade}</b>. ";
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
                    <div class="rema rks">
                        <h5 style="text-align: left;">Performance Analysis on Aggregate</h5>
                        <p style="font-size: 12px;"><i><?php echo $remarks; ?></i></p>
                    </div>


                    <br />
                    <br />
                    <br />
                    <!-- SIGNATURES -->
                    <div class="signature">
                        <div>
                            <img src="<?php echo site_url("assets/school_head.png"); ?>" alt="signature" style="width:100px; margin-top:-50px ">
                            School Head
                        </div>
                        <div>Parents Signature</div>
                    </div>

                </page>
                <div class="page-break">
                    <p style="text-align: center;"><i><small>“Computer-generated report card. Errors and omissions excepted.”</small></i></p>
                </div>
            <?php } ?>

        </body>

</html>