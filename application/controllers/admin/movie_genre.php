<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Movie_genre extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/movie_genre_model");
		$this->lang->load("movie_genre", 'english');
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
		
        $where = "`movie_genre`.`status` IN (0, 1) ";
		$data = $this->movie_genre_model->get_movie_genre_list($where);
		 $this->data["movie_genre"] = $data->movie_genre;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Movie Genre');
		$this->data["view"] = ADMIN_DIR."movie_genre/movie_genre";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_movie_genre($movie_genre_id){
        
        $movie_genre_id = (int) $movie_genre_id;
        
        $this->data["movie_genre"] = $this->movie_genre_model->get_movie_genre($movie_genre_id);
        $this->data["title"] = $this->lang->line('Movie Genre Details');
		$this->data["view"] = ADMIN_DIR."movie_genre/view_movie_genre";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`movie_genre`.`status` IN (2) ";
		$data = $this->movie_genre_model->get_movie_genre_list($where);
		 $this->data["movie_genre"] = $data->movie_genre;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Movie Genre');
		$this->data["view"] = ADMIN_DIR."movie_genre/trashed_movie_genre";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($movie_genre_id, $page_id = NULL){
        
        $movie_genre_id = (int) $movie_genre_id;
        
        
        $this->movie_genre_model->changeStatus($movie_genre_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."movie_genre/view/".$page_id);
    }
    
    /**
      * function to restor movie_genre from trash
      * @param $movie_genre_id integer
      */
     public function restore($movie_genre_id, $page_id = NULL){
        
        $movie_genre_id = (int) $movie_genre_id;
        
        
        $this->movie_genre_model->changeStatus($movie_genre_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."movie_genre/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft movie_genre from trash
      * @param $movie_genre_id integer
      */
     public function draft($movie_genre_id, $page_id = NULL){
        
        $movie_genre_id = (int) $movie_genre_id;
        
        
        $this->movie_genre_model->changeStatus($movie_genre_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."movie_genre/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish movie_genre from trash
      * @param $movie_genre_id integer
      */
     public function publish($movie_genre_id, $page_id = NULL){
        
        $movie_genre_id = (int) $movie_genre_id;
        
        
        $this->movie_genre_model->changeStatus($movie_genre_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."movie_genre/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Movie_genre
      * @param $movie_genre_id integer
      */
     public function delete($movie_genre_id, $page_id = NULL){
        
        $movie_genre_id = (int) $movie_genre_id;
        //$this->movie_genre_model->changeStatus($movie_genre_id, "3");
        
		$this->movie_genre_model->delete(array( 'movie_genre_id' => $movie_genre_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."movie_genre/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Movie_genre
      */
     public function add(){
		
    $this->data["movies"] = $this->movie_genre_model->getList("MOVIES", "movie_id", "title", $where ="");
    
        $this->data["title"] = $this->lang->line('Add New Movie Genre');$this->data["view"] = ADMIN_DIR."movie_genre/add_movie_genre";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->movie_genre_model->validate_form_data() === TRUE){
		  
		  $movie_genre_id = $this->movie_genre_model->save_data();
          if($movie_genre_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."movie_genre/edit/$movie_genre_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."movie_genre/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Movie_genre
      */
     public function edit($movie_genre_id){
		 $movie_genre_id = (int) $movie_genre_id;
        $this->data["movie_genre"] = $this->movie_genre_model->get($movie_genre_id);
		  
    $this->data["movies"] = $this->movie_genre_model->getList("MOVIES", "movie_id", "title", $where ="");
    
        $this->data["title"] = $this->lang->line('Edit Movie Genre');$this->data["view"] = ADMIN_DIR."movie_genre/edit_movie_genre";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($movie_genre_id){
		 
		 $movie_genre_id = (int) $movie_genre_id;
       
	   if($this->movie_genre_model->validate_form_data() === TRUE){
		  
		  $movie_genre_id = $this->movie_genre_model->update_data($movie_genre_id);
          if($movie_genre_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."movie_genre/edit/$movie_genre_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."movie_genre/edit/$movie_genre_id");
            }
        }else{
			$this->edit($movie_genre_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["movie_genre"] = $this->movie_genre_model->getBy($where, false, "movie_genre_id" );
				$j_array[]=array("id" => "", "value" => "movie_genre");
				foreach($data["movie_genre"] as $movie_genre ){
					$j_array[]=array("id" => $movie_genre->movie_genre_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
