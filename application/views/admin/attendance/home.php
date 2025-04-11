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

// Get global counts
$global_counts = $this->db->query("
    SELECT 
        COUNT(CASE WHEN status IN(1,2) AND class_id IN (2,3,4,5,6) THEN 1 END) as total_students_all,
        COUNT(CASE WHEN status = 2 THEN 1 END) as total_struck_off_all
    FROM students
")->row();
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
                    <th style="background-color: #7cb5ec;">Present</th>
                    <th style="background-color: #90ed7d;">On Leaved</th>
                    <th style="background-color: #f15c80;">Absent</th>
                    <th style="background-color: #f15c80;">Evening Absent</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($classes as $class): ?>
                    <?php if (!empty($class->sections)): ?>
                      <?php foreach ($class->sections as $index => $section): ?>
                        <tr>

                          <th style="background-color: <?php echo $section->color; ?>;">
                            <?php echo $class->Class_title; ?>
                          </th>
                          <th style="background-color: <?php echo $section->color; ?>;">
                            <?php echo $section->section_title; ?>
                          </th>

                          <th style="text-align: center;">
                            <?php echo $section->active_students; ?>
                          </th>

                          <td style="text-align: center;">
                            <?php echo $section->struck_off_students; ?>
                          </td>

                          <?php
                          $query = "SELECT * FROM `daily_class_wise_attendance` 
                                WHERE class_id='" . $class->class_id . "'
                                AND section_id='" . $section->section_id . "'
                                AND DATE(`date`) = DATE(Now());";
                          $section_to_day_attendance = $this->db->query($query)->row();
                          if ($section_to_day_attendance) { ?>
                            <td style="background-color: #7cb5ec;"><?php echo $section_to_day_attendance->present; ?></td>
                            <td style="background-color: #90ed7d;"><?php echo $section_to_day_attendance->leave; ?></td>
                            <td style="background-color: #f15c80;"><?php echo $section_to_day_attendance->absent; ?></td>
                            <td style="background-color: #f15c80;"><?php
                                                                    if ($section_to_day_attendance->ea == 'y') {
                                                                      echo $section_to_day_attendance->evening_absent;
                                                                    } else {
                                                                      echo '-';
                                                                    } ?></td>
                          <?php } else { ?>
                            <td style="background-color: #7cb5ec;">-</td>
                            <td style="background-color: #90ed7d;">-</td>
                            <td style="background-color: #f15c80;">-</td>
                            <td style="background-color: #f15c80;"><?php
                                                                    if ($section_to_day_attendance->ea == 'y') {
                                                                      echo $section_to_day_attendance->evening_absent;
                                                                    } else {
                                                                      echo '-';
                                                                    } ?></td>
                          <?php } ?>

                        </tr>
                      <?php endforeach; ?>
                      <tr>
                        <th style="text-align: center;" colspan="2">Total: </th>
                        <th style="text-align: center;"><?php echo $class->total_students; ?></th>
                        <th style="text-align: center;"><?php echo $class->struck_off_students; ?></th>
                        <?php
                        $query = "SELECT sum(`present`) as `present`,
                        sum(`leave`) as `leave`,
                        sum(`absent`) as `absent`,
                        sum(`evening_absent`) as evening_absent
                         FROM `daily_class_wise_attendance` 
                                WHERE class_id='" . $class->class_id . "'
                                AND DATE(`date`) = DATE(Now());";
                        $section_to_day_attendance = $this->db->query($query)->row();
                        if ($section_to_day_attendance) { ?>
                          <th style="text-align: center; background-color: #7cb5ec;"><?php echo $section_to_day_attendance->present; ?></th>
                          <th style="text-align: center; background-color: #90ed7d;"><?php echo $section_to_day_attendance->leave; ?></th>
                          <th style="text-align: center; background-color: #f15c80;"><?php echo $section_to_day_attendance->absent; ?></th>
                          <th style="text-align: center; background-color: #f15c80;"><?php echo $section_to_day_attendance->evening_absent;  ?></th>
                        <?php } ?>

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