<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Results extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/result_model");
		$this->lang->load("results", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
	 
	 
	 public function class_wise_student_results(){
		 
		 
		 $all_results = array(); 
		 
		$query = "SELECT DISTINCT `class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		
		foreach($classes as $class){
				
					//get class  / section wise resutl 
					$query ="SELECT * FROM results WHERE class = '".$class->class."' order by section, percentage DESC";
					$result = $this->db->query($query);
					
					$all_results[$class->class] = $result->result();
						
					}
					
		 
		
		$this->data["all_results"] = $all_results;
		 $this->data["title"] = $this->lang->line('Results');
		$this->data["view"] = ADMIN_DIR."results/class_wise_student_results";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		// $this->load->view(ADMIN_DIR."results/print_result", $this->data);
		 
		 
		 
		 
		 
		 
	 }
	 
	 
	 
	 
	 public function student_class(){
		 
		 
		 
		 /*$all_results = array(); 
		 
		$query = "SELECT DISTINCT `class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		
		foreach($classes as $class){
				
					//get class  / section wise resutl 
					$query ="SELECT * FROM results WHERE class = '".$class->class."'";
					$result = $this->db->query($query);
					
					$all_results[$class->class] = $result->result();
						
					}*/
					
		 
		 
		 
		$all_results = array(); 
		 
		$query = "SELECT DISTINCT `promote_class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		
		foreach($classes as $class){
				
					//get class  / section wise resutl 
					$query ="SELECT * FROM results WHERE promote_class = '".$class->promote_class."' ORDER BY percentage DESC";
					$result = $this->db->query($query);
					
					$all_results[$class->promote_class] = $result->result();
						
					}
					
					
					
			/*		$all_results = array(); 
		 
		$query = "SELECT DISTINCT `class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		
		foreach($classes as $class){
				$query = "SELECT DISTINCT `section` FROM `results` WHERE class = '".$class->class."'";
				$result = $this->db->query($query);
				$sections = $result->result();
				foreach($sections as $section){
					//get class  / section wise resutl 
					$query ="SELECT * FROM results WHERE class = '".$class->class."' AND section = '".$section->section."' LIMIT 3";
					$result = $this->db->query($query);
					
					$all_results[$class->class][$section->section] = $result->result();
						
					}*/
			
			//}
		 
		
		$this->data["all_results"] = $all_results;
		 $this->data["title"] = $this->lang->line('Results');
		$this->data["view"] = ADMIN_DIR."results/student_class";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		// $this->load->view(ADMIN_DIR."results/print_result", $this->data);
		 
		 
		 
		 }
	 
	 
	 
	 
	 
	 public function print_result(){
		 
		$all_results = array(); 
		 
		$query = "SELECT DISTINCT `class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		
		foreach($classes as $class){
				
					//get class  / section wise resutl 
					$query ="SELECT * FROM results WHERE class = '".$class->class."' LIMIT 3";
					$result = $this->db->query($query);
					
					$all_results[$class->class] = $result->result();
						
					}
					
					
					
			/*		$all_results = array(); 
		 
		$query = "SELECT DISTINCT `class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		
		foreach($classes as $class){
				$query = "SELECT DISTINCT `section` FROM `results` WHERE class = '".$class->class."'";
				$result = $this->db->query($query);
				$sections = $result->result();
				foreach($sections as $section){
					//get class  / section wise resutl 
					$query ="SELECT * FROM results WHERE class = '".$class->class."' AND section = '".$section->section."' LIMIT 3";
					$result = $this->db->query($query);
					
					$all_results[$class->class][$section->section] = $result->result();
						
					}*/
			
			//}
		 
		
		$this->data["all_results"] = $all_results;
		 $this->data["title"] = $this->lang->line('Results');
		$this->data["view"] = ADMIN_DIR."results/print_result";
		$this->load->view(ADMIN_DIR."layout", $this->data);
		// $this->load->view(ADMIN_DIR."results/print_result", $this->data);
		 }
	 
    public function view(){
		
		
		
		/*$query ="SELECT 
						  AVG(`percentage`) as avg,
						  MIN(`percentage`) as min,
						  MAX(`percentage`) as max
						 FROM `results` ";
				$result = $this->db->query($query);
				$reports = $result->result()[0];
				echo '<table border="1"><tr>
				<td>'.round($reports->min,2)."</td>
				<td>".round($reports->avg,2)."</td>
				<td>".round($reports->max,2)."</td>
				</tr> </table>";
			
		
		
		exit();*/
		
		//get all class 
		$query = "SELECT DISTINCT `class` FROM `results`";
		$result = $this->db->query($query);
		$classes = $result->result();
		echo '<table border="1">';
		foreach($classes as $class){
		$query = "SELECT DISTINCT `section` FROM `results` WHERE class = '".$class->class."'";
		$result = $this->db->query($query);
		$sections = $result->result();
		
		echo '<tr> <td >Class</td><td>Section</td>
				<td>Fail</td>
				
				<td>Pass</td>
				<td>Total Students</td>
				</tr>
		';
		
			
			foreach($sections as $section){
			
			$query ="SELECT count(result_id) as total FROM `results` WHERE class = '".$class->class."' and section ='".$section->section."'";
			$total_students = $this->db->query($query);
			$total_student = $total_students->result()[0];
			
			$query ="SELECT count(result_id) as total FROM `results` where `percentage` <=15 AND class = '".$class->class."' and section ='".$section->section."'";
			$fail = $this->db->query($query);
				$fail = $fail->result()[0];
				
				$query ="SELECT count(result_id) as total FROM `results` where `percentage` >=15 AND class = '".$class->class."' and section ='".$section->section."'";
			$pass = $this->db->query($query);
				$pass = $pass->result()[0];
			//var_dump($reports);
			
			echo '<tr>
			<td>'.$class->class.'</td>
				<td>'.$section->section."</td>
				<td>".$fail->total."</td>
				
				<td>".$pass->total."</td>
				<td>".$total_student->total."</td>
				</tr>";
				
				/*$query ="SELECT 
						  AVG(`percentage`) as avg,
						  MIN(`percentage`) as min,
						  MAX(`percentage`) as max
						 FROM `results` WHERE class = '".$class->class."' and section ='".$section->section."'";
				$result = $this->db->query($query);
				$reports = $result->result()[0];
				echo '<tr>
				<td>'.$section->section."</td>
				<td>".round($reports->min,2)."</td>
				<td>".round($reports->avg,2)."</td>
				<td>".round($reports->max,2)."</td>
				</tr>";*/
				//var_dump($reports);		 
				}
		}
	
		echo "</table>";
		//var_dump($classes);
		exit();
		
        $where = "`results`.`status` IN (0, 1) ";
		$this->data["results"] = $this->result_model->get_result_list($where, FALSE, FALSE);
		// $this->data["results"] = $data->results;
		// $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Results');
		$this->data["view"] = ADMIN_DIR."results/results";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_result($result_id){
        
        $result_id = (int) $result_id;
        
        $this->data["results"] = $this->result_model->get_result($result_id);
        $this->data["title"] = $this->lang->line('Result Details');
		$this->data["view"] = ADMIN_DIR."results/view_result";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`results`.`status` IN (2) ";
		$data = $this->result_model->get_result_list($where);
		 $this->data["results"] = $data->results;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Results');
		$this->data["view"] = ADMIN_DIR."results/trashed_results";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($result_id, $page_id = NULL){
        
        $result_id = (int) $result_id;
        
        
        $this->result_model->changeStatus($result_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."results/view/".$page_id);
    }
    
    /**
      * function to restor result from trash
      * @param $result_id integer
      */
     public function restore($result_id, $page_id = NULL){
        
        $result_id = (int) $result_id;
        
        
        $this->result_model->changeStatus($result_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."results/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft result from trash
      * @param $result_id integer
      */
     public function draft($result_id, $page_id = NULL){
        
        $result_id = (int) $result_id;
        
        
        $this->result_model->changeStatus($result_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."results/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish result from trash
      * @param $result_id integer
      */
     public function publish($result_id, $page_id = NULL){
        
        $result_id = (int) $result_id;
        
        
        $this->result_model->changeStatus($result_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."results/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Result
      * @param $result_id integer
      */
     public function delete($result_id, $page_id = NULL){
        
        $result_id = (int) $result_id;
        //$this->result_model->changeStatus($result_id, "3");
        
		$this->result_model->delete(array( 'result_id' => $result_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."results/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Result
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Result');$this->data["view"] = ADMIN_DIR."results/add_result";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->result_model->validate_form_data() === TRUE){
		  
		  $result_id = $this->result_model->save_data();
          if($result_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."results/edit/$result_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."results/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Result
      */
     public function edit($result_id){
		 $result_id = (int) $result_id;
        $this->data["result"] = $this->result_model->get($result_id);
		  
        $this->data["title"] = $this->lang->line('Edit Result');$this->data["view"] = ADMIN_DIR."results/edit_result";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($result_id){
		 
		 $result_id = (int) $result_id;
       
	   if($this->result_model->validate_form_data() === TRUE){
		  
		  $result_id = $this->result_model->update_data($result_id);
          if($result_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."results/edit/$result_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."results/edit/$result_id");
            }
        }else{
			$this->edit($result_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["results"] = $this->result_model->getBy($where, false, "result_id" );
				$j_array[]=array("id" => "", "value" => "result");
				foreach($data["results"] as $result ){
					$j_array[]=array("id" => $result->result_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
