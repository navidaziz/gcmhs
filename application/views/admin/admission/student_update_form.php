<div class="modal-header">
    <h5 class="modal-title pull-left" id="">Update Student Profile</h5>
    <button type="button" class="close pull-right" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <br />
</div>
<div class="modal-body">

    <form action="<?php echo site_url(ADMIN_DIR . "admission/update_profile/" . $students[0]->student_id) ?>" method="post" style="text-align: center;">
        <input type="hidden" name="redirect_to" value="students_list" />
        <table class="table table_small">
            <tr>
                <th style="width: 300px;">Class No: </th>
                <td><input required type="number" style="width:100%" name="student_class_no" value="<?php echo $students[0]->student_class_no; ?>" /></td>
            </tr>
            <tr>
                <th>Admission No: </th>
                <td><input required type="number" style="width:100%" name="student_admission_no" value="<?php echo $students[0]->student_admission_no; ?>" /></td>
            </tr>
            <tr>
                <th>Student Name: </th>
                <td><input required type="text" style="width:100%" name="student_name" value="<?php echo $students[0]->student_name; ?>" /></td>
            </tr>
            <tr>
                <th>Father Name: </th>
                <td><input required type="text" style="width:100%" name="student_father_name" value="<?php echo $students[0]->student_father_name; ?>" /></td>
            </tr>

            <tr>
                <th>Date Of Birth: </th>
                <td><input required type="date" name="student_data_of_birth" value="<?php echo date('Y-m-d', strtotime($students[0]->student_data_of_birth)); ?>" /></td>
            </tr>

            <tr>
                <th>Place Of Birth: </th>
                <td><input required type="text" name="place_of_birth" value="<?php echo $students[0]->place_of_birth; ?>" /></td>
            </tr>
            <tr>
                <th>Mother Tongue: </th>
                <td><input required type="text" name="mother_tongue" value="<?php echo $students[0]->mother_tongue; ?>" /></td>
            </tr>
            <tr>
                <th>Admission Date:</th>
                <td><input required type="date" name="admission_date" value="<?php echo date('Y-m-d', strtotime($students[0]->admission_date)); ?>" /></td>
            </tr>
            <tr>
                <th>Address:</th>
                <td><input required type="text" style="width:100%" name="student_address" value="<?php echo $students[0]->student_address; ?>" /></td>
            </tr>
            <script>
                // if($("input[type='radio'].radioBtnClass").is(':checked')) {
                //     var card_type = $("input[type='radio'].radioBtnClass:checked").val();
                //     alert(card_type);
                // }

                function change_masking(value) {
                    if (value == 'Pakistani') {
                        $('#father_nic').inputmask('99999-9999999-9');
                        $('#form_b').inputmask('99999-9999999-9');
                    }
                    if (value == 'Afghani') {
                        $('#father_nic').inputmask('aa9999-9999999-9');
                        $('#form_b').inputmask('aa999-9999999-9');
                    }

                    if (value == 'Other') {
                        $('#father_nic').inputmask('remove');
                        $('#form_b').inputmask('remove')

                    }
                }
            </script>
            <tr>
                <th>
                    Nationality: <br />
                    Father CNIC No:</th>
                <td>
                    <input onchange="change_masking('Pakistani')" class="nationality" type="radio" name="nationality" value="Pakistani" <?php if ($students[0]->nationality == 'Pakistani') { ?>checked<?php } ?> />
                    Pakistani
                    <span style="margin-left: 10px;"></span>
                    <input onchange="change_masking('Afghani')" class="nationality" type="radio" name="nationality" value="Afghani" <?php if ($students[0]->nationality == 'Afghani') { ?>checked<?php } ?> />
                    Afghani
                    <span style="margin-left: 10px;"></span>

                    <input onchange="change_masking('Other')" type="radio" name="nationality" value="Other" <?php if ($students[0]->nationality == 'Other') { ?>checked<?php } ?> />
                    Other
                    <span style="margin-left: 10px;"></span>
                    <input type="text" style="width:100%" id="father_nic" name="father_nic" value="<?php echo $students[0]->father_nic; ?>" />
                </td>
            </tr>
            <tr>
                <th>CNIC Issue Date:</th>
                <td><input type="date" name="nic_issue_date" value="<?php echo $students[0]->nic_issue_date; ?>" /></td>
            </tr>
            <tr>
                <th>Student Form B No:</th>
                <td><input type="text" style="width:100%" id="form_b" name="form_b" value="<?php echo $students[0]->form_b; ?>" /></td>
            </tr>


            <tr>
                <th>Father Occupation:</th>
                <td><input required type="text" style="width:100%" name="guardian_occupation" value="<?php echo $students[0]->guardian_occupation; ?>" /></td>
            </tr>
            <tr>
                <th>Guardian Name:</th>
                <td><input type="text" style="width:100%" name="guardian_name" value="<?php echo $students[0]->guardian_name; ?>" /></td>
            </tr>

            <tr>
                <th>Guardian Relation:</th>
                <td><input required type="text" style="width:100%" name="guardian_relation" value="<?php echo $students[0]->guardian_relation; ?>" /></td>
            </tr>
            <tr>
                <th>Father / Guardian Contact No:</th>
                <td><input required type="text" style="width:100%" id="father_mobile_number" name="father_mobile_number" value="<?php echo $students[0]->father_mobile_number; ?>" /></td>
            </tr>

            <tr>
                <th>Mother Contact No:</th>
                <td><input type="text" style="width:100%" id="mother_mobile_no" name="mother_mobile_no" value="<?php echo $students[0]->mother_mobile_no; ?>" /></td>
            </tr>
            <tr>
                <th>Religion:</th>
                <td>
                    <input required type="radio" name="religion" value="Islam" <?php if ($students[0]->religion == 'Islam') { ?>checked<?php } ?> />
                    Muslim
                    <span style="margin-left: 20px;"></span>
                    <input required type="radio" name="religion" value="Non Muslim" <?php if ($students[0]->religion == 'Non Muslim') { ?>checked<?php } ?> />
                    Non Muslim
                    <span style="margin-left: 20px;"></span>
                </td>
            </tr>

            <tr>
                <th>Private / Public School:</th>

                <td>
                    <input required type="radio" name="private_public_school" value="G" <?php if ($students[0]->private_public_school == 'G') { ?>checked<?php } ?> />
                    Government
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="private_public_school" value="P" <?php if ($students[0]->private_public_school == 'P') { ?>checked<?php } ?> />
                    Private
                </td>

            </tr>
            <tr>
                <th>School Name:</th>
                <td><input required type="text" style="width:100%" name="school_name" value="<?php echo $students[0]->school_name; ?>" /></td>
            </tr>

            <tr>
                <th>Hafiz-e-Quran: </th>
                <td>

                    <input required type="radio" name="hafiz" value="Yes" <?php if ($students[0]->hafiz == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="hafiz" value="No" <?php if ($students[0]->hafiz == 'No') { ?>checked<?php } ?> />
                    No
                </td>
            </tr>
            <tr>
                <th>Orphan: </th>
                <td>

                    <input required type="radio" name="orphan" value="Yes" <?php if ($students[0]->orphan == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="orphan" value="No" <?php if ($students[0]->orphan == 'No') { ?>checked<?php } ?> />
                    No
                </td>
            </tr>




            <tr>
                <th>Is Disable: </th>
                <td>
                    <input required type="radio" name="is_disable" value="Yes" <?php if ($students[0]->is_disable == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="is_disable" value="No" <?php if ($students[0]->is_disable == 'No') { ?>checked<?php } ?> />
                    No
                </td>
            </tr>

            <tr>
                <th>Ehsaas Program: </th>
                <td>
                    <input required type="radio" name="ehsaas" value="Yes" <?php if ($students[0]->ehsaas == 'Yes') { ?>checked<?php } ?> />
                    Yes
                    <span style="margin-left: 20px;"></span>

                    <input required type="radio" name="ehsaas" value="No" <?php if ($students[0]->ehsaas == 'No') { ?>checked<?php } ?> />
                    No
                </td>
            </tr>




            <td colspan="2">
                <input required type="submit" class="btn btn-success btn-sm" value="Update Profile" />
                </tr>
        </table>




    </form>
    <script type="text/javascript" src="<?php echo site_url("assets/" . ADMIN_DIR . "js/jquery.inputmask.js"); ?>"></script>
    <script>
        $(document).ready(function() {
            <?php if ($students[0]->nationality == 'Pakistani') { ?>
                $('#father_nic').inputmask('99999-9999999-9');
                $('#form_b').inputmask('99999-9999999-9');
            <?php } ?>
            <?php if ($students[0]->nationality == 'Afghani') { ?>
                $('#father_nic').inputmask('aaa99-9999999-9');
                $('#form_b').inputmask('aaa99-9999999-9');
            <?php } ?>
            $('#father_mobile_number').inputmask('9999-9999999');
        });
    </script>
</div>