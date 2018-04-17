<?php

/*
** Shorten Class
*/
namespace shorten\classes;
 
class Shorten extends DbConnection {
	
	protected $chars;
	protected $charLen;
	protected $host;

	function __construct(){
		parent::__construct();
		$this->chars = USEABLE_CHARS;
		$this->charLen = strlen($this->chars);
		$this->host = $_SERVER['HTTP_HOST'];
		

	}

	private function addUrl($url){
		$sql = "INSERT INTO ".$this->getTable()." (url) VALUES (:url)";
		try {
			$this->db = $this->getConnection();
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam("url", $url);
			$stmt->execute();
			
			return $this->id($this->db->lastInsertId());
			die();
		} catch(\PDOException $e) {
			return false;
		}
		
	}

	private function checkString($str){
		
		// Returns true if string is only the allowed characters
		
		$regex = '/[^'.$this->chars.']+/';

		if(preg_match($regex, $str)){
			return false;
		}
		return true;
	}

	private function getId($str){	
		$id = 0;
		$pos = 0;
		$len = strlen($str);
		for($i = $len-1; $i>=0;$i--){
			$n = strpos($this->chars,$str[$i]);
			$toadd = ($n*pow(($this->charLen),$pos));
			$id = $id + $toadd;
			$pos++;
		}
		return $id;
	}

	private function validateUrl($url){
		return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
	}

	public function getUrl($str){
		if(!$this->checkString($str)){
			return false;
		}
		$id = $this->getId($str);
		$sql = "SELECT * FROM ".$this->getTable()." WHERE id=:id";
		try {
			$this->db = $this->getConnection();
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam("id", $id);
			$stmt->execute();
			$result = $stmt->fetchObject();

			if (isset($result) && $result->id >= 0) {
				return $result->url;
			} else {
				return 'This tiny URL does not exist.';
				exit();
			}
			
		} catch(\PDOException $e) {
			return false;
		}
		
	}
	

	public function id($id){
		$return = '';
		$calulating = true;
		while($calulating){
			$return = $this->chars[$id%$this->charLen] . $return;
			$id = floor($id/$this->charLen);
			if($id <= $this->charLen - 1){
				$return = $this->chars["$id"].$return;
				$calulating = false;
			}
		}
		return ltrim($return, $this->chars[0]);
	}

	
	public function url($url){
		if($this->validateUrl($url)){
			$id = $this->addUrl($url);
			if($id){
				return 'http://'.$this->host.'/'.$id;
			} else {
				return false;
			}
		} else {
			return 'Bad URL. A tiny URL could not be generated. Please try again.';
		}
	}



}
