<!-- PAGE HEADER -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Ensure jQuery is included -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">...</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-users"></i> Current Teachers List</h4>
            </div>
            <div class="box-body">

                <script>
                    function get_teacher_form(teacher_id) {
                        $.ajax({
                            method: "POST",
                            url: "<?php echo site_url(ADMIN_DIR . 'teachers/get_teacher_form'); ?>",
                            data: {
                                teacher_id: teacher_id
                            },
                            success: function(response) {
                                $('#modal').modal('show');
                                $('#modal_title').text('Teachers');
                                $('#modal_body').html(response);
                            }
                        });
                    }
                </script>

                <style>
                    .table_small th,
                    .table_small td {
                        padding: 4px;
                        font-size: 10px !important;
                        color: black;
                    }
                </style>

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table_small">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Teacher Name</th>
                                <th>Father Name</th>
                                <th>Gender</th>
                                <th>Date Of Birth</th>
                                <th>Teacher Designation</th>
                                <th>CNIC</th>
                                <th>Mobile Number</th>
                                <th>Academic Qualification</th>
                                <th>Professional Qualification</th>
                                <th>Initial Appointment Date</th>
                                <th>Current School Assumption Date</th>
                                <th>Current Post Assumption Date</th>
                                <th>Personal No</th>
                                <th>Basic Pay Scale</th>
                                <th>Current Pay</th>
                                <th>GP Fund Number</th>
                                <th>Bank Branch</th>
                                <th>Bank Branch Code</th>
                                <th>Bank Account No</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <script>
                    $(document).ready(function() {
                        document.title = "Teachers List (Date: <?php echo date('d-m-Y H:i:s'); ?>)";

                        var table = $("#datatable").DataTable({
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": "<?php echo base_url(ADMIN_DIR . 'teachers/teachers_list'); ?>",
                                "type": "POST",
                                "data": function(d) {
                                    d.status = 1;
                                }
                            },
                            "columns": [{
                                    "data": null,
                                    "render": function(data, type, row, meta) {
                                        return meta.row + 1;
                                    }
                                },
                                {
                                    "data": "teacher_name"
                                },
                                {
                                    "data": "father_name"
                                },
                                {
                                    "data": "gender"
                                },
                                {
                                    "data": "date_of_birth"
                                },
                                {
                                    "data": "teacher_designation"
                                },
                                {
                                    "data": "cnic"
                                },
                                {
                                    "data": "mobile_number"
                                },
                                {
                                    "data": "academic_qualification"
                                },
                                {
                                    "data": "professional_qualification"
                                },
                                {
                                    "data": "initial_appointment_date"
                                },
                                {
                                    "data": "current_school_assumption_date"
                                },
                                {
                                    "data": "current_post_assumption_date"
                                },
                                {
                                    "data": "personal_no"
                                },
                                {
                                    "data": "basic_pay_scale"
                                },
                                {
                                    "data": "current_pay"
                                },
                                {
                                    "data": "gp_fund_number"
                                },
                                {
                                    "data": "bank_branch"
                                },
                                {
                                    "data": "bank_branch_code"
                                },
                                {
                                    "data": "bank_account_no"
                                },
                                {
                                    "data": "email"
                                },
                                {
                                    "data": "address"
                                },
                                {
                                    "data": "user_name"
                                },
                                {
                                    "data": "password"
                                },
                                {
                                    "data": null,
                                    "render": function(data, type, row) {
                                        return '<a class="btn btn-sm btn-primary" onclick="get_teacher_form(' + row.teacher_id + ')"><i class="fa fa-edit"></i> Edit</a>';
                                    }
                                }
                            ],
                            "lengthMenu": [
                                [200, 300, 500, -1],
                                [200, 300, 500, "All"]
                            ],
                            "order": [
                                [0, "asc"]
                            ],
                            "searching": true,
                            "paging": true,
                            "info": true,
                            "dom": "Bfrtip",
                            "buttons": ["excel", "pageLength"]
                        });

                        $("#reloadTeachers").click(function() {
                            table.ajax.reload(null, false);
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>