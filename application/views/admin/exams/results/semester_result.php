<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
    <meta charset="UTF-8">
    <title>Award List</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/css/bootstrap.min.css"); ?>">
    <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

    <!-- Bootstrap JS -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

    <!-- DataTables -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <style>
        body {
            font-size: 12px;
            font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
        }

        .dataTables_filter,
        .dataTables_info,
        .dt-button,
        .buttons-print {
            display: none !important;
        }

        h1 {
            font-size: 20px;
            margin: 20px 0;
        }

        table td,
        table th {
            vertical-align: middle !important;
        }
    </style>

    <script>
        document.title = "Award List Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>) <?php echo $exam->term . ' ' . $exam->year ?>";
    </script>
</head>

<body>

    <div class="container-fluid">
        <section class="mt-4">
            <div class="table-responsive">
                <table id="example" class="table table-bordered table-striped table_small">
                    <thead>
                        <tr>
                            <th colspan="<?php echo (count($subjects) + 9); ?>" class="text-center">
                                <h1>Award List - Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>) - <?php echo $exam->term . " " . $exam->year ?></h1>
                            </th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Class No.</th>
                            <th>Admission No.</th>
                            <th>Student Name</th>
                            <?php foreach ($subjects as $subject): ?>
                                <th><?php echo substr($subject->short_title, 0, 7); ?></th>
                            <?php endforeach; ?>
                            <th>Total Marks</th>
                            <th>Marks Obtained</th>
                            <th>Percentage</th>
                            <th>55% Weightage</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td></td> <!-- Auto-numbered by DataTable -->
                                <td><?php echo $student->class_no; ?></td>
                                <td><?php echo $student->adminssion_no; ?></td>
                                <td><?php echo $student->student_name; ?> S/O <?php echo $student->father_name; ?></td>

                                <?php
                                $obtained_marked = 0;
                                $total_marked = 0;

                                foreach ($subjects as $subject):
                                    echo '<td style="text-align: center;">';
                                    $query = "SELECT obtain_mark, total_marks, passing_marks, `percentage` 
                                              FROM `students_exams_subjects_marks` 
                                              WHERE student_id = ? AND exam_id = ? AND subject_id = ?";
                                    $result = $this->db->query($query, [$student->student_id, $exam->exam_id, $subject->subject_id]);

                                    if ($result->num_rows() > 0) {
                                        $marks = $result->row();
                                        if ($marks->obtain_mark !== 'A') {
                                            echo $marks->percentage;
                                            $obtained_marked += $marks->percentage;
                                            $total_marked += 100;
                                        } else {
                                            echo 'A';
                                            $obtained_marked += $marks->percentage;
                                            $total_marked += 100;
                                        }
                                    }
                                    echo '</td>';
                                endforeach;
                                ?>

                                <td style="text-align: center;"><?php echo $total_marked; ?></td>
                                <td style="text-align: center;"><?php echo $obtained_marked; ?></td>
                                <td style="text-align: center;"><?php
                                                                $percentage = $total_marked > 0 ? round(($obtained_marked / $total_marked) * 100, 2) : 0;
                                                                echo $percentage; ?>%</td>
                                <th>
                                    <?php
                                    $current_semester_percentage_weightage = 55;
                                    $current_semester_percentage_weightage = $current_semester_percentage_weightage / 100;
                                    $current_semester_percentage = $percentage / 100;
                                    $current_semester_weightage = round(($current_semester_percentage_weightage * $current_semester_percentage) * 100, 2);
                                    echo $current_semester_weightage;
                                    ?>

                                </th>
                                <td style="text-align: center;"></td>

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row mt-5">
                <div class="col-md-6">
                    <strong>GCMHS Boys Chitral<br>Exam Committee</strong>
                </div>
                <div class="col-md-6 text-end" style="text-align: right;">
                    <strong>GCMHS Boys Chitral<br>Principal</strong>
                </div>
            </div>
        </section>
    </div>

    <!-- DataTable Initialization -->
    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                bPaginate: false,
                dom: 'Bfrtip',
                columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: 0
                }],
                /*order: [
                    [1, 'asc']
                ]*/
                order: []

            });

            // Auto-numbering first column
            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();

            // After initialization, get total columns and set order by second-last column
            var totalCols = table.columns().count();
            var percentageColIndex = totalCols - 2; // second-last column
            table.order([percentageColIndex, 'desc']).draw();
        });
    </script>
</body>
<style>
    .table_small>tbody>tr>td,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>td,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>thead>tr>th {
        padding: 2px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 9px;
        border: 0.1px solid gray !important;
        font-weight: bold !important;
        color: black !important;
    }
</style>

</html>