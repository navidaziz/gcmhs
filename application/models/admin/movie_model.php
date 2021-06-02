<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Movie_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "movies";
        $this->pk = "movie_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "imdbID",
                            "label"  =>  "ImdbID",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "title",
                            "label"  =>  "Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "year",
                            "label"  =>  "Year",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "type",
                            "label"  =>  "Type",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "rating",
                            "label"  =>  "Rating",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "runtime",
                            "label"  =>  "Runtime",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "poster",
                            "label"  =>  "Poster",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "imdbURL",
                            "label"  =>  "ImdbURL",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "description",
                            "label"  =>  "Description",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "plot",
                            "label"  =>  "Plot",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "location",
                            "label"  =>  "Location",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["imdbID"]  =  $this->input->post("imdbID");
                    
                    $inputs["title"]  =  $this->input->post("title");
                    
                    $inputs["year"]  =  $this->input->post("year");
                    
                    $inputs["type"]  =  $this->input->post("type");
                    
                    $inputs["rating"]  =  $this->input->post("rating");
                    
                    $inputs["runtime"]  =  $this->input->post("runtime");
                    
                    $inputs["poster"]  =  $this->input->post("poster");
                    
                    $inputs["imdbURL"]  =  $this->input->post("imdbURL");
                    
                    $inputs["description"]  =  $this->input->post("description");
                    
                    $inputs["plot"]  =  $this->input->post("plot");
                    
                    $inputs["location"]  =  $this->input->post("location");
                    
	return $this->movie_model->save($inputs);
	}	 	

public function update_data($movie_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["imdbID"]  =  $this->input->post("imdbID");
                    
                    $inputs["title"]  =  $this->input->post("title");
                    
                    $inputs["year"]  =  $this->input->post("year");
                    
                    $inputs["type"]  =  $this->input->post("type");
                    
                    $inputs["rating"]  =  $this->input->post("rating");
                    
                    $inputs["runtime"]  =  $this->input->post("runtime");
                    
                    $inputs["poster"]  =  $this->input->post("poster");
                    
                    $inputs["imdbURL"]  =  $this->input->post("imdbURL");
                    
                    $inputs["description"]  =  $this->input->post("description");
                    
                    $inputs["plot"]  =  $this->input->post("plot");
                    
                    $inputs["location"]  =  $this->input->post("location");
                    
	return $this->movie_model->save($inputs, $movie_id);
	}	
	
    //----------------------------------------------------------------
 public function get_movie_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("movies.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->movie_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->movie_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->movie_model->joinGet($fields, "movies", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->movies = $this->movie_model->joinGet($fields, "movies", $join_table, $where);
			return $data;
		}else{
			
			return $this->movie_model->joinGet($fields, "movies", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_movie($movie_id){
	
		$fields = array("movies.*");
		$join_table = array();
		$where = "movies.movie_id = $movie_id";
		
		return $this->movie_model->joinGet($fields, "movies", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

