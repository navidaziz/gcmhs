<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">

<head>
    <meta charset="UTF-8">
    <title>Award List</title>

    <!-- jQuery -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

    <!-- Bootstrap -->
    <script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.css" />
    <script src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <style>
        body {
            font-size: 12px !important;
            font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
        }

        .dataTables_filter,
        .dataTables_info,
        .dt-button,
        .buttons-print {
            display: none;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
        }

        table th,
        table td {
            font-size: 12px;
        }
    </style>

    <script>
        document.title = "Award List Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>) <?php echo $exam->term . " " . $exam->year ?>";
    </script>
</head>

<body>

    <div class="row">
        <div class="col-md-12">
            <div class="container">
                <section>

                    <!-- Award List Table -->
                    <table id="example" class="table table-bordered" cellspacing="0">
                        <thead>
                            <tr>
                                <td colspan="<?php echo (count($subjects) + 7); ?>">
                                    <h1>
                                        Award List Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>)
                                        <?php echo $exam->term . " " . $exam->year; ?>
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>C/No</th>
                                <th>Add. #</th>
                                <th>Student Name</th>
                                <?php foreach ($subjects as $subject): ?>
                                    <th><?php echo substr($subject->short_title, 0, 7); ?></th>
                                <?php endforeach; ?>
                                <th>Obtain Marks</th>
                                <th>%</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($students as $student):
                                $obtained_marked = 0;
                                $total_marked = 0;
                            ?>
                                <tr>
                                    <td></td>
                                    <td><?php echo $student->class_no; ?></td>
                                    <td><?php echo $student->adminssion_no; ?></td>
                                    <td><?php echo $student->student_name; ?> S/O <?php echo $student->father_name; ?></td>
                                    <?php foreach ($subjects as $subject): ?>
                                        <td>
                                            <?php
                                            $query = "SELECT obtain_mark, total_marks, passing_marks, percentage 
                                                      FROM students_exams_subjects_marks 
                                                      WHERE student_id = ? AND exam_id = ? AND subject_id = ?";
                                            $result = $this->db->query($query, array(
                                                $student->student_id,
                                                $exam->exam_id,
                                                $subject->subject_id
                                            ));

                                            if ($result->num_rows() > 0) {
                                                $marks = $result->row();
                                                echo ($marks->obtain_mark === 'A') ? 'A' : $marks->percentage;
                                                $obtained_marked += $marks->percentage;
                                                $total_marked += 100;
                                            }
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td><?php echo $obtained_marked; ?></td>
                                    <td><?php echo $total_marked; ?></td>
                                    <td></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Footer Signature -->
                    <br><br><br>
                    <table style="width:100%; border: none;">
                        <tr>
                            <td style="border: none;">
                                <strong>GCMHS Boys Chitral <br>Exam Committee</strong>
                            </td>
                            <td style="text-align: right; border: none;">
                                <strong>GCMHS Boys Chitral <br>Principal</strong>
                            </td>
                        </tr>
                    </table>

                </section>
            </div>
        </div>
    </div>

    <!-- DataTables Initialization -->
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
                order: [
                    [1, 'asc']
                ]
            });

            table.on('order.dt search.dt', function() {
                table.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                    table.cell(cell).invalidate('dom');
                });
            }).draw();
        });
    </script>

</body>

</html>