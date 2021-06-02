<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Movies extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/movie_model");
		$this->lang->load("movies", 'english');
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
		
        $where = "`movies`.`status` IN (0, 1) ";
		$data = $this->movie_model->get_movie_list($where, FALSE, TRUE);
		 $this->data["movies"] = $data->movies;
		 //$this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Movies');
		$this->data["view"] = ADMIN_DIR."movies/movies";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_movie($movie_id){
        
        $movie_id = (int) $movie_id;
        
        $this->data["movies"] = $this->movie_model->get_movie($movie_id);
        $this->data["title"] = $this->lang->line('Movie Details');
		$this->data["view"] = ADMIN_DIR."movies/view_movie";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`movies`.`status` IN (2) ";
		$data = $this->movie_model->get_movie_list($where);
		 $this->data["movies"] = $data->movies;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Movies');
		$this->data["view"] = ADMIN_DIR."movies/trashed_movies";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($movie_id, $page_id = NULL){
        
        $movie_id = (int) $movie_id;
        
        
        $this->movie_model->changeStatus($movie_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."movies/view/".$page_id);
    }
    
    /**
      * function to restor movie from trash
      * @param $movie_id integer
      */
     public function restore($movie_id, $page_id = NULL){
        
        $movie_id = (int) $movie_id;
        
        
        $this->movie_model->changeStatus($movie_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."movies/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft movie from trash
      * @param $movie_id integer
      */
     public function draft($movie_id, $page_id = NULL){
        
        $movie_id = (int) $movie_id;
        
        
        $this->movie_model->changeStatus($movie_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."movies/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish movie from trash
      * @param $movie_id integer
      */
     public function publish($movie_id, $page_id = NULL){
        
        $movie_id = (int) $movie_id;
        
        
        $this->movie_model->changeStatus($movie_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."movies/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Movie
      * @param $movie_id integer
      */
     public function delete($movie_id, $page_id = NULL){
        
        $movie_id = (int) $movie_id;
        //$this->movie_model->changeStatus($movie_id, "3");
        
		$this->movie_model->delete(array( 'movie_id' => $movie_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."movies/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Movie
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Movie');$this->data["view"] = ADMIN_DIR."movies/add_movie";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->movie_model->validate_form_data() === TRUE){
		  
		  $movie_id = $this->movie_model->save_data();
          if($movie_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."movies/edit/$movie_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."movies/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Movie
      */
     public function edit($movie_id){
		 $movie_id = (int) $movie_id;
        $this->data["movie"] = $this->movie_model->get($movie_id);
		  
        $this->data["title"] = $this->lang->line('Edit Movie');$this->data["view"] = ADMIN_DIR."movies/edit_movie";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($movie_id){
		 
		 $movie_id = (int) $movie_id;
       
	   if($this->movie_model->validate_form_data() === TRUE){
		  
		  $movie_id = $this->movie_model->update_data($movie_id);
          if($movie_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."movies/edit/$movie_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."movies/edit/$movie_id");
            }
        }else{
			$this->edit($movie_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["movies"] = $this->movie_model->getBy($where, false, "movie_id" );
				$j_array[]=array("id" => "", "value" => "movie");
				foreach($data["movies"] as $movie ){
					$j_array[]=array("id" => $movie->movie_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
