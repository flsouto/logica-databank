<?php

class Databank{

	static function getUniversos(){
		$universos = [Roupas::class, Pessoas::class];
		shuffle($universos);
		return $universos;
	}

	static function getMundos(){
		
		foreach(self::getUniversos() as $class){
			$r = new ReflectionClass($class);
			foreach($r->getMethods() as $method){
				if(substr($method->getName(),0,5)=='subs_'){
					$mundos[] = call_user_func([$class, $method->getName()]);
				}
			}
		}

		shuffle($mundos);

		return $mundos;

	}

	static function render($template, Substantivo $subs, $valor){

		$text = explode('|',$template);
		shuffle($text);
		$text = current($text);

		$text = str_replace('#entidade',$subs->singular, $text);
		$text = str_replace('#coisa', $subs->singular, $text);

		if($valor instanceof Adjetivo){

			$text = str_replace('#valor_sm',$valor->singular_m, $text);
			$text = str_replace('#valor_pm',$valor->plural_m, $text);
			$text = str_replace('#valor_sf',$valor->singular_f, $text);
			$text = str_replace('#valor_pf',$valor->plural_f, $text);

			if($subs->genero=='M'){
				$text = str_replace('#valor', $valor->singular_m, $text);
			} else {
				$text = str_replace('#valor', $valor->singular_f, $text);
			}

		} else if($valor instanceof Substantivo) {

			$text = str_replace('#valor_s',$valor->singular, $text);
			$text = str_replace('#valor_p',$valor->plural, $text);
			$text = str_replace('#valor',$valor->singular, $text);
		
		} else if($valor instanceof Numero) {

			$text = str_replace('#valor', $valor->prefixo.$valor->valor.$valor->sufixo, $text);

		}

		$text = str_replace(['(',')'],'',$text);

		return $text;

	}

	static function unifica(Substantivo $subs, Possibilidade $poss, $valor){
		
		$text = self::render($poss->unifica, $subs, $valor);

		$clone = clone $subs;
		$clone->singular = $text;

		return $clone;

	}

	static function find($num_entities, $num_properties){

		foreach(self::getMundos() as $root){

			$possibilidades = $root->getPossibilidades();

			shuffle($possibilidades);

			$properties = [];

			foreach($possibilidades as $p){

				if($p->tipo=='substantivo'){			
					
					$valores = $p->getValores();
					shuffle($valores);

					if(rand(0,1) && count($valores)>=$num_entities){
						// Ex.: Marcelo possui um Carro, Maria possui uma Bicicleta, João possui uma Moto
						$clone = clone $p;
						$clone->setValores(array_slice($valores,0,$num_entities));
						$properties[] = $clone;
					} else {
						// Ex.: Marcelo possui um Carro Azul, Maria possui um Carro Verde, João possui um Carro Vermelho.
						foreach($valores as $valor){
							$possibilidades2 = $valor->getPossibilidades();
							shuffle($possibilidades2);
							foreach($possibilidades2 as $p2){
								$valores2 = $p2->getValores();
								if(count($valores2)>=$num_entities){
									shuffle($valores2);
									$valores3 = [];
									foreach(array_slice($valores2,0,$num_entities) as $valor2){
										$valores3[] = self::unifica($valor, $p2, $valor2);
									}
									$clone = clone $p;
									$clone->setValores($valores3);
									$properties[] = $clone;
									break 2;
								}
							}
						}
					}

				} else if($p->tipo=='adjetivo' || $p->tipo=='numero') {

					// Ex.: Pessoa gorda, Pessoa magra
					// Ou.: Pessoa de 20 anos, Pessoa de 40 anos, etc...

					$valores = $p->getValores();

					if(count($valores)>=$num_entities){

						shuffle($valores);

						$clone = clone $p;
						$clone->setValores(array_slice($valores,0,$num_entities));
						$properties[] = $clone;

					}

				}

				if(count($properties)==$num_properties){
					break 2;
				}

			}

		}

		shuffle($properties);

		if(count($properties)==$num_properties){
			return new DatabankInstance($root, $properties);
		}

		return false;


	}

}

class DatabankInstance{

	var $root;
	var $properties;

	function __construct(Substantivo $root, array $properties){
		$this->root = $root;
		$this->properties = $properties;
	}


	function entidade_que_faz_itemX_da_propA_faz_itemX_da_propB($itemX, $propA, $propB){

		if($propA==$propB){
			throw new \LogicException("Propriedade A e B não podem ser iguais");
		}

		foreach(['itemX','propA','propB'] as $k){
			$v = $$k;
			if(!ctype_digit("$v")){
				throw new \InvalidArgumentException("Parâmetro '$k' com valor inválido: $v. Só pode ser numérico.");
			}
		}

		if(!isset($this->properties[0]->getValores()[$itemX])){
			throw new \InvalidArgumentException("itemX inválido: $itemX. Só existem ".count($valores)." entidades.");
		}

		if(!isset($this->properties[$propA])){
			throw new \InvalidArgumentException("propA inválida: $propA. Só existem ".count($this->properties)." propriedades.");
		}

		if(!isset($this->properties[$propB])){
			throw new \InvalidArgumentException("propB inválida: $propB. Só existem ".count($this->properties)." propriedades.");
		}


		$entidade_que_faz_itemX_da_propA = Databank::unifica(
			$this->root, 
			$this->properties[$propA], 
			$this->properties[$propA]->getValores()[$itemX]
		);

		return Databank::render(
			$this->properties[$propB]->singular,
			$entidade_que_faz_itemX_da_propA,
			$this->properties[$propB]->getValores()[$itemX]
		);

	}


	function entidade_que_faz_itemX_da_propA_nao_faz_itemY_da_propB($itemX, $propA, $itemY, $propB){

		if($propA==$propB){
			throw new \LogicException("Propriedade A e B não podem ser iguais");
		}

		if($itemX==$itemY){
			throw new \LogicException("Propriedade A e B não podem ser iguais");
		}

		foreach(['itemX','propA','itemY','propB'] as $k){
			$v = $$k;
			if(!ctype_digit("$v")){
				throw new \InvalidArgumentException("Parâmetro '$k' com valor inválido: $v. Só pode ser numérico.");
			}
		}

		if(!isset($this->properties[0]->getValores()[$itemX])){
			throw new \InvalidArgumentException("itemX inválido: $itemX. Só existem ".count($valores)." entidades.");
		}

		if(!isset($this->properties[0]->getValores()[$itemY])){
			throw new \InvalidArgumentException("itemY inválido: $itemY. Só existem ".count($valores)." entidades.");
		}

		if(!isset($this->properties[$propA])){
			throw new \InvalidArgumentException("propA inválida: $propA. Só existem ".count($this->properties)." propriedades.");
		}

		if(!isset($this->properties[$propB])){
			throw new \InvalidArgumentException("propB inválida: $propB. Só existem ".count($this->properties)." propriedades.");
		}


		$entidade_que_faz_itemX_da_propA = Databank::unifica(
			$this->root, 
			$this->properties[$propA], 
			$this->properties[$propA]->getValores()[$itemX]
		);

		$entidade_que_faz_itemX_da_propA->singular .= ' não';

		return Databank::render(
			$this->properties[$propB]->singular,
			$entidade_que_faz_itemX_da_propA,
			$this->properties[$propB]->getValores()[$itemY]
		);

	}

	function cada_entidade_faz_uma_propA_diferente($propA){
		$text = 'cada '.$this->root->singular;
		$clone = clone $this->root;
		$clone->singular = $text;

		$p = $this->properties[$propA];

		if($p->tipo=='adjetivo'){
			$keys = ['singular_f','singular_m','plural_f','plural_m'];
			$main = $this->root->genero=='M' ? 'singular_m' : 'singular_f';
		} else if($p->tipo=='substantivo'){
			$keys = ['singular','plural'];
			$main = 'singular';
		} else { // numero
			$keys = ['valor'];
			$main = 'valor';
		}

		$valores_txt = '';
		$valores = [];

		foreach($p->getValores() as $v){
			$valores[] = $v->$main;
		}

		$valores_txt = implode(', ', array_slice($valores, 0, count($valores)-1));
		$valores_txt.= ' ou '.$valores[count($valores)-1];

		$dummy = clone($p->getValores()[0]);

		foreach($keys as $k){
			$dummy->$k = $valores_txt;
		}

		return Databank::render($p->singular, $clone, $dummy);

	}


}



