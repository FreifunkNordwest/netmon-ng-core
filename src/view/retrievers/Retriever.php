<?php
error_reporting(E_ALL);
abstract class Retriever{
	protected $match;
	private $crawler_class;

	abstract public function retrieve();
    	
	public function __construct($profile) {
		//load a default-profile at first
		$this->crawler_class=get_called_class();
		$this->setMatch($profile);
	}
	
	protected function getMatch(){
		return $this->match;
	}

	protected function setMatch($m){
		//should be done by database
		if($cd!=NULL and is_string($cd) and file_exists(basename($cd.".json"))){
			$file=basename($cd.".json");		
    		}else{
			$file=$crawler_class."_default.json");
    		}
    		$this->match=json_decode(fread(fopen($file)),true);
	}
	
	public function print_crawl(){
		var_dump($this->match);
        }


}

class Nodewatcher extends Retriever{
	function retrieve(){
		//exec(alfred -s)
	}

}

?>
