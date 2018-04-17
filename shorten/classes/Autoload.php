<?php
	class Autoload {
		
		public static function find($className) {
			$className = str_replace("\\", DIRECTORY_SEPARATOR, $className) ;
			switch(true) {
				case is_readable($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $className . ".php") === true :
					require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $className . ".php";
					break;
				case is_readable($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "class." . strtolower($className) . ".php") === true :
					require $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "class." . strtolower($className) . ".php";
					break;
				default:
					error_log("Class file, '$className', not found, in ".$_SERVER['SCRIPT_FILENAME']);
			}
		}
		
	}
	
	spl_autoload_register('Autoload::find');