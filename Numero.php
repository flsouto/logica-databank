<?php

class Numero{

	var $valor;
	var $prefixo;
	var $sufixo;


	protected function __construct(){}

	static function createRange(array $data){

		foreach(['min','max'] as $k){
			if(!isset($data[$k])){
				throw new \InvalidArgumentException("createRange requer parâmetro '$k'");
			}
		}

		$min = $data['min'];
		$max = $data['max'];

		if(isset($data['step'])){
			$step = $data['step'];
			if(!ctype_digit("$step")){
				throw new \InvalidArgumentException("Parâmetro 'step' deve ser um número.");
			}
		} else {
			$step = 1;
		}

		if(!ctype_digit("$min")){
			throw new \InvalidArgumentException("Valor mínimo deve ser um inteiro.");
		}
		if(!ctype_digit("$max")){
			throw new \InvalidArgumentException("Valor máximo deve ser um inteiro.");
		}

		if($min==$max){
			throw new \LogicException("Valor mínimo e máximo devem ser diferentes!");
		}

		if($min > $max){
			throw new \LogicException("Valor mínimo deve ser menor que valor máximo!");
		}

		$array = [];
		for($i=$min;$i<=$max;$i+=$step){
			$obj = new self;
			$obj->valor = $i;
			if(isset($data['prefixo'])){
				$obj->prefixo = $data['prefixo'];
			}
			if(isset($data['sufixo'])){
				$obj->sufixo = $data['sufixo'];
			}
			$array[] = $obj;
		}
		return $array;
	}

}