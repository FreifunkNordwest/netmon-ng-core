<?php
	//require_once('../../../config/base_config.php');
	
	class Router {
		private $retrieved_data;
		
		public function __construct($r_id,$t_id,$rd) {
			$this->retrieved_data=$data;
			$this->retrieved_data['turn_id']=$t_id;
			$this->retrieved_data['retriever_id']=$r_id;
		}
		
		public function get_retrieved_data(){
			return $this->retrieved_data;
		}
		
		public function get_value($attr){
			return $retrieved_data[$attr];
		}
		
		public function set_value($attr,$val){
			$this->retrieved_data[$attr]=$val;
		}
		
		public function get_mysql_insert_line(){
		
		}
		
		
		public function fetch() {
			
		}
		
		public function store() {
			
		}
		
		

		/*
		public function setHostname($hostname) {
			//check for valid hostname as specified in rfc 1123
			//see http://stackoverflow.com/a/3824105
			$regex = "/^([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])(\.([a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]{0,61}[a-zA-Z0-9]))*$/";
			if(is_string($hostname) AND strlen($hostname)<=255 AND preg_match($regex, $hostname)) {
				$this->hostname = $hostname;
				return true;
			}
			return false;
		}*/
		

		

		

		

		
		

	}
?>