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
}

// Get global counts
$global_counts = $this->db->query("
    SELECT 
        COUNT(CASE WHEN status IN(1,2) AND class_id IN (2,3,4,5,6) THEN 1 END) as total_students_all,
        COUNT(CASE WHEN status = 2 THEN 1 END) as total_struck_off_all
    FROM students
")->row();
?>

<?php
$evening_attendance = 0;
$query = "SELECT COUNT(*) as total FROM `students_attendance` WHERE 
            class_id = '" . $class_id . "' and section_id = '" . $section_id . "'
            AND attendance2 IS NOT NULL  
            AND date(created_date) = DATE(NOW())";
$today_evening_attendance = $this->db->query($query)->result()[0]->total;

if ($today_evening_attendance == 0 and date('N') != 7 and $evening) {
  $evening_attendance = 1;
}
$today_attendance = 0;
$query = "SELECT COUNT(*) as total FROM `students_attendance` 
            WHERE class_id = '" . $class_id . "' 
            and section_id = '" . $section_id . "' 
            AND date(created_date) = DATE(NOW())";
$today_attendance = $this->db->query($query)->result()[0]->total;
if ($today_attendance or date('N') == 7) {
  $today_attendance = 1;
}
if (date('N') == 7) {
  echo "<h4 style=\"color:red;\">Sunday ! School off.</h4>";
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
            <?php echo $this->lang->line('Home'); ?>
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
      <div class="box-title">
        <h4><i class="fa fa-book" aria-hidden="true"></i> <?php echo $title; ?></h4>
      </div>
      <div class="box-body">
        <div class="table-responsive">
          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Classes</th>
                    <th>Sections</th>
                    <th>Total</th>
                    <th>Struck Off</th>
                    <?php if ($today_attendance == 0) { ?>
                      <th style="text-align: center;">Y.day</th>
                      <th style="text-align: center;">P</th>
                      <!-- <th style="text-align: center;">CL</th> -->
                      <th style="text-align: center;">L</th>
                      <th style="text-align: center;">A</th>
                      <?php } else {
                      for ($i = 5; $i >= 0; $i--) {
                      ?>
                        <?php if ($i == 0) { ?>
                          <th style="text-align: center;">T.day</th>
                        <?php } else { ?>
                          <th style="text-align: center;"><?php echo date('d', strtotime("-$i days")); ?></th>
                        <?php } ?>

                      <?php } ?>

                    <?php } ?>
                    <?php if ($evening_attendance == 1  and $today_attendance == 1) { ?>
                      <th style="text-align: center;">E-P</th>
                      <th style="text-align: center;">E-L</th>
                      <th style="text-align: center;">E-A</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($classes as $class): ?>
                    <?php if (!empty($class->sections)): ?>
                      <?php foreach ($class->sections as $index => $section): ?>
                        <tr style="background-color: <?php echo $section->color; ?>;">

                          <td>
                            <?php echo $class->Class_title; ?>
                          </td>
                          <td>
                            <?php echo $section->section_title; ?>
                          </td>

                          <th style="text-align: center;">
                            <?php echo $section->active_students; ?>
                          </th>

                          <td style="text-align: center;">
                            <?php echo $section->struck_off_students; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                      <tr>
                        <td>Total: <?php echo $class->total_students; ?></td>
                      </tr>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>