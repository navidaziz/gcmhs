<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Mobile_demand_activites_or_stakeholders_meetings extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/mobile_demand_activites_or_stakeholders_meetings_model");
		$this->lang->load("mobile_demand_activites_or_stakeholders_meetings", 'english');
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
    public function view(){
		
        $where = "`mobile_demand_activites_or_stakeholders_meetings`.`status` IN (0, 1) ORDER BY `mobile_demand_activites_or_stakeholders_meetings`.`order`";
		$data = $this->mobile_demand_activites_or_stakeholders_meetings_model->get_mobile_demand_activites_or_stakeholders_meetings_list($where);
		 $this->data["mobile_demand_activites_or_stakeholders_meetings"] = $data->mobile_demand_activites_or_stakeholders_meetings;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Mobile Demand Activites Or Stakeholders Meetings');
		$this->data["view"] = ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/mobile_demand_activites_or_stakeholders_meetings";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_mobile_demand_activites_or_stakeholders_meetings($m_d_a_or_s_m_id){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
        $this->data["mobile_demand_activites_or_stakeholders_meetings"] = $this->mobile_demand_activites_or_stakeholders_meetings_model->get_mobile_demand_activites_or_stakeholders_meetings($m_d_a_or_s_m_id);
        $this->data["title"] = $this->lang->line('Mobile Demand Activites Or Stakeholders Meetings Details');
		$this->data["view"] = ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view_mobile_demand_activites_or_stakeholders_meetings";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`mobile_demand_activites_or_stakeholders_meetings`.`status` IN (2) ORDER BY `mobile_demand_activites_or_stakeholders_meetings`.`order`";
		$data = $this->mobile_demand_activites_or_stakeholders_meetings_model->get_mobile_demand_activites_or_stakeholders_meetings_list($where);
		 $this->data["mobile_demand_activites_or_stakeholders_meetings"] = $data->mobile_demand_activites_or_stakeholders_meetings;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Mobile Demand Activites Or Stakeholders Meetings');
		$this->data["view"] = ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/trashed_mobile_demand_activites_or_stakeholders_meetings";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
        
        $this->mobile_demand_activites_or_stakeholders_meetings_model->changeStatus($m_d_a_or_s_m_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
    }
    
    /**
      * function to restor mobile_demand_activites_or_stakeholders_meetings from trash
      * @param $m_d_a_or_s_m_id integer
      */
     public function restore($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
        
        $this->mobile_demand_activites_or_stakeholders_meetings_model->changeStatus($m_d_a_or_s_m_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft mobile_demand_activites_or_stakeholders_meetings from trash
      * @param $m_d_a_or_s_m_id integer
      */
     public function draft($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
        
        $this->mobile_demand_activites_or_stakeholders_meetings_model->changeStatus($m_d_a_or_s_m_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish mobile_demand_activites_or_stakeholders_meetings from trash
      * @param $m_d_a_or_s_m_id integer
      */
     public function publish($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
        
        $this->mobile_demand_activites_or_stakeholders_meetings_model->changeStatus($m_d_a_or_s_m_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Mobile_demand_activites_or_stakeholders_meetings
      * @param $m_d_a_or_s_m_id integer
      */
     public function delete($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        //$this->mobile_demand_activites_or_stakeholders_meetings_model->changeStatus($m_d_a_or_s_m_id, "3");
        
		$this->mobile_demand_activites_or_stakeholders_meetings_model->delete(array( 'm_d_a_or_s_m_id' => $m_d_a_or_s_m_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Mobile_demand_activites_or_stakeholders_meetings
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Mobile Demand Activites Or Stakeholders Meetings');$this->data["view"] = ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/add_mobile_demand_activites_or_stakeholders_meetings";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->mobile_demand_activites_or_stakeholders_meetings_model->validate_form_data() === TRUE){
		  
		  $m_d_a_or_s_m_id = $this->mobile_demand_activites_or_stakeholders_meetings_model->save_data();
          if($m_d_a_or_s_m_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/edit/$m_d_a_or_s_m_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Mobile_demand_activites_or_stakeholders_meetings
      */
     public function edit($m_d_a_or_s_m_id){
		 $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        $this->data["mobile_demand_activites_or_stakeholders_meetings"] = $this->mobile_demand_activites_or_stakeholders_meetings_model->get($m_d_a_or_s_m_id);
		  
        $this->data["title"] = $this->lang->line('Edit Mobile Demand Activites Or Stakeholders Meetings');$this->data["view"] = ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/edit_mobile_demand_activites_or_stakeholders_meetings";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($m_d_a_or_s_m_id){
		 
		 $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
       
	   if($this->mobile_demand_activites_or_stakeholders_meetings_model->validate_form_data() === TRUE){
		  
		  $m_d_a_or_s_m_id = $this->mobile_demand_activites_or_stakeholders_meetings_model->update_data($m_d_a_or_s_m_id);
          if($m_d_a_or_s_m_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/edit/$m_d_a_or_s_m_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/edit/$m_d_a_or_s_m_id");
            }
        }else{
			$this->edit($m_d_a_or_s_m_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $m_d_a_or_s_m_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
		//get order number of this record
        $this_mobile_demand_activites_or_stakeholders_meetings_where = "m_d_a_or_s_m_id = $m_d_a_or_s_m_id";
        $this_mobile_demand_activites_or_stakeholders_meetings = $this->mobile_demand_activites_or_stakeholders_meetings_model->getBy($this_mobile_demand_activites_or_stakeholders_meetings_where, true);
        $this_mobile_demand_activites_or_stakeholders_meetings_id = $m_d_a_or_s_m_id;
        $this_mobile_demand_activites_or_stakeholders_meetings_order = $this_mobile_demand_activites_or_stakeholders_meetings->order;
        
        
        //get order number of previous record
        $previous_mobile_demand_activites_or_stakeholders_meetings_where = "order <= $this_mobile_demand_activites_or_stakeholders_meetings_order AND m_d_a_or_s_m_id != $m_d_a_or_s_m_id ORDER BY `order` DESC";
        $previous_mobile_demand_activites_or_stakeholders_meetings = $this->mobile_demand_activites_or_stakeholders_meetings_model->getBy($previous_mobile_demand_activites_or_stakeholders_meetings_where, true);
        $previous_mobile_demand_activites_or_stakeholders_meetings_id = $previous_mobile_demand_activites_or_stakeholders_meetings->m_d_a_or_s_m_id;
        $previous_mobile_demand_activites_or_stakeholders_meetings_order = $previous_mobile_demand_activites_or_stakeholders_meetings->order;
        
        //if this is the first element
        if(!$previous_mobile_demand_activites_or_stakeholders_meetings_id){
            redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_mobile_demand_activites_or_stakeholders_meetings_inputs = array(
            "order" => $previous_mobile_demand_activites_or_stakeholders_meetings_order
        );
        $this->mobile_demand_activites_or_stakeholders_meetings_model->save($this_mobile_demand_activites_or_stakeholders_meetings_inputs, $this_mobile_demand_activites_or_stakeholders_meetings_id);
        
        $previous_mobile_demand_activites_or_stakeholders_meetings_inputs = array(
            "order" => $this_mobile_demand_activites_or_stakeholders_meetings_order
        );
        $this->mobile_demand_activites_or_stakeholders_meetings_model->save($previous_mobile_demand_activites_or_stakeholders_meetings_inputs, $previous_mobile_demand_activites_or_stakeholders_meetings_id);
        
        
        
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $m_d_a_or_s_m_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($m_d_a_or_s_m_id, $page_id = NULL){
        
        $m_d_a_or_s_m_id = (int) $m_d_a_or_s_m_id;
        
        
        
        //get order number of this record
         $this_mobile_demand_activites_or_stakeholders_meetings_where = "m_d_a_or_s_m_id = $m_d_a_or_s_m_id";
        $this_mobile_demand_activites_or_stakeholders_meetings = $this->mobile_demand_activites_or_stakeholders_meetings_model->getBy($this_mobile_demand_activites_or_stakeholders_meetings_where, true);
        $this_mobile_demand_activites_or_stakeholders_meetings_id = $m_d_a_or_s_m_id;
        $this_mobile_demand_activites_or_stakeholders_meetings_order = $this_mobile_demand_activites_or_stakeholders_meetings->order;
        
        
        //get order number of next record
		
        $next_mobile_demand_activites_or_stakeholders_meetings_where = "order >= $this_mobile_demand_activites_or_stakeholders_meetings_order and m_d_a_or_s_m_id != $m_d_a_or_s_m_id ORDER BY `order` ASC";
        $next_mobile_demand_activites_or_stakeholders_meetings = $this->mobile_demand_activites_or_stakeholders_meetings_model->getBy($next_mobile_demand_activites_or_stakeholders_meetings_where, true);
        $next_mobile_demand_activites_or_stakeholders_meetings_id = $next_mobile_demand_activites_or_stakeholders_meetings->m_d_a_or_s_m_id;
        $next_mobile_demand_activites_or_stakeholders_meetings_order = $next_mobile_demand_activites_or_stakeholders_meetings->order;
        
        //if this is the first element
        if(!$next_mobile_demand_activites_or_stakeholders_meetings_id){
            redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_mobile_demand_activites_or_stakeholders_meetings_inputs = array(
            "order" => $next_mobile_demand_activites_or_stakeholders_meetings_order
        );
        $this->mobile_demand_activites_or_stakeholders_meetings_model->save($this_mobile_demand_activites_or_stakeholders_meetings_inputs, $this_mobile_demand_activites_or_stakeholders_meetings_id);
        
        $next_mobile_demand_activites_or_stakeholders_meetings_inputs = array(
            "order" => $this_mobile_demand_activites_or_stakeholders_meetings_order
        );
        $this->mobile_demand_activites_or_stakeholders_meetings_model->save($next_mobile_demand_activites_or_stakeholders_meetings_inputs, $next_mobile_demand_activites_or_stakeholders_meetings_id);
        
        
        
        redirect(ADMIN_DIR."mobile_demand_activites_or_stakeholders_meetings/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["mobile_demand_activites_or_stakeholders_meetings"] = $this->mobile_demand_activites_or_stakeholders_meetings_model->getBy($where, false, "m_d_a_or_s_m_id" );
				$j_array[]=array("id" => "", "value" => "mobile_demand_activites_or_stakeholders_meetings");
				foreach($data["mobile_demand_activites_or_stakeholders_meetings"] as $mobile_demand_activites_or_stakeholders_meetings ){
					$j_array[]=array("id" => $mobile_demand_activites_or_stakeholders_meetings->m_d_a_or_s_m_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
