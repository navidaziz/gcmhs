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

            <!-- Search bar -->
            <input type="text" id="searchBox" class="form-control" placeholder="🔍 Search student..." style="margin-bottom:10px;">

            <!-- Sort select -->
            <select id="sortSelect" class="form-control" style="margin-bottom:10px;">
                <option value="asc">Sort by C.No ↑</option>
                <option value="desc">Sort by C.No ↓</option>
                <option value="name">Sort by Name</option>
            </select>

            <!-- Student List -->
            <div id="studentList" class="list-group">
                <?php
                $count = 1;
                $query = $this->db->query("SELECT * FROM students WHERE status IN (1,2)
                        AND class_id = ? and section_id = ? ORDER BY student_class_no ASC ", array($class_id, $section_id));
                $students = $query->result();

                foreach ($students as $student): ?>
                    <div class="list-group-item student-item"
                        data-no="<?php echo $student->student_class_no; ?>"
                        data-name="<?php echo strtolower($student->student_name); ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>C.No: <?php echo $student->student_class_no; ?></strong><br>
                                <?php echo $student->student_name . " <br><small>s/o " . $student->student_father_name . "</small>"; ?>
                            </div>
                            <button class="btn btn-success btn-sm">
                                <i class="fa fa-info-circle"></i>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- JS for Search & Sort -->
<script>
    const searchBox = document.getElementById('searchBox');
    const sortSelect = document.getElementById('sortSelect');
    const studentList = document.getElementById('studentList');

    // Search filter
    searchBox.addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.student-item').forEach(item => {
            const name = item.getAttribute('data-name');
            const no = item.getAttribute('data-no');
            if (name.includes(query) || no.includes(query)) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        });
    });

    // Sort function
    sortSelect.addEventListener('change', function() {
        let items = Array.from(document.querySelectorAll('.student-item'));
        let sorted;

        if (this.value === 'asc') {
            sorted = items.sort((a, b) => a.dataset.no - b.dataset.no);
        } else if (this.value === 'desc') {
            sorted = items.sort((a, b) => b.dataset.no - a.dataset.no);
        } else if (this.value === 'name') {
            sorted = items.sort((a, b) => a.dataset.name.localeCompare(b.dataset.name));
        }

        studentList.innerHTML = "";
        sorted.forEach(el => studentList.appendChild(el));
    });
</script>

<style>
    /* Mobile-friendly card style */
    .student-item {
        border-radius: 10px;
        margin-bottom: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .student-item strong {
        font-size: 16px;
        color: #007bff;
    }

    .student-item small {
        color: #666;
    }
</style>


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