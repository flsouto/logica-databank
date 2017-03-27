<?php

class Objetos{

	static function adj_cor_preto(){
		return Adjetivo::create(['singular_m'=>'preto','singular_f'=>'preta','plural_m'=>'pretos','plural_f'=>'pretas']);
	}

	static function adj_cor_cinza(){
		return Adjetivo::create(['singular_m'=>'cinza','singular_f'=>'cinza','plural_m'=>'cinzas','plural_f'=>'cinzas']);
	}

	static function adj_cor_azul(){
		return Adjetivo::create(['singular_m'=>'azul','singular_f'=>'azul','plural_m'=>'azuis','plural_f'=>'azuis']);
	}

	static function adj_cor_vermelho(){
		return Adjetivo::create(['singular_m'=>'vermelho','singular_f'=>'vermelha','plural_m'=>'vermelhos','plural_f'=>'vermelhas']);
	}

	static function adj_cor_verde(){
		return Adjetivo::create(['singular_m'=>'verde','singular_f'=>'verde','plural_m'=>'verdes','plural_f'=>'verdes']);
	}

	static function adj_cor_amarelo(){
		return Adjetivo::create(['singular_m'=>'amarelo','singular_f'=>'amarela','plural_m'=>'amarelos','plural_f'=>'amarelas']);
	}

	static function poss_ser_de_alguma_cor($cores=['azul','vermelho','verde','amarelo','preto','cinza']){

		$valores = [];
		foreach($cores as $cor){
			$method = 'adj_cor_'.$cor;
			$valores[] = self::$method();
		}

		return Possibilidade::create([
			'singular' => '#coisa (é) de cor #valor_sf|#coisa (possui) cor #valor_sf|#coisa (é) #valor',
			'plural' => '#coisa (são) das cores #valor_pm|#coisa (possuem) as cores #valor_pm|#coisa (são) #valor',
			'unifica' => '#coisa #valor',
			'tipo' => 'adjetivo',
			'valores' => $valores
		]);
	}

	static function poss_ser_alguma_coisa(array $valores){
		return Possibilidade::create([
			'singular' => '#coisa (é) #um_valor',
			'plural' => '#coisa (são) #valor',
			'unifica' => '#valor',
			'tipo' => 'substantivo',
			'valores' => $valores
		]);
	}


}