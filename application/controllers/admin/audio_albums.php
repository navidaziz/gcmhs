<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Audio_albums extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/audio_album_model");
		$this->lang->load("audio_albums", 'english');
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
		
        $where = "`audio_albums`.`status` IN (0, 1) ";
		$data = $this->audio_album_model->get_audio_album_list($where);
		 $this->data["audio_albums"] = $data->audio_albums;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Audio Albums');
		$this->data["view"] = ADMIN_DIR."audio_albums/audio_albums";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_audio_album($audio_id){
        
        $audio_id = (int) $audio_id;
        
        $this->data["audio_albums"] = $this->audio_album_model->get_audio_album($audio_id);
        $this->data["title"] = $this->lang->line('Audio Album Details');
		$this->data["view"] = ADMIN_DIR."audio_albums/view_audio_album";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`audio_albums`.`status` IN (2) ";
		$data = $this->audio_album_model->get_audio_album_list($where);
		 $this->data["audio_albums"] = $data->audio_albums;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Audio Albums');
		$this->data["view"] = ADMIN_DIR."audio_albums/trashed_audio_albums";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->audio_album_model->changeStatus($audio_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."audio_albums/view/".$page_id);
    }
    
    /**
      * function to restor audio_album from trash
      * @param $audio_id integer
      */
     public function restore($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->audio_album_model->changeStatus($audio_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."audio_albums/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft audio_album from trash
      * @param $audio_id integer
      */
     public function draft($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->audio_album_model->changeStatus($audio_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."audio_albums/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish audio_album from trash
      * @param $audio_id integer
      */
     public function publish($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->audio_album_model->changeStatus($audio_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."audio_albums/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Audio_album
      * @param $audio_id integer
      */
     public function delete($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        //$this->audio_album_model->changeStatus($audio_id, "3");
        //Remove file....
						$audio_albums = $this->audio_album_model->get_audio_album($audio_id);
						$file_path = $audio_albums[0]->audio_album_image;
						$this->audio_album_model->delete_file($file_path);
		$this->audio_album_model->delete(array( 'audio_id' => $audio_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."audio_albums/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Audio_album
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Audio Album');$this->data["view"] = ADMIN_DIR."audio_albums/add_audio_album";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->audio_album_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("audio_album_image")){
                       $_POST['audio_album_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $audio_id = $this->audio_album_model->save_data();
          if($audio_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."audio_albums/edit/$audio_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."audio_albums/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Audio_album
      */
     public function edit($audio_id){
		 $audio_id = (int) $audio_id;
        $this->data["audio_album"] = $this->audio_album_model->get($audio_id);
		  
        $this->data["title"] = $this->lang->line('Edit Audio Album');$this->data["view"] = ADMIN_DIR."audio_albums/edit_audio_album";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($audio_id){
		 
		 $audio_id = (int) $audio_id;
       
	   if($this->audio_album_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("audio_album_image")){
                         $_POST["audio_album_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $audio_id = $this->audio_album_model->update_data($audio_id);
          if($audio_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."audio_albums/edit/$audio_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."audio_albums/edit/$audio_id");
            }
        }else{
			$this->edit($audio_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["audio_albums"] = $this->audio_album_model->getBy($where, false, "audio_id" );
				$j_array[]=array("id" => "", "value" => "audio_album");
				foreach($data["audio_albums"] as $audio_album ){
					$j_array[]=array("id" => $audio_album->audio_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
