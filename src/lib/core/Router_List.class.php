<?php

	
	class Router_List {
		private $routers = array();
	
		public function __construct() {
	
		}
		
		public function get_router($mac){
			return $this->routers[$mac];
		}
		
		
		
		
		
		//if $overwrite==false only not still existent values are added
		public function add_router($r,$overwrite){
			if(is_object($r) and get_class($r)=='Router'){
				if($overwrite or !array_key_exists($r->get_value('mac_address'),$this->routers)){
					$this->routers[$r->get_value('mac_address')]=$r;
				}
			}
		}
		
		/**
		* adds a list of Routers to the current list; only adds those Routers which weren't available before
		* @param Router_List $rl The Router_List to be added	
		**/
		public function merge_router_list($rl){
			if(is_object($rl) and get_class($this)=get_class($rl){
				$rl=$rl->get_routers();
				foreach($rl as $r){
					$this->add_router($r);
				}
			}
			
		
		}
	
	
	}

?>