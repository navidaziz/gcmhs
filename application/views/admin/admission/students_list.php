<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>

<div class="row">
  <div class="col-sm-12">
    <div class="page-header">
      <!-- STYLER -->

      <!-- /STYLER -->
      <!-- BREADCRUMBS -->
      <ul class="breadcrumb">
        <li> <i class="fa fa-home"></i> Home </li>
        <li> <a href="<?php echo site_url(ADMIN_DIR . "admission/"); ?>"> Admission</a> </li>
        <?php if ($title != 'All Students list') { ?>
          <li><?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?></li>
        <?php } else { ?>
          <li><?php echo $title; ?></li>
        <?php } ?>
      </ul>
      <!-- /BREADCRUMBS -->
      <div class="col-md-6">
        <?php if ($title != 'All Students list') { ?>
          <h3 class="content-title pull-left"> <?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?></h3>
        <?php } else { ?>
          <h3 class="content-title pull-left"><?php echo $title; ?></h3>
        <?php } ?>
        <div class="description" id="message"></div>
      </div>
      <div class="col-md-6">
        <script>
          function add_new_student(student_id) {
            $.ajax({
              type: "POST",
              url: "<?php echo site_url(ADMIN_DIR . "admission/get_student_add_form"); ?>",
              data: {
                class_id: <?php echo $class_id; ?>,
                section_id: <?php echo $section_id; ?>
              }
            }).done(function(data) {

              $('#general_model_body').html(data);
            });

            $('#general_model').modal('show');
          }
        </script>
        <button onclick="add_new_student()" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Add New Student In Class <?php echo $students[0]->Class_title . ""; ?>, Section <?php echo $students[0]->section_title . ""; ?></button>

      </div>

    </div>
  </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-12" style="background-color: white; padding: 5px; ">
    <div class="table-responsive" style="overflow-x: auto;">
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
        }
      </style>
      <table class="table table-bordered table_small" id="main_table" style="font-size: 9px;">
        <thead>

          <td>#</td>
          <td>CN</td>
          <td>AddNo</td>
          <td>Student Name</td>

          <td>Father Name</td>
          <td>DOB</td>
          <td>Form B</td>
          <td>Add. Date</td>
          <td>Address</td>
          <td>Mobile No</td>
          <td>Father NIC</td>
          <td>Issue Date</td>
          <td>Occupation</td>
          <td>Status</td>
          <td>Religion</td>
          <td>Nationality</td>
          <td>P/ G </td>
          <td style="width: 30px;">School</td>
          <td>Orphan</td>
          <td>Vacc</td>
          <td>Disa</td>
          <td>Ehsaas</td>
          <td>Class</td>
          <td>Section</td>
          <td>Session</td>
          <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <?php
          $students = array();
          $all_sections = $sections;
          foreach ($sections as $section_name => $students) {
            $count = 1;
            foreach ($students as $student) :
          ?>
              <tr>

                <td id="count_number"><?php echo $count++; ?></td>
                <td> <span id="class_number"><?php echo $student->student_class_no;  ?></span> </td>
                <td><span><?php echo $student->student_admission_no; ?></span></td>
                <td><span><?php echo $student->student_name;  ?></span></td>
                <td><?php echo $student->student_father_name;  ?></td>
                <td><?php echo date('d-m-Y', strtotime($student->student_data_of_birth)); ?> </td>
                <td><?php echo $student->form_b; ?> </td>
                <td><?php echo date('d-m-Y', strtotime($student->admission_date)); ?></td>
                <td><?php echo $student->student_address; ?></td>
                <td><?php echo $student->father_mobile_number; ?></td>
                <td><?php echo $student->father_nic; ?></td>
                <td><?php echo $student->nic_issue_date; ?></td>
                <td><?php echo $student->guardian_occupation; ?></td>
                <td><?php
                    if ($student->status == 2) {
                      echo "Struck Off";
                    }
                    ?></td>
                <td><?php echo $student->religion; ?></td>
                <td><?php echo $student->nationality; ?></td>

                <td><?php echo $student->private_public_school; ?></td>
                <td><?php echo $student->school_name; ?></td>
                <td><?php echo $student->orphan; ?></td>
                <td><?php echo $student->vaccinated; ?></td>
                <td><?php echo $student->is_disable; ?></td>
                <td><?php echo $student->ehsaas; ?></td>
                <td><?php echo $student->Class_title; ?></td>
                <td><?php echo $student->section_title; ?></td>
                <td><?php $query = "SELECT `session` FROM sessions WHERE session_id = '" . $student->session_id . "'";
                    echo $this->db->query($query)->result()[0]->session;
                    ?></td>
                <td style="text-align: center; width:48px">
                  <button onclick="update_profile('<?php echo $student->student_id ?>')" class="btn btn-link btn-sm" style="padding: 0px; margin:0px; font-size:9px">Edit</button>
                  - <a class="btn btn-link btn-sm" target="new" style="padding: 0px; margin:0px; font-size:9px" href="<?php echo site_url(ADMIN_DIR . "admission/view_student_profile/" . $student->student_id) ?>">View</button>

                </td>


              </tr>
            <?php endforeach;  ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div id="general_model" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="general_model_body">


      </div>
    </div>
  </div>
  <script>
    function update_profile(student_id) {
      $.ajax({
        type: "POST",
        url: "<?php echo site_url(ADMIN_DIR . "admission/get_student_update_form"); ?>",
        data: {
          student_id: student_id
        }
      }).done(function(data) {

        $('#general_model_body').html(data);
      });

      $('#general_model').modal('show');
    }
    $(document).ready(function() {
      <?php if ($title != 'All Students list') { ?>

        document.title = "<?php echo $students[0]->Class_title . ""; ?> <?php echo $students[0]->section_title . ""; ?> <?php echo $title; ?>";
      <?php } else { ?>
        document.title = "<?php echo $title; ?>";
      <?php } ?>
      var table = $('#main_table').DataTable({
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


</div>
<!-- /MESSENGER -->
</div>