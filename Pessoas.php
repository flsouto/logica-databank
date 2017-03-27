<?php

// pessoa > vestir > roupa de (cor,tamanho,preço) (x,y,z)
// pessoa > vestir > sapato de (cor, )

class Pessoas{


	static function poss_vestir_roupa(array $valores){

		return Possibilidade::create([
			'singular' => '#entidade (veste) #valor',
			'plural' => '#entidade (vestem) #valor',
			'unifica' => '#entidade que (veste) #valor',
			'inverte' => '#valor que #entidade (veste)',
			'tipo' => 'substantivo',
			'generico'=> Roupas::subs_roupa_generica(),
			'valores' => $valores
		]);

	}

	static function poss_ter_idade($min,$max){
		return Possibilidade::create([
			'singular' => '#entidade (tem) #valor',
			'plural' => '#entidade (tem) #valor',
			'unifica' => '#entidade que (tem) #valor',
			'tipo' => 'numero',
			'valores' => Numero::createRange(['min'=>$min,'max'=>$max,'sufixo'=>' anos de idade'])
		]);
	}

	static function get_nomes_femininos(){
		return ['Maria','Fernanda','Júlia','Roberta','Rogéria','Aline','Viviane','Lúcia'];
	}

	static function get_nomes_masculinos(){
		return ['Matheus','Rodrigo','Roberto','Pedro','João','Gustavo','Afonso','Evandro'];
	}

	static function poss_ter_nome($genero=null){

		$extend_names = function($genero, $names){
			$array = [];
			foreach($names as $name){
				$array []= Substantivo::create([
					'singular' => $name,
					'plural' => $name,
					'genero' => $genero
				]);
			}
			return $array;
		};

		$nomes = [];
		if($genero=='F'){
			$nomes = $extend_names('F',self::get_nomes_femininos());
		} else if($genero=='M'){
			$nomes = $extend_names('M',self::get_nomes_masculinos());
		} else {
			$nomes = array_merge(
				$extend_names('M',self::get_nomes_masculinos()), 
				$extend_names('F',self::get_nomes_femininos())
			);
		}

		return Possibilidade::create([
			'singular' => '#entidade se chama #valor',
			'plural' => '#entidade se chama #valor',
			'tipo' => 'substantivo',
			'unifica' => '#valor',
			'valores' => $nomes
		]);

	}

	static function poss_brincar($genero=null){

		$valores = [
			Adjetivo::createCompact('de desenhar'),
			Adjetivo::createCompact('de se esconder'),
			Adjetivo::createCompact('de corrida'),
			Adjetivo::createCompact('de amarelinha')
		];

		if($genero=='M'){
			$valores[] = Adjetivo::createCompact('de arminha');
			$valores[] = Adjetivo::createCompact('de lutinha');
		} else {
			$valores[] = Adjetivo::createCompact('de casinha');
			$valores[] = Adjetivo::createCompact('de comidinha');			
		}

		return Possibilidade::create([
			'singular' => '#entidade brinca #valor',
			'plural' => '#entidade brincam #valor',
			'tipo' => 'adjetivo',
			'unifica' => '#entidade que brinca #valor',
			'valores' => $valores
		]);
	}

	static function getPossibilidadeDeVestirRoupas($genero=null){
		switch(rand(1,4)){
			case 1 :
				return self::poss_vestir_roupa(
					Roupas::getCalçados($genero)
				);
			break;
			case 2 :
				return self::poss_vestir_roupa(
					Roupas::getRoupasDeBaixo($genero)
				);			
			break;
			case 3 :
				return self::poss_vestir_roupa(
					Roupas::getRoupasDeCima($genero)
				);
			break;
			case 4 :
				return self::poss_vestir_roupa(
					[Roupas::subs_roupa_generica()]
				);
			break;
		}
	}

	static function subs_adulto(){

		$possibilidades = [
			self::poss_ter_idade(18,48),
			self::poss_ter_nome()
		];

		$possibilidades[] = self::getPossibilidadeDeVestirRoupas();

		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'pessoa',
			'plural' => 'pessoas',
			'possibilidades' => $possibilidades
		]);

	}

	static function subs_mulheres(){

		$possibilidades = [
			self::poss_ter_idade(18,48),
			self::poss_ter_nome('F')
		];

		$possibilidades[] = self::getPossibilidadeDeVestirRoupas('F');

		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'mulher',
			'plural' => 'mulheres',
			'possibilidades' => $possibilidades
		]);

	}

	static function subs_homens(){

		$possibilidades = [
			self::poss_ter_idade(18,48),
			self::poss_ter_nome('M')
		];

		$possibilidades[] = self::getPossibilidadeDeVestirRoupas('M');

		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'homem',
			'plural' => 'homens',
			'possibilidades' => $possibilidades
		]);

	}

	static function subs_meninos(){

		$possibilidades = [
			self::poss_ter_idade(8,12),
			self::poss_ter_nome('M')
		];

		$possibilidades[] = self::getPossibilidadeDeVestirRoupas('M');
		$possibilidades[] = self::poss_brincar('M');

		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'menino',
			'plural' => 'meninos',
			'possibilidades' => $possibilidades
		]);

	}



	static function subs_meninas(){

		$possibilidades = [
			self::poss_ter_idade(8,12),
			self::poss_ter_nome('F')
		];

		$possibilidades[] = self::getPossibilidadeDeVestirRoupas('F');
		$possibilidades[] = self::poss_brincar('F');

		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'menina',
			'plural' => 'meninas',
			'possibilidades' => $possibilidades
		]);

	}

	static function subs_crianças(){

		$possibilidades = [
			self::poss_ter_idade(8,12),
			self::poss_ter_nome()
		];

		$possibilidades[] = self::getPossibilidadeDeVestirRoupas();
		$possibilidades[] = self::poss_brincar();

		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'criança',
			'plural' => 'crianças',
			'possibilidades' => $possibilidades
		]);

	}


}