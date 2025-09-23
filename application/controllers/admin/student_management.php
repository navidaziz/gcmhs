<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Student_management extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();

		$this->load->library('form_validation');
	}


	public function index()
	{
		$this->data['title'] = "Student Management";
		$this->data["view"] = ADMIN_DIR . "student_management/home";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}


	public function view_student_list($class_id, $section_id)
	{
		// Cast IDs to integers for security
		$class_id   = (int) $class_id;
		$section_id = (int) $section_id;

		$this->data['class_id']   = $class_id;
		$this->data['section_id'] = $section_id;

		$query = $this->db->query("
        SELECT s.*, c.Class_title, sec.section_title 
        FROM students s
        JOIN classes c ON s.class_id = c.class_id
        JOIN sections sec ON s.section_id = sec.section_id
        WHERE s.class_id = ? AND s.section_id = ?
    	", array($class_id, $section_id));

		$class_section = $query->row();

		if ($class_section) {
			$this->data['title'] = $class_section->Class_title . " - " . $class_section->section_title . " Students List";
		} else {
			$this->data['title'] = "Students List";
		}

		$this->data["view"] = ADMIN_DIR . "student_management/class_section_students_list";
		$this->load->view(ADMIN_DIR . "layout", $this->data);
	}

	public function get_student_information()
	{
		$student_id = $this->input->post("student_id");

		// Get student data
		$query = "SELECT * FROM students WHERE student_id = ?";
		$student = $this->db->query($query, [$student_id])->row();

		if (!$student) {
			return json_encode(['error' => 'Student not found']);
		}

		// Prepare the image path
		$image_path = site_url('uploads/gcmhs/' . $student->student_image);

		// Clean data for output
		$clean_data = [
			'name' => htmlspecialchars($student->student_name),
			'father_name' => htmlspecialchars($student->student_father_name),
			'father_nic' => htmlspecialchars($student->father_nic),
			'mobile' => htmlspecialchars($student->father_mobile_number),
			'clean_mobile' => preg_replace('/[^0-9]/', '', $student->father_mobile_number)
		];

		// Build the HTML response
		$html = '
    <div class="student-info-popup">
        <div class="student-image text-center mb-3">
            <img src="' . $image_path . '" class="img-thumbnail" width="150" style="border: 2px solid #fff; box-shadow: 0 0 10px rgba(0,0,0,0.3);">
        </div>
        
        <div class="student-header text-center mb-3">
            <h4>' . $clean_data['name'] . '</h4>
        </div>
        
        <div class="student-details">
            <div class="detail-row">
                <span class="detail-label"><strong>Father Name:</strong></span>
                <span class="detail-value">' . $clean_data['father_name'] . '</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label"><strong>Father NIC:</strong></span>
                <span class="detail-value">' . $clean_data['father_nic'] . '</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label"><strong>Contact:</strong></span>
                <span class="detail-value">
                    <a href="tel:' . $clean_data['clean_mobile'] . '" class="phone-link">
                        ' . $clean_data['mobile'] . '
                    </a>
                    <a href="https://wa.me/' . $clean_data['clean_mobile'] . '" target="_blank" class="whatsapp-link ml-2">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </span>
            </div>
        </div>
    </div>';
		echo $html;
	}
}
