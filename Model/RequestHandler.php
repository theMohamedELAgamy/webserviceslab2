<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RestfulHelper
 *
 * @author webre
 */
class RequestHandler {
   
    public $__method;
    public $__parameters = array();
    public $__resource;
    public $__resource_id;
    public $__allowed_methods= array("GET","POST","DELETE","PUT");
    
    
    function get__method() {
        $method=$_SERVER['REQUEST_METHOD'];
        if (in_array($method,$this->__allowed_methods)){
            $this->__method= $method;
                return true;
        }else return false;
    }
        function parameters(){
            $this->__parameters=explode("/",$_SERVER["REQUEST_URI"]);
            return $this->__parameters;
        }
    

    function get__resource() {
        $this->__parameters=$parameters=explode("/",$_SERVER["REQUEST_URI"]);
        $this->__resource=(isset($parameters[3]))?$parameters[3]:"";
        return $this->__resource;
    }

    function get__resource_id() {
        $this->__parameters=$parameters=explode("/",$_SERVER["REQUEST_URI"]);
        $this->__resource_id=((isset($parameters[4]) )&&is_numeric($parameters[4]))?$parameters[4]:0;
        return $this->__resource_id;
    }

    
 

  

     //***********************************************************************************************************
    //this function should output or return the request elements (resource, method, parameters and resource id)
	//if $output is false the function should returns otherwise it should echo the response in JSON formats
	//***********************************************************************************************************
    public function scan(){
    
        if($this->validate()){
            dbhandler::connect();
        
            $record=dbhandler::get_record(intval($this->get__resource_id()));
            http_response_code(200);
            header('Content-Type:application/json');
            echo json_encode($record);
        }else {
            http_response_code(404); 
        }
        
    }
	//***********************************************************************************************************
    //this function should validate the request 
	//if $output is false the function should returns the result otherwise it should echo the results in JSON formats
	//$correct_resource : The resource which the service should accepts, "items" in this example. 
	//***********************************************************************************************************
    public function validate(){
        try{
        dbhandler::connect();
        $record=dbhandler::get_record(intval($this->get__resource_id()));
        $table=dbhandler::get_table($this->get__resource());
    
      if($table!=null && isset($table) && $record!=null && $this->get__method()) return true;
      else return false;
        }catch (Exception $e){
            return false;
        }
    }
    
    

}
