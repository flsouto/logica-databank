<?php

class Adjetivo{

	var $singular_m;
	var $singular_f;
	var $plural_m;
	var $plural_f;

	protected function __construct(){}

	static function create(array $data){
		$obj = new self();
		foreach(['singular_m','singular_f','plural_m','plural_f'] as $k){
			if(!isset($data[$k])){
				throw new \InvalidArgumentException("Adjetivo requer a propriedade '$k' para ser criado.");
			}
			$obj->$k = $data[$k];
		}
		return $obj;
	}

	static function createCompact($string){
		$obj = new self();
		foreach(['singular_m','singular_f','plural_m','plural_f'] as $k){
			$obj->$k = $string;
		}
		return $obj;
	}

}
