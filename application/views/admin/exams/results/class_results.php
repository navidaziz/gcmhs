<!-- PAGE HEADER-->
<!DOCTYPE html>
<html lang="en" dir="<?php echo $this->lang->line('direction'); ?>">
<!-- JQUERY -->
<script src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery/jquery-2.0.3.min.js"); ?>"></script>

<!-- BOOTSTRAP -->
<script src="<?php echo site_url("assets/" . ADMIN_DIR . "bootstrap-dist/js/bootstrap.min.js"); ?>"></script>

<head>
</head>

<body>

    <!-- /PAGE HEADER -->

    <!-- PAGE MAIN CONTENT -->
    <div class="row" style='font-size:12px !important; font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif; '>
        <!-- MESSENGER -->
        <div class="col-md-12">
            <div class="container">

                <section>


                    <script>
                        document.title = "Award List Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>)   <?php echo $exam->term . " " . $exam->year  ?>";
                    </script>



                    <table id="example" class="table table-border" cellspacing="0" width="100%" style="font-size:12 !important">

                        <thead>
                            <tr>
                                <td colspan="<?php echo (count($subjects) + 7) ?>">
                                    <h1 style="text-align:center;">
                                        Award List Class <?php echo $class->Class_title; ?> (<?php echo $section->section_title; ?>) <?php echo $exam->term . " " . $exam->year  ?>
                                    </h1>
                                </td>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>C/No</th>
                                <th>Add. #</th>
                                <th>Student Name</th>
                                <?php
                                foreach ($subjects as $subject) { ?>
                                    <th><?php echo substr($subject->short_title, 0, 7); ?></th>
                                <?php } ?>
                                <th>Obtain Marks</th>
                                <th>%</th>
                                <td>Remarks</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            foreach ($students as $student) { ?>
                                <tr>
                                    <td><?php //echo $count++; 
                                        ?></td>
                                    <td><?php echo $student->class_no; ?></td>
                                    <td><?php echo $student->adminssion_no; ?></td>
                                    <td><?php echo $student->student_name; ?> S/O <?php echo $student->father_name; ?></td>
                                    <?php
                                    $grant_total = 0;
                                    foreach ($subjects as $subject) { ?>
                                        <td>
                                            <?php
                                            $query = "SELECT obtain_make, total_marks, passing_marks, `percentage`
                                            FROM `students_exams_subjects_marks` as se
                                            WHERE student_id = ?
                                            AND exam_id = ?
                                            AND subject_id = ?";
                                            $query = $this->db->query($query, array($student->id, $exam->id, $subject->id));
                                            if ($query->num_rows() > 0) {
                                                $marks = $query->row();
                                                echo $marks->percentage;
                                                $grant_total += $marks->percentage;
                                            }
                                            ?>
                                        </td>

                                    <?php } ?>
                                    <td></td>
                                    <td></td>
                                    <td> </td>
                                </tr>
                            <?php } ?>




                        </tbody>

                    </table>
                    <br />

                    <div style="clear:both"></div>
                    <br />
                    <br />
                    <br />
                    <table width="100%" style="border:0px !important">
                        <tr>
                            <td style="border:0px !important">
                                <strong>GCMHS Boys Chitral <br />Exam Committee</strong>
                            </td>
                            <td style="text-align:right; border:0px !important"><strong style="margin:5px"> GCMHS Boys Chitral <br />Principal</strong></td>
                        </tr>
                    </table>
                </section>
            </div>

        </div>
    </div>
    </div>



    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                "bPaginate": false,
                dom: 'Bfrtip',
                /* buttons: [
                     'print'
                     
                     
                 ],*/

                "columnDefs": [{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                }],
                "order": [
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
    <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo site_url("assets/" . ADMIN_DIR); ?>/datatable/jquery.data Tables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <!-- /MESSENGER -->

    <style>
        .dataTables_filter,
        .dataTables_info {
            display: none;
        }

        .dt-button,
        .buttons-print {
            display: none;
        }
    </style>
    </div>
</body>

</html>