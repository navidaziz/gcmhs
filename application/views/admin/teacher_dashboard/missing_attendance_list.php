<?php
$year = date('Y');
$today = date('Y-m-d');

// Dates to ignore (format YYYY-MM-DD)
$ignore_dates = array(
    '2025-08-14',
    '2025-08-19',
    '2025-08-20',
    '2025-08-21',
    '2025-08-22',
    '2025-08-23',
    '2025-08-25',
    '2025-09-06',
    '2025-06-06',
    '2025-06-07',
    '2025-06-09',
    '2025-06-27',
    '2025-05-01',
    '2025-05-02',
    '2025-05-03',
    '2025-05-04',
    '2025-05-05',
    '2025-05-06',
    '2025-05-07',
    '2025-05-28'
);

// Load classes and sections
$sql = "
SELECT c.class_id, c.Class_title, s.section_id, s.section_title
FROM classes AS c
INNER JOIN class_sections AS cs ON cs.class_id = c.class_id
INNER JOIN sections AS s ON s.section_id = cs.section_id
WHERE s.status = 1 AND c.status = 1 AND c.class_id IN (" . $class_id . ")
AND s.section_id = " . $section_id . "
GROUP BY c.class_id, s.section_id
";

$classes = $this->db->query($sql)->result_array(); // PHP 4 compatible

for ($i = 0; $i < count($classes); $i++) {
    $class_id = $classes[$i]['class_id'];
    $section_id = $classes[$i]['section_id'];
    $class_title = $classes[$i]['Class_title'];
    $section_title = $classes[$i]['section_title'];

    // Get teacher name
    $sql_teacher = "
        SELECT teacher_name 
        FROM classes_time_tables 
        WHERE class_teacher = 1 
        AND class_id = '$class_id'
        AND section_id = '$section_id'
    ";
    $teacher_row = $this->db->query($sql_teacher)->row_array();
    $teacher_name = ($teacher_row) ? $teacher_row['teacher_name'] : "N/A";

    echo "<b>$class_title - $section_title - $teacher_name</b><br>";

    // Load all attendance for this class/section/year
    $sql_att = "
        SELECT DATE(`date`) AS att_date
        FROM students_attendance
        WHERE class_id = $class_id
        AND section_id = $section_id
        AND YEAR(`date`) = $year
    ";
    $att_rows = $this->db->query($sql_att)->result_array();

    // Create lookup array for attendance
    $attendance_map = array();
    for ($j = 0; $j < count($att_rows); $j++) {
        $attendance_map[$att_rows[$j]['att_date']] = true;
    }

    // Loop through months May (5) to December (12), skip July
    for ($month = 5; $month <= 12; $month++) {
        if ($month == 7) continue; // Skip July

        $missing_days = array();

        // Loop through days of the month
        for ($day = 1; $day <= 31; $day++) {
            if (!checkdate($month, $day, $year)) continue;

            $date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

            // Skip ignored dates
            if (in_array($date, $ignore_dates)) continue;

            // Stop at today
            if ($date > $today) break;

            // Skip Sundays
            $w = date('w', mktime(0, 0, 0, $month, $day, $year));
            if ($w == 0) continue;

            // Check if attendance exists
            if (!isset($attendance_map[$date])) {
                $missing_days[] = $day;
            }
        }

        $month_name = date('F', mktime(0, 0, 0, $month, 1, $year));

        if (count($missing_days) > 0) {
            echo $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . " ($month_name): " . implode(', ', $missing_days) . "<br>";

            echo '<ul class="list-group">';
            foreach ($missing_days as $md) {

                // Build proper date format
                $full_date = $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($md, 2, '0', STR_PAD_LEFT);

                // Build proper URL
                $url = site_url(ADMIN_DIR . "/$class_id/$section_id/$full_date");

                echo '<a href="' . $url . '"><li class="list-group-item">' . $full_date . '</li></a>';
            }
            echo '</ul>';
        } else {
            echo $year . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . " ($month_name): No Missing Days<br>";
        }
    }

    echo "<hr>";
}
