<?php

class Substantivo{

	var $genero;
	var $singular;
	var $plural;

	protected $possibilidades = [];

	protected function __construct(){}

	static function create(array $data){
		$obj = new self;
		foreach(['genero','singular','plural'] as $k){
			if(!isset($data[$k])){
				throw new \InvalidArgumentException("Substantivo requer a propriedade '$k' para ser criado.");
			}
			$obj->$k = $data[$k];
		}
		$obj->genero = strtoupper($obj->genero);
		if(!in_array($obj->genero,['M','F'])){
			throw new \InvalidArgumentException("Valor inválido para o gênero: $genero. Use 'M' ou 'F'.");
		}		
		if(isset($data['possibilidades'])){
			$obj->setPossibilidades($data['possibilidades']);
		}
		return $obj;
	}

	function addPossibilidade(Possibilidade $p){
		$this->possibilidades[] = $p;
	}

	function getPossibilidades(){
		return $this->possibilidades;
	}

	function setPossibilidades($array){

		if(!is_array($array)){
			throw new \InvalidArgumentExceptions("As 'possibilidades' devem ser um array.");
		}

		$this->possibilidades = [];
		
		foreach($array as $p){

			if(!$p instanceof Possibilidade){
				throw new \InvalidArgumentException("As possibilidades de um substantivo devem ser instâncias da classe Possibilidade");
			}
			$this->possibilidades[] = $p;
		}

	}

}