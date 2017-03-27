<?php

class Possibilidade{
	
	var $singular;
	var $plural;
	var $unifica;
	var $generico;

	var $tipo;	

	protected $valores = [];

	protected function __construct(){}

	static function create(array $data){
		$obj = new self;
		foreach(['singular','plural','tipo'] as $k){
			if(!isset($data[$k])){
				throw new \InvalidArgumentException("Possibilidade requer '$k' para ser criada.");
			}
			$obj->$k = $data[$k];
		}

		if(!in_array($obj->tipo,['adjetivo','substantivo','numero'])){
			throw new \InvalidArgumentException("Tipo inválido: {$obj->tipo}. A propriedade 'tipo' só aceita 'adjetivo', 'substantivo' ou 'numero' como valor.");
		}
		if(isset($data['unifica'])){
			$obj->unifica = $data['unifica'];
		}

		if(isset($data['valores'])){
			$obj->setValores($data['valores']);
		}
		return $obj;
	}

	function addValor($valor){
		$map = [
			'substantivo' => 'Substantivo',
			'adjetivo' => 'Adjetivo',
			'numero' => 'Numero'
		];

		$class = $map[$this->tipo];

		if(!$valor instanceof $class){
			throw new \InvalidArgumentException("O valor da Possibilidade deve ser um objeto da classe $class");
		}

		$this->valores[] = $valor;
		return $this;
	}

	function setValores($valores){
		if(!is_array($valores)){
			throw new \InvalidArgumentException("Os valores da Possibildade devem ser um array.");
		}
		$this->valores = [];
		foreach($valores as $valor){
			$this->addValor($valor);
		}
		return $this;
	}

	function getValores(){
		return $this->valores;
	}
}
