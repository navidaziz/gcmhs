<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Movie_genre_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "movie_genre";
        $this->pk = "movie_genre_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "movie_id",
                            "label"  =>  "Movie Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "gener_title",
                            "label"  =>  "Gener Title",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["movie_id"]  =  $this->input->post("movie_id");
                    
                    $inputs["gener_title"]  =  $this->input->post("gener_title");
                    
	return $this->movie_genre_model->save($inputs);
	}	 	

public function update_data($movie_genre_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["movie_id"]  =  $this->input->post("movie_id");
                    
                    $inputs["gener_title"]  =  $this->input->post("gener_title");
                    
	return $this->movie_genre_model->save($inputs, $movie_genre_id);
	}	
	
    //----------------------------------------------------------------
 public function get_movie_genre_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("movie_genre.*"
                , "movies.title"
            );
		$join_table = array(
            "movies" => "movies.movie_id = movie_genre.movie_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->movie_genre_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->movie_genre_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->movie_genre_model->joinGet($fields, "movie_genre", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->movie_genre = $this->movie_genre_model->joinGet($fields, "movie_genre", $join_table, $where);
			return $data;
		}else{
			return $this->movie_genre_model->joinGet($fields, "movie_genre", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_movie_genre($movie_genre_id){
	
		$fields = array("movie_genre.*"
                , "movies.title"
            );
		$join_table = array(
            "movies" => "movies.movie_id = movie_genre.movie_id",
        );
		$where = "movie_genre.movie_genre_id = $movie_genre_id";
		
		return $this->movie_genre_model->joinGet($fields, "movie_genre", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

