<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Product_additional_informations extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/product_additional_information_model");
		$this->lang->load("product_additional_informations", 'english');
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
		
        $where = "`product_additional_informations`.`status` IN (0, 1) ORDER BY `product_additional_informations`.`order`";
		$data = $this->product_additional_information_model->get_product_additional_information_list($where);
		 $this->data["product_additional_informations"] = $data->product_additional_informations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Product Additional Informations');
		$this->data["view"] = ADMIN_DIR."product_additional_informations/product_additional_informations";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_product_additional_information($product_additional_information_id){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
        $this->data["product_additional_informations"] = $this->product_additional_information_model->get_product_additional_information($product_additional_information_id);
        $this->data["title"] = $this->lang->line('Product Additional Information Details');
		$this->data["view"] = ADMIN_DIR."product_additional_informations/view_product_additional_information";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`product_additional_informations`.`status` IN (2) ORDER BY `product_additional_informations`.`order`";
		$data = $this->product_additional_information_model->get_product_additional_information_list($where);
		 $this->data["product_additional_informations"] = $data->product_additional_informations;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Product Additional Informations');
		$this->data["view"] = ADMIN_DIR."product_additional_informations/trashed_product_additional_informations";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
        
        $this->product_additional_information_model->changeStatus($product_additional_information_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
    }
    
    /**
      * function to restor product_additional_information from trash
      * @param $product_additional_information_id integer
      */
     public function restore($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
        
        $this->product_additional_information_model->changeStatus($product_additional_information_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."product_additional_informations/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft product_additional_information from trash
      * @param $product_additional_information_id integer
      */
     public function draft($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
        
        $this->product_additional_information_model->changeStatus($product_additional_information_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish product_additional_information from trash
      * @param $product_additional_information_id integer
      */
     public function publish($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
        
        $this->product_additional_information_model->changeStatus($product_additional_information_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Product_additional_information
      * @param $product_additional_information_id integer
      */
     public function delete($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        //$this->product_additional_information_model->changeStatus($product_additional_information_id, "3");
        
		$this->product_additional_information_model->delete(array( 'product_additional_information_id' => $product_additional_information_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."product_additional_informations/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Product_additional_information
      */
     public function add(){
		
    $this->data["products"] = $this->product_additional_information_model->getList("PRODUCTS", "product_id", "product_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Product Additional Information');$this->data["view"] = ADMIN_DIR."product_additional_informations/add_product_additional_information";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->product_additional_information_model->validate_form_data() === TRUE){
		  
		  $product_additional_information_id = $this->product_additional_information_model->save_data();
          if($product_additional_information_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."product_additional_informations/edit/$product_additional_information_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_additional_informations/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Product_additional_information
      */
     public function edit($product_additional_information_id){
		 $product_additional_information_id = (int) $product_additional_information_id;
        $this->data["product_additional_information"] = $this->product_additional_information_model->get($product_additional_information_id);
		  
    $this->data["products"] = $this->product_additional_information_model->getList("PRODUCTS", "product_id", "product_title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Product Additional Information');$this->data["view"] = ADMIN_DIR."product_additional_informations/edit_product_additional_information";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($product_additional_information_id){
		 
		 $product_additional_information_id = (int) $product_additional_information_id;
       
	   if($this->product_additional_information_model->validate_form_data() === TRUE){
		  
		  $product_additional_information_id = $this->product_additional_information_model->update_data($product_additional_information_id);
          if($product_additional_information_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."product_additional_informations/edit/$product_additional_information_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."product_additional_informations/edit/$product_additional_information_id");
            }
        }else{
			$this->edit($product_additional_information_id);
			}
		 
		 }
	 
     
    /**
     * function to move a record up in list
     * @param $product_additional_information_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function up($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
		//get order number of this record
        $this_product_additional_information_where = "product_additional_information_id = $product_additional_information_id";
        $this_product_additional_information = $this->product_additional_information_model->getBy($this_product_additional_information_where, true);
        $this_product_additional_information_id = $product_additional_information_id;
        $this_product_additional_information_order = $this_product_additional_information->order;
        
        
        //get order number of previous record
        $previous_product_additional_information_where = "order <= $this_product_additional_information_order AND product_additional_information_id != $product_additional_information_id ORDER BY `order` DESC";
        $previous_product_additional_information = $this->product_additional_information_model->getBy($previous_product_additional_information_where, true);
        $previous_product_additional_information_id = $previous_product_additional_information->product_additional_information_id;
        $previous_product_additional_information_order = $previous_product_additional_information->order;
        
        //if this is the first element
        if(!$previous_product_additional_information_id){
            redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_product_additional_information_inputs = array(
            "order" => $previous_product_additional_information_order
        );
        $this->product_additional_information_model->save($this_product_additional_information_inputs, $this_product_additional_information_id);
        
        $previous_product_additional_information_inputs = array(
            "order" => $this_product_additional_information_order
        );
        $this->product_additional_information_model->save($previous_product_additional_information_inputs, $previous_product_additional_information_id);
        
        
        
        redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
    }
    //-------------------------------------------------------------------------------------
    
    /**
     * function to move a record up in list
     * @param $product_additional_information_id id of the record
     * @param $page_id id of the page to be redirected to
     */
    public function down($product_additional_information_id, $page_id = NULL){
        
        $product_additional_information_id = (int) $product_additional_information_id;
        
        
        
        //get order number of this record
         $this_product_additional_information_where = "product_additional_information_id = $product_additional_information_id";
        $this_product_additional_information = $this->product_additional_information_model->getBy($this_product_additional_information_where, true);
        $this_product_additional_information_id = $product_additional_information_id;
        $this_product_additional_information_order = $this_product_additional_information->order;
        
        
        //get order number of next record
		
        $next_product_additional_information_where = "order >= $this_product_additional_information_order and product_additional_information_id != $product_additional_information_id ORDER BY `order` ASC";
        $next_product_additional_information = $this->product_additional_information_model->getBy($next_product_additional_information_where, true);
        $next_product_additional_information_id = $next_product_additional_information->product_additional_information_id;
        $next_product_additional_information_order = $next_product_additional_information->order;
        
        //if this is the first element
        if(!$next_product_additional_information_id){
            redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
            exit;
        }
        
        
        //now swap the order
        $this_product_additional_information_inputs = array(
            "order" => $next_product_additional_information_order
        );
        $this->product_additional_information_model->save($this_product_additional_information_inputs, $this_product_additional_information_id);
        
        $next_product_additional_information_inputs = array(
            "order" => $this_product_additional_information_order
        );
        $this->product_additional_information_model->save($next_product_additional_information_inputs, $next_product_additional_information_id);
        
        
        
        redirect(ADMIN_DIR."product_additional_informations/view/".$page_id);
    }
    
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["product_additional_informations"] = $this->product_additional_information_model->getBy($where, false, "product_additional_information_id" );
				$j_array[]=array("id" => "", "value" => "product_additional_information");
				foreach($data["product_additional_informations"] as $product_additional_information ){
					$j_array[]=array("id" => $product_additional_information->product_additional_information_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
