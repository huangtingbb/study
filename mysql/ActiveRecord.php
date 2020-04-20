<?php

abstract class ActiveRecord{
	protected static $table;
	protected $fieldValues;
	public $select;
	static function findById($id){
		$query="select * from ".static::$table."where id=$id";
	}

    function __get($field){
		return $this->fieldValues[$field];
	}

	static function __callStatic($method,$args){
		$field=preg_replace('/^findBy(\w*)$/','${1}',$method);
		$query="select * from ".static::$table."where $field='{$args[0]}'";
		return self::createDomain($query);
	}

	private static function createDomain($query){
		$clazz=get_called_class();
		$domain=new $clazz();
		$domain->fieldValues=[];
		$domain->select=$query;
		foreach($clazz::fields as $field=>$value){
			$domain->$fieldValues[$field]=$value;
		}
		return $domain;
	}



}
