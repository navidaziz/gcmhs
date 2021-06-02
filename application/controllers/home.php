<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Home extends Public_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
		parent::__construct();
		}
	

    public function index(){
		echo '<div style="text-align:center; width:100%; padding-top: 50px;">
		<div  >
		<img style=" padding:10px;" src="http://gcmhsb.chitral.com.pk/assets/uploads/system_global_settings/9c9427b52d930a55c9a22fa3e63c633a.jpg" width="200" />
		</div>
		<h1>Welcome! we are working on GCMHS Boys Chitral Website.</h1> 
		<h3>if you are admin click  Admin to login. thanks.</h3>
		<a href="http://gcmhsb.chitral.com.pk/admin/users/login" > <h1 style="margin-top:10px"> Admin </h1> </a>
		</div>';
    }
  
    
}        
