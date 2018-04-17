<?php

/*
** DbConnection Class
*/
namespace shorten\classes;

class DbConnection {

	private $creds;

	protected function __construct(){
		$this->creds = new \stdClass();
		$this->creds->name = DB_N;
		$this->creds->table = DB_T;
		$this->creds->host = DB_H;
		$this->creds->user = DB_U;
		$this->creds->pass = DB_P;

	}
	
	protected function getTable() {
		return $this->creds->table;
	}

	protected function getConnection() {
	    $dbh = new \PDO("mysql:host=".$this->creds->host.";dbname=".$this->creds->name, $this->creds->user, $this->creds->pass);
	    $dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	    return $dbh;
	}
}
