<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class User_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "users";
        $this->pk = "user_id";
        $this->status = "status";
        $this->order = "order";
    }
    //----------------------------------------------------------------




}
