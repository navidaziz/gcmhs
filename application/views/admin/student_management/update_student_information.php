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
$image_path = site_url('uploads/gcmhs/' . $student->student_image);
$clean_mobile = preg_replace('/[^0-9]/', '', $student->father_mobile_number);
?>

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