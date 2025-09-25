<style>
    .student-info-popup {
        max-width: 350px;
        margin: 0 auto;
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    .student-info-popup .student-image img {
        border-radius: 50%;
        border: 3px solid #007bff;
        width: 120px;
        height: 120px;
        object-fit: cover;
    }

    .student-info-popup .student-header h4 {
        margin-top: 10px;
        font-weight: bold;
        color: #333;
    }

    .student-info-popup .student-details {
        margin-top: 15px;
    }

    .student-info-popup .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .student-info-popup .detail-label {
        font-weight: 600;
        color: #555;
    }

    .student-info-popup .detail-value {
        color: #333;
    }

    .student-info-popup .phone-link {
        color: #007bff;
        text-decoration: none;
        font-weight: 600;
    }

    .student-info-popup .whatsapp-link {
        color: #25D366;
        font-weight: 600;
        text-decoration: none;
        margin-left: 10px;
    }

    .student-info-popup .whatsapp-link i {
        margin-right: 5px;
    }
</style>

<?php
$nationalities = array('Pakistani', 'Afghani', 'Other');

$family_situations = array(
    'Both'     => 'Both Parents Alive',
    'Divorced' => 'Divorced',
    'Widow'    => 'Widow',
    'Father'   => 'Single Father',
    'Orphan'   => 'Orphan',
    'Guardian' => 'Guardian'
);

$religions = array(
    'Islam' => 'Muslim',
    'Non Muslim' => 'Non Muslim'
);

$school_types = array(
    'G' => 'Government',
    'P' => 'Private'
);

$yes_no = array(
    'Yes' => 'Yes',
    'No'  => 'No'
);
?>

<style>
    .form-section table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-section th {
        width: 220px;
        text-align: left;
        padding: 8px;
        background: #f9f9f9;
        vertical-align: middle;
    }

    .form-section td {
        padding: 8px;
    }

    .form-section label {
        margin-right: 20px;
        font-weight: normal;
    }
</style>

<?php
$image_path = site_url('uploads/gcmhs/' . $student->student_image);
$clean_mobile = preg_replace('/[^0-9]/', '', $student->father_mobile_number);
?>
<div class="row">
    <div class="col-md-4">
        <div class="student-info-popup">
            <div class="student-image text-center mb-3">
                <img src="<?php echo $image_path; ?>" class="img-thumbnail">
            </div>

            <div class="student-header text-center mb-3">
                <h4><?php echo htmlspecialchars($student->student_name); ?> S/O <?php echo htmlspecialchars($student->student_father_name); ?></h4>
            </div>

            <div class="student-details">
                <div class="detail-row">
                    <span class="detail-label">Father NIC:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($student->father_nic); ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Contact:</span>
                    <span class="detail-value">
                        <a href="tel:<?php echo $clean_mobile; ?>" class="phone-link">
                            <?php echo htmlspecialchars($student->father_mobile_number); ?>
                        </a>
                        <a href="https://wa.me/<?php echo $clean_mobile; ?>" target="_blank" class="whatsapp-link">
                            <i class="fab fa-whatsapp"></i> WhatsApp
                        </a>
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-8">
        <div class="form-section">
            <form class="form-horizontal" method="post">

                <!-- Nationality -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Nationality:</label>
                    <div class="col-sm-9">
                        <?php foreach ($nationalities as $nation) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="nationality" value="<?php echo $nation; ?>"
                                    <?php if ($student->nationality == $nation) echo 'checked'; ?>>
                                <?php echo $nation; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Religion -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Religion:</label>
                    <div class="col-sm-9">
                        <?php foreach ($religions as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="religion" value="<?php echo $value; ?>"
                                    <?php if ($student->religion == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Private / Public School -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Private / Public School:</label>
                    <div class="col-sm-9">
                        <?php foreach ($school_types as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="private_public_school" value="<?php echo $value; ?>"
                                    <?php if ($student->private_public_school == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- School Name -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">School Name:</label>
                    <div class="col-sm-9">
                        <input required type="text" class="form-control"
                            name="school_name"
                            value="<?php echo htmlspecialchars($student->school_name); ?>">
                    </div>
                </div>

                <!-- Hafiz-e-Quran -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Hafiz-e-Quran:</label>
                    <div class="col-sm-9">
                        <?php foreach ($yes_no as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="hafiz" value="<?php echo $value; ?>"
                                    <?php if ($student->hafiz == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Orphan -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Orphan:</label>
                    <div class="col-sm-9">
                        <?php foreach ($yes_no as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="orphan" value="<?php echo $value; ?>"
                                    <?php if ($student->orphan == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Is Disable -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Is Disable:</label>
                    <div class="col-sm-9">
                        <?php foreach ($yes_no as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="is_disable" value="<?php echo $value; ?>"
                                    <?php if ($student->is_disable == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Works After School -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Works After School:</label>
                    <div class="col-sm-9">
                        <?php foreach ($yes_no as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="works_after_school" value="<?php echo $value; ?>"
                                    <?php if ($student->works_after_school == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Criminal History -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Criminal History:</label>
                    <div class="col-sm-9">
                        <?php foreach ($yes_no as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="criminal_history" value="<?php echo $value; ?>"
                                    <?php if ($student->criminal_history == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Family Situations -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Family Situations:</label>
                    <div class="col-sm-9">
                        <?php foreach ($family_situations as $family_situation) { ?>
                            <label class="radio-inline">
                                <input type="radio" name="family_situation" value="<?php echo $family_situation; ?>"
                                    <?php if ($student->family_situation == $family_situation) echo 'checked'; ?>>
                                <?php echo $family_situation; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Ehsaas Program -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Ehsaas Program:</label>
                    <div class="col-sm-9">
                        <?php foreach ($yes_no as $value => $label) { ?>
                            <label class="radio-inline">
                                <input required type="radio" name="ehsaas" value="<?php echo $value; ?>"
                                    <?php if ($student->ehsaas == $value) echo 'checked'; ?>>
                                <?php echo $label; ?>
                            </label>
                        <?php } ?>
                    </div>
                </div>

                <!-- Father Occupation -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Father Occupation:</label>
                    <div class="col-sm-9">
                        <input required type="text" class="form-control"
                            name="guardian_occupation"
                            value="<?php echo $student->guardian_occupation; ?>">
                    </div>
                </div>

                <!-- Guardian Contact -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Father / Guardian Contact No:</label>
                    <div class="col-sm-9">
                        <input required type="text" class="form-control"
                            id="guardian_contact_no"
                            name="guardian_contact_no"
                            value="<?php echo $student->guardian_contact_no; ?>">
                    </div>
                </div>

                <!-- Mother Contact -->
                <div class="form-group">
                    <label class="col-sm-3 control-label">Mother Contact No:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control"
                            id="mother_mobile_no"
                            name="mother_mobile_no"
                            value="<?php echo $student->mother_mobile_no; ?>">
                    </div>
                </div>

            </form>

        </div>
    </div>

</div>