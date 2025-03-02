<!-- PAGE HEADER-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
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
                <h4 class="modal-title" id="modal_title" style="display: inline;"></h4>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal_body">
                ...
            </div>
            <div class="modal-footer" style="text-align: center;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <!-- STYLER -->

            <!-- /STYLER -->
            <!-- BREADCRUMBS -->
            <ul class="breadcrumb">
                <li>
                    <i class="fa fa-home"></i>
                    <a href="<?php echo site_url(ADMIN_DIR . $this->session->userdata("role_homepage_uri")); ?>"><?php echo $this->lang->line('Home'); ?></a>
                </li>
                <li><?php echo $title; ?></li>
            </ul>
            <!-- /BREADCRUMBS -->
            <div class="row">

                <div class="col-md-6">
                    <div class="clearfix">
                        <h3 class="content-title pull-left"><?php echo $title; ?></h3>
                    </div>
                    <div class="description">Teachers List</div>
                </div>

                <div class="col-md-6">
                    <div class="pull-right">
                        <button onclick="get_teacher_form('0')" class="btn btn-primary">Add New Teachers</button>
                        <button id="reloadTeachers" class="btn btn-primary">X Teachers</button>

                        <a class="btn btn-danger btn-sm" href="<?php echo site_url(ADMIN_DIR . "teachers/trashed"); ?>"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('Trash'); ?></a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<!-- /PAGE HEADER -->

<!-- PAGE MAIN CONTENT -->
<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-12">
        <div class="box border blue" id="messenger">
            <div class="box-title">
                <h4><i class="fa fa-users"></i> Current Teachers List</h4>
                <!--<div class="tools">
            
				<a href="#box-config" data-toggle="modal" class="config">
					<i class="fa fa-cog"></i>
				</a>
				<a href="javascript:;" class="reload">
					<i class="fa fa-refresh"></i>
				</a>
				<a href="javascript:;" class="collapse">
					<i class="fa fa-chevron-up"></i>
				</a>
				<a href="javascript:;" class="remove">
					<i class="fa fa-times"></i>
				</a>
				

			</div>-->
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
                            })
                            .done(function(respose) {
                                $('#modal').modal('show');
                                $('#modal_title').html('Teachers');
                                $('#modal_body').html(respose);
                            });
                    }
                </script>
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
                        font-size: 10px !important;
                        color: black;
                        margin: 0px !important;
                    }
                </style>
                <div class="table-responsive" style="overflow-x: auto;">
                    <table id="datatable" class="table  table_small table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Teacher Name</th>
                                <th>Father Name</th>
                                <th>Gender</th>
                                <th>Date Of Birth</th>
                                <th>Teacher Designation</th>
                                <th>Cnic</th>
                                <th>Mobile Number</th>
                                <th>Acadmic Qualification</th>
                                <th>Professional Qualification</th>
                                <th>Initial Appointment Date</th>
                                <th>Current School Assumption Date</th>
                                <th>Current Post Assumption Date</th>
                                <th>Personal No</th>
                                <th>Basic Pay Scale</th>
                                <th>Current Pay</th>
                                <th>Gp Fund Number</th>
                                <th>Bank Branch</th>
                                <th>Bank Branch Code</th>
                                <th>Bank Account No</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>User Name</th>
                                <th>Password</th>

                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>



                <script>
                    $(document).ready(function() {
                        document.title = "teachers (Date:<?php echo date('d-m-Y h:m:s') ?>)";

                        var table = $("#datatable").DataTable({
                            "processing": true,
                            "serverSide": true,
                            "ajax": {
                                "url": "<?php echo base_url(ADMIN_DIR . 'teachers/teachers_list'); ?>",
                                "type": "POST",
                                "data": function(d) {
                                    d.status = 1; // Default to active teachers
                                }
                            },
                            "columns": [{
                                    "data": null,
                                    "render": function(data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
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
                                    "data": "acadmic_qualification"
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
                                        return '<a class="llink llink-edit" onclick="get_teacher_form(' + row.teacher_id + ')"><i class="fa fa-pencil-square-o"></i></a>';
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
                            dom: "Bfrtip",
                            buttons: ["excel", "pageLength"]
                        });

                        // Button to reload with status=0
                        $("#reloadTeachers").click(function() {
                            table.ajax.reload(null, false); // Keep the current page
                            table.ajax.url("<?php echo base_url(ADMIN_DIR . 'teachers/teachers_list'); ?>").load(function(json) {
                                json.data.forEach(function(d) {
                                    d.status = 0; // Load inactive teachers
                                });
                            });
                        });
                    });
                </script>


            </div>

        </div>
    </div>
    <!-- /MESSENGER -->
</div>