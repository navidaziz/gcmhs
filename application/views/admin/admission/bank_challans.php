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
        <button onclick="add_bank_challan()" class="btn btn-success btn-sm pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Create Bank Challan</button>

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
      <table class="table table-bordered table_small" id="main_table">
        <thead>

          <td>#</td>
          <td>RECEIPT ID</td>
          <td>STUDENT ID</td>
          <td>STUDENT NAME</td>
          <td>FATHER NAME</td>
          <td>ADMISSION NO</td>
          <td>CLASS</td>
          <td>SECTION</td>
          <td>SESSION</td>
          <td>AMOUNT (RS.)</td>
          <td>Date</td>
          <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT * FROM bank_challans";
          $bank_challans = $this->db->query($query)->result();
          $count = 1;
          foreach ($bank_challans as $bank_challans => $bank_challan) { ?>
            <tr>
              <td><?php echo $count++; ?></td>
              <td><?php echo $bank_challan->receipt_id; ?></td>
              <td><?php echo $bank_challan->student_id; ?></td>
              <td><?php echo $bank_challan->student_name; ?></td>
              <td><?php echo $bank_challan->father_name; ?></td>
              <td><?php echo $bank_challan->admission_no; ?></td>
              <td><?php echo $bank_challan->class; ?></td>
              <td><?php echo $bank_challan->section; ?></td>
              <td><?php echo $bank_challan->session; ?></td>
              <td><?php echo $bank_challan->total_amount; ?></td>
              <td><?php echo date("d-m-Y", strtotime($bank_challan->created_date)); ?></td>
              <td><a target="_blank" href="<?php echo site_url(ADMIN_DIR . "/admission/print_bank_challan/" . $bank_challan->receipt_id); ?>">Print</a></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <div id="general_model" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="general_model_body">
        <div class="modal-header">

          <h5 class="modal-title pull-left" id="">Create Bank Challan</h5>
          <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <br />
        </div>
        <div class="modal-body">
          <form action="<?php echo site_url(ADMIN_DIR . "admission/add_bank_challan") ?>" method="post">
            <!-- Table Headers -->
            <div class="form-row">
              <table class="table">
                <tr>
                  <td colspan="2">
                    <table style="width: 100%;">
                      <tr>
                        <th>CLASS</th>
                        <th>SECTION</th>
                        <th>SESSION</th>
                      </tr>
                      <tr>
                        <th><input name="class" type="text" class="form-control" id="class" placeholder="Enter Class"></th>
                        <th> <input name="section" type="text" class="form-control" id="section" placeholder="Enter Section">
                        </th>
                        <th><input name="session" type="text" class="form-control" id="session" placeholder="Enter Session">
                        </th>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <th>ADMISSION NO</th>
                  <td> <input name="admission_no" type="text" class="form-control" id="admissionNo" placeholder="Enter Admission No">
                  </td>
                </tr>
                <tr>
                  <th>STUDENT ID</th>
                  <td> <input name="student_id" type="text" class="form-control" id="studentId" placeholder="Enter Student ID">
                  </td>
                </tr>

                <tr>
                  <th>STUDENT NAME</th>
                  <td>
                    <input name="student_name" type="text" class="form-control" id="studentName" placeholder="Enter Student Name">

                  </td>
                </tr>
                <tr>
                  <th>FATHER NAME</th>
                  <td>
                    <input name="father_name" type="text" class="form-control" id="fatherName" placeholder="Enter Father Name">

                  </td>
                </tr>

              </table>
              <h5>Challan Detail</h5>
              <table class="table">
                <tr>
                  <th>Heads</th>
                  <th>Amount</th>
                </tr>
                <?php $query = "SELECT * FROM `bank_challan_heads` 
                            WHERE status=1
                            ORDER BY `bank_challan_heads`.`order` ASC";
                $heads = $this->db->query($query)->result();
                foreach ($heads as $head) {
                ?>
                  <tr>
                    <th><strong><?php echo $head->head; ?></strong></th>
                    <td>
                      <input onkeyup="sum_head_amount()" required name="heads[<?php echo $head->head_id; ?>]" type="number" class="form-control head_amount" id="session" placeholder="Amount" value="0">
                    </td>
                  </tr>
                <?php } ?>
                <tr>
                  <th colspan="2" style="text-align: right;">
                    Grand Total: <strong style="margin-left: 10px;"><span id="grand_total">0.00</span> Rs.</strong>
                    <input type="hidden" name="total_amount" id="total_amount" value="0" />
                  </th>
                </tr>
              </table>
            </div>
            <div style="text-align: center;">
              <button type="submit" class="btn btn-primary">Add Bank Challan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    function sum_head_amount() {
      // Select all elements with the class "head_amount"
      var inputs = document.getElementsByClassName("head_amount");

      // Initialize sum variable
      var sum = 0;

      // Loop through each input and add its value to the sum
      for (var i = 0; i < inputs.length; i++) {
        sum += parseFloat(inputs[i].value) || 0;
      }

      ;
      // Display the sum in the "grandTotal" span
      document.getElementById("grand_total").innerText = sum.toFixed(2);
      $('#total_amount').val(sum);
    }

    function add_bank_challan(student_id) {
      // $.ajax({
      //   type: "POST",
      //   url: "<?php echo site_url(ADMIN_DIR . "admission/get_student_update_form"); ?>",
      //   data: {
      //     student_id: student_id
      //   }
      // }).done(function(data) {

      //   $('#general_model_body').html(data);
      // });

      // $('#general_model').modal('show');
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