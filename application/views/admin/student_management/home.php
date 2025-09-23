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
        <li><?php echo $title; ?></li>
      </ul>
    </div>
  </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <div class="col-md-12">
    <div class="box border blue" id="messenger">

      <div class="box-body">
        <div class="table-responsive">

          <?php foreach ($classes as $class): ?>
            <h4 class="text-primary"><strong>Class: <?php echo $class->Class_title; ?></strong></h4>

            <?php if (!empty($class->sections)): ?>
              <?php foreach ($class->sections as $section): ?>
                <div class="panel panel-default">
                  <div class="panel-body" style="background-color: <?php echo $section->color; ?>;">
                    <strong><?php echo $section->section_title; ?></strong>
                    <a class="btn btn-success btn-xs pull-right"
                      href="<?php echo site_url(ADMIN_DIR . "student_management/view_student_list/" . $class->class_id . "/" . $section->section_id) ?>">
                      View Students
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          <?php endforeach; ?>

        </div>
      </div>
    </div>
  </div>
</div>