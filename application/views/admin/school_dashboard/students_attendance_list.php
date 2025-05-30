<style>
  .image-tooltip {
    position: relative;
    display: inline-block;
  }

  .image-tooltip .tooltip {
    visibility: hidden;
    width: 150px;
    position: absolute;
    z-index: 100;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
  }

  .image-tooltip:hover .tooltip {
    visibility: visible;
    opacity: 1;
  }

  .image-tooltip .tooltip img {
    border: 2px solid #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    border-radius: 5px;
  }

  .table_small {
    border-collapse: collapse;
    width: 100%;
  }

  .table_small th,
  .table_small td {
    padding: 5px;
    line-height: 1.2;
    font-size: 11px;
    vertical-align: middle;
    text-align: center;
    border: 1px solid #ccc !important;
    color: #000;
  }

  .table_small thead {
    background-color: #f8f9fa;
    font-weight: bold;
  }

  .present {
    background-color: #28a745 !important;
    color: white;
    border: 1px solid #1e7e34 !important;
  }

  .leave {
    background-color: rgb(157, 248, 178) !important;
    color: white;
    border: 1px solid rgb(157, 248, 178) !important;

  }

  .strock_off {
    background-color: rgb(243, 132, 143) !important;
    color: white;
    border: 1px solid rgb(243, 132, 143) !important;
  }

  .absent {
    background-color: #dc3545 !important;
    color: white;
    border: 1px solid #bd2130 !important;
  }

  .evening-absent {
    background-color: #fd7e14 !important;
    color: white;
    border: 1px solid #e8590c !important;
  }

  .sunday {
    background-color: #d6d8db !important;
    color: #6c757d;
  }
</style>

<?php
// Generate date headers
$date_headers = [];
for ($i = 7; $i >= 0; $i--) {
  $date = new DateTime();
  $date->modify("-$i days");
  $formatted_date = $date->format('d, F');
  $day_of_week = $date->format('l');
  $date_headers[] = [
    'date' => $formatted_date,
    'day' => $day_of_week,
    'is_sunday' => $date->format('w') == 0,
    'formatted' => $date->format('Y-m-d')
  ];
}
?>
<h4>Last 7 Days Student Attendance Analysis Dashboard</h4>
<hr />
<table id="attendance_table" class="table table-bordered table_small" style="width:100%;">
  <thead>
    <!-- First Header Row: Dates -->
    <tr>
      <th rowspan="3">#</th>
      <th rowspan="3">STUDENT ID</th>
      <th rowspan="3">CLASS NO.</th>
      <th rowspan="3">STUDENT</th>
      <th rowspan="3">ADMISSION NO.</th>
      <th rowspan="3">CONTACT</th>
      <th rowspan="3">IMAGE</th>
      <th rowspan="3">STATUS</th>
      <th rowspan="3">CLASS</th>
      <th rowspan="3">SECTION</th>
      <?php foreach ($date_headers as $header): ?>
        <th colspan="2"><?php echo $header['date']; ?></th>
      <?php endforeach; ?>
      <th rowspan="3">MP</th>
      <th rowspan="3">MA</th>
      <th rowspan="3">ML</th>
      <th rowspan="3">EA</th>
    </tr>
    <!-- Second Header Row: Day of Week -->
    <tr>
      <?php foreach ($date_headers as $header): ?>
        <th colspan="2"><?php echo $header['day']; ?></th>
      <?php endforeach; ?>
    </tr>
    <!-- Third Header Row: M and E -->
    <tr>
      <?php foreach ($date_headers as $header): ?>
        <th>M</th>
        <th>E</th>
      <?php endforeach; ?>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = "SELECT * FROM `students_attendance_list` WHERE `students_attendance_list`.`status` IN(1,2)";
    $students_attendance = $this->db->query($query)->result();
    $count = 1;
    foreach ($students_attendance as $sa):
    ?>
      <tr>
        <td><?php echo $count++; ?></td>
        <td><?php echo $sa->student_id; ?></td>
        <td><?php echo $sa->class_no; ?></td>
        <td><?php echo $sa->name; ?> S/O <?php echo $sa->father_name; ?></td>
        <td><?php echo $sa->admission_no; ?></td>
        <td><?php echo $sa->contact_no; ?></td>
        <td>
          <?php if ($sa->image): ?>
            <span class="image-tooltip">
              <img src="<?php echo site_url('uploads/gcmhs/' . $sa->image); ?>" width="30" height="30" />
              <span class="tooltip">
                <img src="<?php echo site_url('uploads/gcmhs/' . $sa->image); ?>" width="150" />
              </span>
            </span>
          <?php endif; ?>
        </td>
        <td>
          <?php
          switch ($sa->status) {
            case 1:
              echo "Admit";
              break;
            case 2:
              echo "Struck Off";
              break;
            case 3:
              echo "SLC";
              break;
            case 0:
              echo "Deleted";
              break;
          }
          ?>
        </td>
        <td><?php echo $sa->class_title; ?></td>
        <td><strong><?php echo $sa->section_title; ?></strong></td>
        <?php foreach ($date_headers as $header): ?>
          <?php
          $attendance_query = "SELECT * FROM `students_attendance` WHERE `student_id` = ? AND DATE(`date`) = ?";
          $attendance_data = $this->db->query($attendance_query, [$sa->student_id, $header['formatted']])->row();
          ?>
          <!-- Morning Attendance -->
          <td class="<?php
                      if ($header['is_sunday']) {
                        echo 'sunday';
                      } elseif (isset($attendance_data->attendance)) {
                        if ($attendance_data->attendance == 'P') {
                          echo 'present';
                        };
                        if ($attendance_data->attendance == 'L') {
                          echo 'leave';
                        };
                        if ($attendance_data->attendance == 'A') {
                          echo 'absent';
                        };
                        if ($attendance_data->attendance == 'SO') {
                          echo 'strock_off';
                        };
                      }
                      ?>">
            <?php
            echo isset($attendance_data->attendance) ? $attendance_data->attendance : '';
            ?>
          </td>
          <!-- Evening Attendance -->
          <td class="<?php
                      if ($header['is_sunday']) {
                        echo 'sunday';
                      } elseif ($attendance_data->attendance == 'P') {
                        if (isset($attendance_data->attendance2)) {
                          if ($attendance_data->attendance2 == 'P') {
                            echo 'present';
                          }
                          if ($attendance_data->attendance2 == 'A') {
                            echo 'evening-absent';
                          }
                          if ($attendance_data->attendance2 == 'L') {
                            echo 'leave';
                          }
                          if ($attendance_data->attendance2 == 'SO') {
                            echo 'strock_off';
                          }
                        } else {
                          echo 'sunday';
                        }
                      } else {
                        if ($attendance_data->attendance == 'L') {
                          echo 'leave';
                        };
                        if ($attendance_data->attendance == 'A') {
                          echo 'absent';
                        };
                        if ($attendance_data->attendance == 'SO') {
                          echo 'strock_off';
                        };
                      }

                      ?>">
            <?php
            if ($attendance_data->attendance != 'P') {
              if ($attendance_data->attendance == 'A') {
                echo 'MA';
              } else {
                echo $attendance_data->attendance;
              }
            } else {
              if (isset($attendance_data->attendance2)) {
                if ($attendance_data->attendance2 == 'A') {
                  echo 'EA';
                } else {
                  echo $attendance_data->attendance2;
                }
              } else {
                echo 'M';
              }
            }
            ?>
          </td>
        <?php endforeach; ?>
        <td><?php echo $sa->m_p; ?></td>
        <td><?php echo $sa->m_a; ?></td>
        <td><?php echo $sa->m_l; ?></td>
        <td><?php echo $sa->e_a; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>


<script>
  $(document).ready(function() {
    var table = $('#attendance_table').DataTable({
      bPaginate: false,
      dom: 'Bfrtip',
      searching: true,
      buttons: [{
          extend: 'excel',
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdfHtml5',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            columns: ':visible'
          },
          customize: function(doc) {
            doc.styles.tableHeader.alignment = 'center';
            doc.styles.tableBodyEven.alignment = 'center';
            doc.styles.tableBodyOdd.alignment = 'center';
            doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
          }
        }
      ],
      columnDefs: [{
        searchable: false,
        orderable: false,
        targets: 0
      }],
      order: []
    });

    // Auto-indexing Serial No. column
    function updateSerialNumbers() {
      table.column(0, {
        search: 'applied',
        order: 'applied'
      }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1;
      });
    }

    // Trigger indexing on these events
    table.on('order.dt search.dt draw.dt', function() {
      updateSerialNumbers();
    });

    // Initial draw
    updateSerialNumbers();
  });
</script>