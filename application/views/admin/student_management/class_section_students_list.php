<style>
    .table_small>thead>tr>th,
    .table_small>tbody>tr>th,
    .table_small>tfoot>tr>th,
    .table_small>thead>tr>td,
    .table_small>tbody>tr>td,
    .table_small>tfoot>tr>td {
        padding: 4px;
        line-height: 1;
        vertical-align: top;
        border-top: 1px solid #ddd;
        font-size: 12px !important;
        color: black;
        margin: 0px !important;
    }
</style>

<?php
// Single optimized query to fetch all required data
$query = "
    SELECT 
        c.class_id,
        c.Class_title,
        sec.section_id,
        sec.section_title,
        sec.color,
        COUNT(CASE WHEN st.status = 1 THEN 1 END) as active_students,
        COUNT(CASE WHEN st.status = 2 THEN 1 END) as struck_off_students,
        COUNT(CASE WHEN st.status IN (1,2) THEN 1 END) as total_students
    FROM 
        classes c
    LEFT JOIN 
        students st ON st.class_id = c.class_id
    LEFT JOIN 
        sections sec ON sec.section_id = st.section_id AND st.status IN (1,2)
    WHERE 
        c.status = 1
    GROUP BY 
        c.class_id, sec.section_id
    ORDER BY 
        c.class_id DESC, sec.section_id ASC
";

$result = $this->db->query($query);
$data = $result->result();

// Organize data by class
$classes = [];
foreach ($data as $row) {
    if (!isset($classes[$row->class_id])) {
        $classes[$row->class_id] = (object)[
            'class_id' => $row->class_id,
            'Class_title' => $row->Class_title,
            'total_students' => 0,
            'struck_off_students' => 0,
            'sections' => []
        ];
    }

    if ($row->section_id) {
        $classes[$row->class_id]->sections[] = (object)[
            'section_id' => $row->section_id,
            'section_title' => $row->section_title,
            'color' => $row->color,
            'active_students' => $row->active_students,
            'struck_off_students' => $row->struck_off_students
        ];
    }

    $classes[$row->class_id]->total_students += $row->total_students;
    $classes[$row->class_id]->struck_off_students += $row->struck_off_students;
}

?>

<!-- PAGE HEADER-->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header" style="min-height: 30px;">
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>">
                        Home
                    </a>
                </li>
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . "student_management"); ?>">
                        Dashboard
                    </a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>
        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <div class="box border blue" id="messenger" style="padding: 5px;">
            <h4><?php echo $title; ?></h4>
            <hr />
            <table id="example" class="table table-bordered table-striped table_small ">

                <thead>
                    <tr>
                        <th>#</th>
                        <!-- <th>Student ID</th> -->
                        <th>C.No:</th>
                        <!-- <th>Addmission No</th> -->
                        <th style="width: 50%;">Student Info</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $count = 1;
                    $query = $this->db->query("SELECT * FROM students WHERE status IN (1,2)
                            AND class_id = ? and section_id = ? ORDER BY student_class_no ASC ", array($class_id, $section_id));
                    $students = $query->result();

                    foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <!-- <td><?php echo $student->student_id; ?></td> -->
                            <td><strong><?php echo $student->student_class_no; ?></strong></td>
                            <!-- <td><?php echo $student->student_admission_no; ?></td> -->
                            <td><?php echo $student->student_name . " s/o " . $student->student_father_name; ?></td>
                            <td>
                                <button class="btn btn-success"><i class="fa fa-info-circle" aria-hidden="true"></i> Update</button>
                            </td>
                        </tr>

                    <?php endforeach; ?>



                </tbody>

            </table>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        document.title = "<?php echo $title; ?>";
        var table = $('#example').DataTable({
            "bPaginate": false,
            dom: 'Bfrtip',
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ]
        });

    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>