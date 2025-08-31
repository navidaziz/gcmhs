<?php

/**
 * Refactored Student Profile View
 * - Readability: single $student var, fewer repetitions
 * - Security: htmlspecialchars() for echoed values, CSRF tokens in forms
 * - HTML: valid structure, labels, no nested forms inside <p>
 * - JS: all scripts consolidated at bottom; fixed DMC AJAX
 * - Notes: kept existing DB calls that were already present to avoid breaking functionality.
 *          Ideally move DB queries to controller/model and pass ready-made arrays to the view.
 */

// Guard: expect $students to be a non-empty array of row objects
after_extract:
$student = isset($students[0]) ? $students[0] : null;
if (!$student) {
    echo '<div class="alert alert-danger">Student record not found.</div>';
    return;
}

$class_id   = (int) $student->class_id;
$section_id = (int) $student->section_id;

// Helper shortcut
function e($str)
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}
?>

<!-- Update Profile Modal -->
<div id="update_profile" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left">Student Profile Update</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <form action="<?= site_url(ADMIN_DIR . 'admission/update_profile/' . (int)$student->student_id) ?>" method="post" class="form-horizontal">
                    <input type="hidden" name="<?= e($this->security->get_csrf_token_name()) ?>" value="<?= e($this->security->get_csrf_hash()) ?>">
                    <table class="table">
                        <tr>
                            <th><label for="student_class_no">Class No:</label></th>
                            <td><input id="student_class_no" type="text" name="student_class_no" value="<?= e($student->student_class_no) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="student_admission_no">Admission No:</label></th>
                            <td><input id="student_admission_no" type="text" name="student_admission_no" value="<?= e($student->student_admission_no) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="student_name">Student Name:</label></th>
                            <td><input id="student_name" type="text" name="student_name" value="<?= e($student->student_name) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="student_father_name">Father Name:</label></th>
                            <td><input id="student_father_name" type="text" name="student_father_name" value="<?= e($student->student_father_name) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="student_data_of_birth">Date Of Birth:</label></th>
                            <td>
                                <!-- NOTE: field name kept as student_data_of_birth to match existing schema -->
                                <input id="student_data_of_birth" type="date" name="student_data_of_birth" value="<?= e($student->student_data_of_birth) ?>" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th><label for="form_b">Form B No:</label></th>
                            <td><input id="form_b" type="text" name="form_b" value="<?= e($student->form_b) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="admission_date">Admission Date:</label></th>
                            <td><input id="admission_date" type="date" name="admission_date" value="<?= e($student->admission_date) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="student_address">Address:</label></th>
                            <td><input id="student_address" type="text" name="student_address" value="<?= e($student->student_address) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="father_nic">Father CNIC No:</label></th>
                            <td><input id="father_nic" type="text" name="father_nic" value="<?= e($student->father_nic) ?>" class="form-control" placeholder="xxxxx-xxxxxxx-x"></td>
                        </tr>
                        <tr>
                            <th><label for="nic_issue_date">CNIC Issue Date:</label></th>
                            <td><input id="nic_issue_date" type="date" name="nic_issue_date" value="<?= e($student->nic_issue_date) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="father_mobile_number">Contact No:</label></th>
                            <td><input id="father_mobile_number" type="text" name="father_mobile_number" value="<?= e($student->father_mobile_number) ?>" class="form-control" placeholder="03xx-xxxxxxx"></td>
                        </tr>
                        <tr>
                            <th><label for="guardian_occupation">Father Occupation:</label></th>
                            <td><input id="guardian_occupation" type="text" name="guardian_occupation" value="<?= e($student->guardian_occupation) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="religion">Religion:</label></th>
                            <td><input id="religion" type="text" name="religion" value="<?= e($student->religion) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th><label for="nationality">Nationality:</label></th>
                            <td><input id="nationality" type="text" name="nationality" value="<?= e($student->nationality) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Private / Public School:</th>
                            <td>
                                <label class="radio-inline">
                                    <input type="radio" name="private_public_school" value="G" <?= ($student->private_public_school === 'G') ? 'checked' : '' ?>> Government
                                </label>
                                <label class="radio-inline" style="margin-left:20px;">
                                    <input type="radio" name="private_public_school" value="P" <?= ($student->private_public_school === 'P') ? 'checked' : '' ?>> Private
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th><label for="school_name">School Name:</label></th>
                            <td><input id="school_name" type="text" name="school_name" value="<?= e($student->school_name) ?>" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Orphan:</th>
                            <td>
                                <label class="radio-inline"><input type="radio" name="orphan" value="Yes" <?= ($student->orphan === 'Yes') ? 'checked' : '' ?>> Yes</label>
                                <label class="radio-inline" style="margin-left:20px;"><input type="radio" name="orphan" value="No" <?= ($student->orphan === 'No') ? 'checked' : '' ?>> No</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Vaccinated:</th>
                            <td>
                                <label class="radio-inline"><input type="radio" name="vaccinated" value="Yes" <?= ($student->vaccinated === 'Yes') ? 'checked' : '' ?>> Yes</label>
                                <label class="radio-inline" style="margin-left:20px;"><input type="radio" name="vaccinated" value="No" <?= ($student->vaccinated === 'No') ? 'checked' : '' ?>> No</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Is Disable:</th>
                            <td>
                                <label class="radio-inline"><input type="radio" name="is_disable" value="Yes" <?= ($student->is_disable === 'Yes') ? 'checked' : '' ?>> Yes</label>
                                <label class="radio-inline" style="margin-left:20px;"><input type="radio" name="is_disable" value="No" <?= ($student->is_disable === 'No') ? 'checked' : '' ?>> No</label>
                            </td>
                        </tr>
                        <tr>
                            <th>Ehsaas Program:</th>
                            <td>
                                <label class="radio-inline"><input type="radio" name="ehsaas" value="Yes" <?= ($student->ehsaas === 'Yes') ? 'checked' : '' ?>> Yes</label>
                                <label class="radio-inline" style="margin-left:20px;"><input type="radio" name="ehsaas" value="No" <?= ($student->ehsaas === 'No') ? 'checked' : '' ?>> No</label>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right">
                                <button type="submit" class="btn btn-success btn-sm"><i class="fa fa-save"></i> Update Profile</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Re-admit Modal -->
<div id="re_admit" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="readmit_model_title">Student Re Admit Form</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <div id="re_admit_body" class="text-center">Please Wait .....</div>
                <form action="<?= site_url(ADMIN_DIR . 'admission/re_admit_again') ?>" method="post" class="text-center" style="margin-top:10px;">
                    <input type="hidden" name="<?= e($this->security->get_csrf_token_name()) ?>" value="<?= e($this->security->get_csrf_hash()) ?>">
                    <input type="hidden" name="student_id" id="studentID" value="">
                    <input type="hidden" name="class_id" value="<?= (int)$class_id ?>">
                    <input type="hidden" name="section_id" value="<?= (int)$section_id ?>">
                    <input type="hidden" name="redirect_page" value="view_student_profile">

                    <div class="form-group">
                        <label for="admission_no">Admission No:</label>
                        <input type="text" name="admission_no" id="admission_no" value="" class="form-control" style="display:inline-block; width:auto;">
                    </div>
                    <div class="form-group">
                        <label for="re_admit_again_reason">Re-Admission Detail:</label>
                        <input required type="text" class="form-control" name="re_admit_again_reason" id="re_admit_again_reason">
                    </div>
                    <button type="submit" class="btn btn-success btn-sm">Admit Again</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Withdraw Modal -->
<div id="withdrawal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="withdrawal_model_title">Student Withdraw Form</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <div id="withdrawal_admit_body">Please Wait .....</div>
                <form action="<?= site_url(ADMIN_DIR . 'admission/withdraw_student') ?>" method="post">
                    <input type="hidden" name="<?= e($this->security->get_csrf_token_name()) ?>" value="<?= e($this->security->get_csrf_hash()) ?>">
                    <input type="hidden" name="student_id" id="stID" value="">
                    <input type="hidden" name="class_id" value="<?= (int)$class_id ?>">
                    <input type="hidden" name="section_id" value="<?= (int)$section_id ?>">
                    <input type="hidden" name="redirect_page" value="view_student_profile">

                    <table class="table" style="width: 100%;">
                        <tr>
                            <td><label for="adNo">Admission No:</label></td>
                            <td><input type="text" required name="admission_no" id="adNo" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="add_date">Admission Date:</label></td>
                            <td><input type="date" required name="admission_date" id="add_date" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="school_leaving_date">School Leaving Date:</label></td>
                            <td><input type="date" required name="school_leaving_date" id="school_leaving_date" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="slc_issue_date">SLC Issue Date:</label></td>
                            <td><input type="date" required name="slc_issue_date" id="slc_issue_date" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="slc_file_no">SLC File No:</label></td>
                            <td><input type="text" required name="slc_file_no" id="slc_file_no" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="slc_certificate_no">SLC Certificate No:</label></td>
                            <td><input type="text" required name="slc_certificate_no" id="slc_certificate_no" value="" class="form-control"></td>
                        </tr>
                        <tr>
                            <td><label for="withdraw_reason">Withdrawal Reason:</label></td>
                            <td><textarea id="withdraw_reason" class="form-control" name="withdraw_reason" rows="3"></textarea></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-right"><button type="submit" class="btn btn-danger btn-sm">Withdraw</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- General Modal (AJAX content) -->
<div id="general_model" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="general_model_body"></div>
    </div>
</div>

<!-- Struck Off Modal -->
<div id="struck_off" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title pull-left" id="sof_model_title">Student Struck Off Form</h5>
                <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <br />
            </div>
            <div class="modal-body">
                <div id="struck_off_body">Please Wait .....</div>
                <form action="<?= site_url(ADMIN_DIR . 'teacher_dashboard/struck_off_student') ?>" method="post" class="text-center" style="margin-top:10px;">
                    <input type="hidden" name="<?= e($this->security->get_csrf_token_name()) ?>" value="<?= e($this->security->get_csrf_hash()) ?>">
                    <input type="hidden" name="student_id" id="student_ID" value="">
                    <input type="hidden" name="class_id" value="<?= (int)$class_id ?>">
                    <input type="hidden" name="section_id" value="<?= (int)$section_id ?>">
                    <input type="hidden" name="redirect_page" value="view_student_profile">
                    <input required type="text" class="form-control" name="struck_off_reason" placeholder="Reason" style="margin:10px 0;">
                    <button type="submit" class="btn btn-danger btn-sm">Struck Off</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Page Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <ul class="breadcrumb">
                <li><i class="fa fa-home"></i> Home</li>
                <li><a href="<?= site_url(ADMIN_DIR . 'admission/') ?>">Admission</a></li>
                <li><?= e($student->student_name) ?> Profile</li>
            </ul>
            <div class="col-md-4">
                <div class="clearfix">
                    <h6 class="content-title pull-left"><?= strtoupper(e($student->student_name)) ?></h6>
                </div>
            </div>
            <div class="col-md-8">
                <h5 class="pull-right">
                    <?php if ((int)$student->status === 1): ?>
                        <button onclick="struck_off_model('<?= (int)$student->student_id ?>','<?= e($student->student_name) ?>','<?= e($student->student_father_name) ?>','<?= e($student->student_admission_no) ?>')" class="btn btn-warning btn-sm">Struck Off</button>
                        <button onclick="withdraw('<?= (int)$student->student_id ?>','<?= e($student->student_name) ?>','<?= e($student->student_father_name) ?>','<?= e($student->student_admission_no) ?>','<?= e($student->admission_date) ?>')" class="btn btn-danger btn-sm">Withdraw</button>
                    <?php endif; ?>

                    <?php if ((int)$student->status === 2): ?>
                        <button onclick="re_admit('<?= (int)$student->student_id ?>','<?= e($student->student_name) ?>','<?= e($student->student_father_name) ?>','<?= e($student->student_admission_no) ?>')" class="btn btn-success btn-sm">Re-admit</button>
                        <button onclick="withdraw('<?= (int)$student->student_id ?>','<?= e($student->student_name) ?>','<?= e($student->student_father_name) ?>','<?= e($student->student_admission_no) ?>','<?= e($student->admission_date) ?>')" class="btn btn-danger btn-sm">Withdraw</button>
                    <?php endif; ?>

                    <?php if ((int)$student->status === 3): ?>
                        <button onclick="re_admit('<?= (int)$student->student_id ?>','<?= e($student->student_name) ?>','<?= e($student->student_father_name) ?>','<?= e($student->student_admission_no) ?>')" class="btn btn-success btn-sm">Re-admit</button>
                    <?php endif; ?>

                    <?php if ((int)$student->status !== 0): ?>
                        <a class="btn btn-primary btn-sm" target="_new" href="<?= site_url(ADMIN_DIR . 'admission/birth_certificate/' . (int)$student->student_id) ?>"><i class="fa fa-print"></i> Birth Certificate</a>
                        <button onclick="update_profile()" class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit Profile</button>
                        <button onclick="change_class_form('<?= (int)$student->student_id ?>')" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Change Class</button>
                        <button onclick="change_section_form('<?= (int)$student->student_id ?>')" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Change Section</button>
                        <a href="<?= site_url(ADMIN_DIR . 'admission/delete_student_profile/' . (int)$student->student_id) ?>" onclick="return confirm('Are you sure? You want to remove student profile.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Delete Student</a>
                    <?php endif; ?>

                    <?php if ((int)$student->status === 0): ?>
                        <a href="<?= site_url(ADMIN_DIR . 'admission/restore_student_profile/' . (int)$student->student_id) ?>" onclick="return confirm('Are you sure? You want to restore student profile.')" class="btn btn-danger btn-sm"><i class="fa fa-undo"></i> Restore Student Profile</a>
                    <?php endif; ?>
                </h5>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin:0;">
    <div class="col-md-3">
        <div class="table-responsive">
            <div class="text-center" style="margin-bottom:10px;">
                <img src="<?= site_url('uploads/gcmhs/' . e($student->student_image)) ?>" width="120" alt="Student Photo" />
            </div>
            <strong><?= strtoupper(e($student->student_name)) ?> S/O <?= strtoupper(e($student->student_father_name)) ?></strong>
            <span style="font-size:20px !important;">
                <h5 class="pull-left"><?= e($this->lang->line('student_admission_no')) ?>: <?= e($student->student_admission_no) ?></h5>
                <h5 class="pull-right">
                    Status:
                    <?php if ((int)$student->status === 1): ?>Admitted<?php endif; ?>
                    <?php if ((int)$student->status === 2): ?>Struck Off<?php endif; ?>
                    <?php if ((int)$student->status === 3): ?>SLC<?php endif; ?>
                    <?php if ((int)$student->status === 0): ?>Deleted<?php endif; ?>
                </h5>
            </span>

            <?php foreach ($students as $stud): ?>
                <table class="table table-bordered table-striped">
                    <tr>
                        <td class="text-center"><?= e($this->lang->line('student_class_no')) ?></td>
                        <td class="text-center"><?= e($this->lang->line('Class_title')) ?></td>
                        <td class="text-center"><?= e($this->lang->line('section_title')) ?></td>
                    </tr>
                    <tr>
                        <td class="text-center"><?= e($stud->student_class_no) ?></td>
                        <td class="text-center"><?= e($stud->Class_title) ?></td>
                        <td class="text-center"><?= e($stud->section_title) ?></td>
                    </tr>
                </table>

                <table class="table table-bordered table-striped" style="width:100%;">
                    <tbody>
                        <tr>
                            <td>Form B:</td>
                            <td><?= strtoupper(e($student->form_b)) ?></td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td>
                            <td><?= e(date('d-m-Y', strtotime($stud->student_data_of_birth))) ?></td>
                        </tr>
                        <tr>
                            <td>Date Of Admission</td>
                            <td><?= e(date('d-m-Y', strtotime($stud->admission_date))) ?></td>
                        </tr>
                        <tr>
                            <td>Father Mobile No.</td>
                            <td><?= e($stud->father_mobile_number) ?></td>
                        </tr>
                        <tr>
                            <td>Father CNIC</td>
                            <td><?= e($stud->father_nic) ?></td>
                        </tr>
                        <tr>
                            <td>Father Occupation</td>
                            <td><?= e($stud->guardian_occupation) ?></td>
                        </tr>
                        <tr>
                            <td>Previous School</td>
                            <td><?= e($stud->private_public_school) ?> - <?= e($stud->school_name) ?></td>
                        </tr>
                        <tr>
                            <td>Nationality</td>
                            <td><?= e($stud->nationality) ?></td>
                        </tr>
                        <tr>
                            <td>Religion</td>
                            <td><?= e($stud->religion) ?></td>
                        </tr>
                        <tr>
                            <td>Orphan</td>
                            <td><?= e($stud->orphan) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2"><?= e($this->lang->line('student_address')) ?>: <?= e($stud->student_address) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2">Created date: <?= e(date('d M Y', strtotime($stud->created_date))) ?></td>
                        </tr>
                    </tbody>
                </table>
            <?php endforeach; ?>

        </div>
    </div>

    <div class="col-md-9">
        <div class="col-md-4">
            <h3 class="title">History</h3>
            <?php
            // NOTE: This still queries in-view to preserve behavior; ideally pass $student_history_list from controller
            $query = "SELECT *, s.section_title, c.class_title, se.session FROM `student_history` as sh
                JOIN sections as s ON sh.section_id = s.section_id
                JOIN classes  as c ON sh.class_id   = c.class_id
                JOIN sessions as se ON sh.session_id= se.session_id
                WHERE sh.student_id = ?";
            $student_history_list = $this->db->query($query, [$student->student_id])->result();
            foreach ($student_history_list as $student_history): ?>
                <div style="margin-bottom:5px;">
                    <span class="pull-left"><?= e($student_history->history_type) ?></span>
                    <span class="pull-right"><?= e(date('d M, Y', strtotime($student_history->create_date))) ?></span>
                    <br />
                    <?php if ($student_history->history_type === 'Promoted'): ?>
                        <small style="margin-left:5px; margin-right:5px;">
                            Promoted From Class <?= e($student_history->class_title) ?> To Class
                            <?php
                            $next_class = $this->db->query("SELECT Class_title FROM classes WHERE class_id > ? ORDER BY class_id ASC LIMIT 1", [$student_history->class_id])->row();
                            echo e($next_class ? $next_class->Class_title : 'N/A');
                            ?>.
                        </small>
                    <?php elseif ($student_history->history_type === 'Struck Off'): ?>
                        <small style="margin-left:5px; margin-right:5px;">Struck Off Due to <?= e($student_history->remarks) ?></small>
                    <?php elseif ($student_history->history_type === 'Withdraw'): ?>
                        <?php
                        $slc = $this->db->query(
                            "SELECT slc.*, u.user_title FROM student_leaving_certificates slc
                 JOIN users u ON slc.created_by = u.user_id
                 WHERE slc.student_id = ? AND DATE(slc.created_date) = ?",
                            [$student->student_id, date('Y-m-d', strtotime($student_history->create_date))]
                        )->row();
                        ?>
                        <?php if ($slc): ?>
                            <small style="margin-left:5px; margin-right:5px;">
                                Got School leaving Certificate.<br />
                                School Leaving Date: <?= e(date('d M, Y', strtotime($slc->school_leaving_date))) ?> <br />
                                SLC issue Date: <?= e(date('d M, Y', strtotime($slc->slc_issue_date))) ?> <br />
                                File Ref. No: <?= e($slc->slc_file_no) ?> &nbsp; Certificate Ref. No: <?= e($slc->slc_certificate_no) ?><br />
                                School leaving Reason: <i><?= e($slc->leaving_reason) ?></i><br />
                                User: <?= e($slc->user_title) ?>
                            </small>
                        <?php endif; ?>
                    <?php else: ?>
                        <small><?= e($student_history->remarks) ?></small>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="col-md-8">
            <h3 class="title">Academic Summary</h3>
            <style>
                .table_medium>tbody>tr>td,
                .table_medium>tbody>tr>th,
                .table_medium>tfoot>tr>td,
                .table_medium>tfoot>tr>th,
                .table_medium>thead>tr>td,
                .table_medium>thead>tr>th {
                    padding: 2px;
                    line-height: 1.42857143;
                    vertical-align: top;
                    border-top: 1px solid #ddd;
                    font-size: 12px;
                    border: 0.1px solid gray !important;
                }
            </style>
            <?php
            $query = "SELECT exr.student_id, ex.year, ex.exam_id, ex.exam_data, ex.term, c.class_title AS class,
                       sec.section_title AS section,
                       SUM(exr.obtain_mark) as obtain_mark,
                       SUM(exr.total_marks) as total_marks,
                       exr.passing_marks,
                       exr.percentage
                FROM students_exams_subjects_marks AS exr
                INNER JOIN exams   AS ex  ON ex.exam_id = exr.exam_id
                INNER JOIN classes AS c   ON c.class_id = exr.class_id
                INNER JOIN sections AS sec ON sec.section_id = exr.section_id
                WHERE exr.student_id = ?
                GROUP BY exr.exam_id";
            $student_exam_records = $this->db->query($query, [$student->student_id])->result();
            ?>
            <?php if (!empty($student_exam_records)): ?>
                <table class="table table-bordered table-striped table_medium">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Exam</th>
                            <th>Date</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Obtained Marks</th>
                            <th>Total Marks</th>
                            <th>Per.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($student_exam_records as $record): ?>
                            <tr>
                                <td><?= e($record->year) ?></td>
                                <td><?= e($record->term) ?></td>
                                <td><?= e(date('M-y', strtotime($record->exam_data))) ?></td>
                                <td><?= e($record->class) ?></td>
                                <td><?= e($record->section) ?></td>
                                <th class="text-center"><?= e($record->obtain_mark) ?></th>
                                <th class="text-center"><?= e($record->total_marks) ?></th>
                                <th class="text-center"><?= e(round(($record->total_marks > 0 ? ($record->obtain_mark * 100 / $record->total_marks) : 0), 2)) ?>%</th>
                                <th><button class="btn btn-success btn-sm" onclick="get_student_dmc('<?= (int)$student->student_id ?>', '<?= (int)$record->exam_id ?>')">DMC</button></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No exam records found for this student.</p>
            <?php endif; ?>
        </div>

        <style>
            .table_small>tbody>tr>td,
            .table_small>tbody>tr>th,
            .table_small>tfoot>tr>td,
            .table_small>tfoot>tr>th,
            .table_small>thead>tr>td,
            .table_small>thead>tr>th {
                padding: 1px;
                line-height: 1.42857143;
                vertical-align: top;
                border-top: 1px solid #ddd;
                font-size: 9px;
                border: 0.1px solid gray !important;
                color: black !important;
            }

            .disabled-day {
                background-color: #f5f5f5;
            }
        </style>

        <div class="col-md-12">
            <h4>Attendance History</h4>
            <table class="table table-bordered table-striped table_small" style="width:100%; font-size:12px;">
                <thead>
                    <tr>
                        <th>Month / Days</th>
                        <?php for ($day = 1; $day <= 31; $day++): ?>
                            <th style="width:50px; text-align:center; vertical-align:middle;"><?= $day ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $monthNames = [
                        '01' => 'January',
                        '02' => 'February',
                        '03' => 'March',
                        '04' => 'April',
                        '05' => 'May',
                        '06' => 'June',
                        '07' => 'July',
                        '08' => 'August',
                        '09' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December'
                    ];
                    $currentYear = date('Y');

                    foreach ($monthNames as $monthNum => $monthName):
                        $daysInMonth = date('t', mktime(0, 0, 0, (int)$monthNum, 1, (int)$currentYear));
                    ?>
                        <tr>
                            <th><?= $monthName ?></th>
                            <?php for ($day = 1; $day <= 31; $day++): ?>
                                <?php if ($day > $daysInMonth): ?>
                                    <td class="disabled-day"></td>
                                <?php else: ?>
                                    <?php
                                    $att_q = "SELECT attendance, attendance2 FROM `students_attendance`
                            WHERE `student_id` = ? AND YEAR(`date`) = ? AND MONTH(`date`) = ? AND DAY(`date`) = ?";
                                    $students_attendance = $this->db->query($att_q, [
                                        $student->student_id,
                                        $currentYear,
                                        $monthNum,
                                        $day
                                    ])->row();

                                    $style = '';
                                    if (!empty($students_attendance)) {
                                        if ($students_attendance->attendance === 'A') {
                                            $style = 'background-color:#D8534E;'; // Absent - red
                                        } elseif ($students_attendance->attendance === 'P') {
                                            if (empty($students_attendance->attendance2) || $students_attendance->attendance2 === 'P') {
                                                $style = 'background-color:#96AE5F;'; // Present - green
                                            } elseif ($students_attendance->attendance2 === 'A') {
                                                $style = 'background-color:#F0AD4E;'; // Half - orange
                                            }
                                        }
                                    }
                                    ?>
                                    <td style="text-align:center; <?= $style ?>">
                                        <?php if (!empty($students_attendance)):
                                            echo e($students_attendance->attendance);
                                            if (!empty($students_attendance->attendance2)) {
                                                echo ' - ' . e($students_attendance->attendance2);
                                            }
                                        endif; ?>
                                    </td>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Consolidated Scripts -->
<script>
    function update_profile() {
        jQuery('#update_profile').modal('show');
    }

    function re_admit(student_id, name, father_name, add_no) {
        jQuery('#readmit_model_title').text('Student Re Admit Form');
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
        jQuery('#admission_no').val(add_no);
        jQuery('#studentID').val(student_id);
        jQuery('#re_admit_body').html(body);
        jQuery('#re_admit').modal('show');
    }

    function withdraw(student_id, name, father_name, add_no, admission_date) {
        jQuery('#withdrawal_model_title').text('Student Withdraw Form');
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + '<br /> Admission Date: ' + admission_date + '<br /> ';
        jQuery('#adNo').val(add_no);
        jQuery('#add_date').val(admission_date);
        jQuery('#stID').val(student_id);
        jQuery('#withdrawal_admit_body').html(body);
        jQuery('#withdrawal').modal('show');
    }

    function change_class_form(student_id) {
        jQuery.ajax({
            type: 'POST',
            url: '<?= site_url(ADMIN_DIR . 'admission/change_class_form'); ?>',
            data: {
                student_id: student_id
            }
        }).done(function(data) {
            jQuery('#general_model_body').html(data);
            jQuery('#general_model').modal('show');
        });
    }

    function change_section_form(student_id) {
        jQuery.ajax({
            type: 'POST',
            url: '<?= site_url(ADMIN_DIR . 'admission/change_section_form'); ?>',
            data: {
                student_id: student_id
            }
        }).done(function(data) {
            jQuery('#general_model_body').html(data);
            jQuery('#general_model').modal('show');
        });
    }

    function struck_off_model(student_id, name, father_name, add_no) {
        jQuery('#sof_model_title').text('Student Struck Off Form');
        var body = ' Admission No: ' + add_no + ' <br /> Student Name: ' + name + '<br /> Father Name: ' + father_name + ' ';
        jQuery('#student_ID').val(student_id);
        jQuery('#struck_off_body').html(body);
        jQuery('#struck_off').modal('show');
    }

    function get_student_dmc(student_id, exam_id) {
        jQuery.ajax({
            method: 'POST',
            url: '<?= site_url(ADMIN_DIR . 'admission/get_student_dmc'); ?>',
            data: {
                student_id: student_id,
                exam_id: exam_id
            }
        }).done(function(response) {
            jQuery('#general_model_body').html(response);
            jQuery('#general_model').modal('show');
        });
    }
</script>