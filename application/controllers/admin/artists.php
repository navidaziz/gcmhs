<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Artists extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/artist_model");
		$this->lang->load("artists", 'english');
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
		
        $where = "`artists`.`status` IN (0, 1) ";
		$data = $this->artist_model->get_artist_list($where);
		 $this->data["artists"] = $data->artists;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Artists');
		$this->data["view"] = ADMIN_DIR."artists/artists";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_artist($audio_id){
        
        $audio_id = (int) $audio_id;
        
        $this->data["artists"] = $this->artist_model->get_artist($audio_id);
        $this->data["title"] = $this->lang->line('Artist Details');
		$this->data["view"] = ADMIN_DIR."artists/view_artist";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`artists`.`status` IN (2) ";
		$data = $this->artist_model->get_artist_list($where);
		 $this->data["artists"] = $data->artists;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Artists');
		$this->data["view"] = ADMIN_DIR."artists/trashed_artists";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->artist_model->changeStatus($audio_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."artists/view/".$page_id);
    }
    
    /**
      * function to restor artist from trash
      * @param $audio_id integer
      */
     public function restore($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->artist_model->changeStatus($audio_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."artists/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft artist from trash
      * @param $audio_id integer
      */
     public function draft($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->artist_model->changeStatus($audio_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."artists/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish artist from trash
      * @param $audio_id integer
      */
     public function publish($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        
        
        $this->artist_model->changeStatus($audio_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."artists/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Artist
      * @param $audio_id integer
      */
     public function delete($audio_id, $page_id = NULL){
        
        $audio_id = (int) $audio_id;
        //$this->artist_model->changeStatus($audio_id, "3");
        //Remove file....
						$artists = $this->artist_model->get_artist($audio_id);
						$file_path = $artists[0]->artist_image;
						$this->artist_model->delete_file($file_path);
		$this->artist_model->delete(array( 'audio_id' => $audio_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."artists/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Artist
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Artist');$this->data["view"] = ADMIN_DIR."artists/add_artist";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->artist_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("artist_image")){
                       $_POST['artist_image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $audio_id = $this->artist_model->save_data();
          if($audio_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."artists/edit/$audio_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."artists/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Artist
      */
     public function edit($audio_id){
		 $audio_id = (int) $audio_id;
        $this->data["artist"] = $this->artist_model->get($audio_id);
		  
        $this->data["title"] = $this->lang->line('Edit Artist');$this->data["view"] = ADMIN_DIR."artists/edit_artist";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($audio_id){
		 
		 $audio_id = (int) $audio_id;
       
	   if($this->artist_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("artist_image")){
                         $_POST["artist_image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $audio_id = $this->artist_model->update_data($audio_id);
          if($audio_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."artists/edit/$audio_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."artists/edit/$audio_id");
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
				$data["artists"] = $this->artist_model->getBy($where, false, "audio_id" );
				$j_array[]=array("id" => "", "value" => "artist");
				foreach($data["artists"] as $artist ){
					$j_array[]=array("id" => $artist->audio_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
