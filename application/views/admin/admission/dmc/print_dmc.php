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
            margin-top: 15px;
            font-size: 13px;
            text-align: justify;
        }

        .attendance-table th,
        .attendance-table td {
            font-size: 8px;
            text-align: center;
            padding: 2px;
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
    </style>
</head>

<body>
    <page size="A4">
        <!-- HEADER -->
        <table class="header-table" style="width:100%;">
            <tr>
                <td style="width:80px;">
                    <img src="<?php echo site_url("assets/log_outline.png"); ?>" alt="Logo" style="width:70px; height:70px;">
                </td>
                <td style="text-align:center;">
                    <h3>Government Centennial Model High School Boys Chitral</h3>
                    <h4>Class <?php echo $class->Class_title; ?>, Section <?php echo $section->section_title; ?></h4>
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
                <td><?php echo ["Deleted", "Admit", "Struck Off", "Withdraw"][$student->status]; ?></td>
            </tr>
        </table>

        <!-- MARKS CERTIFICATE -->
        <h2>Detailed Marks Certificate</h2>
        <h4><?php echo $exam_info->year ?> | <?php echo $exam_info->term ?></h4>
        <h4>Class: <?php echo $exam_info->Class_title ?> | Section: <?php echo $exam_info->section_title ?></h4>

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
                <!-- PHP loop here -->
            </tbody>
            <tfoot>
                <!-- Totals here -->
            </tfoot>
        </table>

        <!-- REMARKS -->
        <div class="remarks">
            <h4>Performance Analysis</h4>
            <p><?php echo $remarks; ?></p>
        </div>

        <!-- ATTENDANCE -->
        <h4>Attendance History</h4>
        <table class="table table-bordered attendance-table">
            <!-- attendance grid -->
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