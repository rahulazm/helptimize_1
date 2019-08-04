<?php

require_once("/etc/helptimize/conf.php");

/*-------------------

pre: mysqli installed, conf file passing configs to global variable $_configs
post:
a class to handle mysql calls
----------------------*/
class mysqlLib{

private $u;
private $p;
private $h;
private $db;
private $hndl;

	function __construct( $u, $p, $h, $db){

	$this->u=$u;
	$this->p=$p;
	$this->h=$h;
	$this->db=$db;

		$this->hndl = new mysqli($this->h, $this->u, $this->p, $this->db);
		if($this->hndl->connect_errno ){
		    die('Unable to connect to database [' . $this->hndl->connect_error . ']');
		}
		$this->hndl->set_charset('utf8');
	}


	function __destruct(){
	$this->hndl->close();
	}

	/*-----------------------------------
	pre: mysqli class, constructor ran
	post: results
	queries the db via the mysqli handle and returns the result
	-----------------------------------*/
	function query( $querystr){
		if(!$querystr){
		return null;
		}
	
	$rtrn=null;
	//$results=$this->hndl->query($this->hndl->escape_string($querystr));
	$results=$this->hndl->query($querystr);

		if(is_object($results)){
		$row=$results->fetch_assoc();
			while($row){
			$rtrn[]=$row;
			$row=$results->fetch_assoc();
			}
		$results->free();
		}
		else{
		$rtrn=$results;
		}
	
	return $rtrn;
	}

	/*---------------------------------
	pre: mysqli class and handle (basically 
	post: none
	calls the mysqi escape_string function
	-----------------------------------*/
	function escape($str){
		if(!$str){
		return null;
		}
	return $this->hndl->escape_string($str);
	}

	/*---------------------------------
	pre: mysqli class and handle (basically 
	post: none
	goes through the array and escapes any scalar values and returns the array
	-----------------------------------*/
	function escapeArr($arr){
		if(!is_array($arr)){
		return null;
		}
	$rtrnArr=$arr;
	$val=reset($rtrnArr);
	$i=key($rtrnArr);
		while($val){
			if(is_scalar($val)){
			$rtrnArr[$i]=$this->escape($val);
			}		

		$val=next($rtrnArr);
		$i=key($rtrnArr);
		}

	return $rtrnArr;
	}


	function error(){
	return $this->hndl->error;
	}


	//return lastId
	function lastId(){
	return $this->hndl->insert_id;
	}


}

$_sqlObj= new mysqlLib($_configs["username"], $_configs["password"], $_configs["host"], $_configs["db_name"]);

?>
