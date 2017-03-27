<?php

class Roupas{


	static function adj_tamP(){
		return Adjetivo::create(['singular_m' => 'P', 'singular_f'=>'P', 'plural_m'=>'P','plural_f'=>'P']);		
	}

	static function adj_tamM(){
		return Adjetivo::create(['singular_m' => 'M', 'singular_f'=>'M', 'plural_m'=>'M','plural_f'=>'M']);
	}

	static function adj_tamG(){
		return Adjetivo::create(['singular_m' => 'G', 'singular_f'=>'G', 'plural_m'=>'G','plural_f'=>'G']);
	}

	static function adj_tamCurto(){
		return Adjetivo::create(['singular_m' => 'curto', 'singular_f'=>'curta','plural_m'=>'curtos','plural_f'=>'curtas']);
	}

	static function adj_tamLongo(){
		return Adjetivo::create(['singular_m' => 'comprido', 'singular_f'=>'comprida','plural_m'=>'compridos','plural_f'=>'compridas']);
	}

	static function poss_ser_longo_ou_curto(){
		return Possibilidade::create([
			'singular' => '#coisa (é) #valor',
			'plural' => '#coisa (são) #valor',
			'unifica' => '#coisa #valor',
			'tipo' => 'adjetivo',
			'valores' => [self::adj_tamCurto(), self::adj_tamLongo()]
		]);
	}

	static function poss_custar_preco($min=20,$max=300,$step=5){
		return Possibilidade::create([
			'singular' => '#coisa (custa) #valor',
			'plural' => '#coisa (custam) #valor',
			'unifica' => '#coisa que (custa) #valor|#coisa de #valor',
			'tipo' => 'numero',
			'valores' =>Numero::createRange(['min'=>$min,'max'=>$max,'step'=>$step,'sufixo'=>' reais'])
		]);
	}

	static function poss_ser_de_manga_longa_ou_curta(){
		return Possibilidade::create([
			'singular' => '#coisa (é) de manga #valor_sf',
			'plural' => '#coisa (são) de manga #valor_sf',
			'unifica' => '#coisa de manga #valor_sf',
			'tipo' => 'adjetivo',
			'valores' => [self::adj_tamCurto(), self::adj_tamLongo()]
		]);
	}

	static function poss_ser_de_tamanho_P_M_ou_G(){
		return Possibilidade::create([
			'singular' => '#coisa (é) de tamanho #valor',
			'plural' => '#coisa (possuem) tamanhos #valor',
			'unifica' => '#coisa tamanho #valor|#coisa #valor',
			'tipo' => 'adjetivo',
			'valores' => [self::adj_tamP(),self::adj_tamM(),self::adj_tamG()]
		]);		
	}

	static function poss_ser_de_diferentes_textutras(){
		return Possibilidade::create([
			'singular' => '#coisa (é) #valor',
			'plural' => '#coisa (são) #valor',
			'unifica' => '#coisa #valor',
			'tipo' => 'adjetivo',
			'valores' => [
				Adjetivo::createCompact('de couro'),
				Adjetivo::createCompact('de borracha'),
				Adjetivo::createCompact('de material sintético'),
			]
		]);
	}

	static function subs_roupa_generica(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'roupa',
			'plural' => 'roupas',
			'possibilidades' => [
				self::poss_ser_de_tamanho_P_M_ou_G(), 
				self::poss_custar_preco(20, 300),
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_de_diferentes_textutras()->setValores([
					Adjetivo::createCompact('de lã'),
					Adjetivo::createCompact('de algodão'),
					Adjetivo::createCompact('de seda'),
					Adjetivo::createCompact('pólo'),
					Adjetivo::createCompact('de couro'),
					Adjetivo::createCompact('de borracha'),
					Adjetivo::createCompact('de material sintético'),

				])			
			],
		]);
	}

	static function subs_camiseta(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'camiseta',
			'plural' => 'camisetas',
			'possibilidades' => [
				self::poss_ser_de_tamanho_P_M_ou_G(), 
				self::poss_ser_de_manga_longa_ou_curta(), 
				self::poss_ser_longo_ou_curto(),
				self::poss_custar_preco(20,80),
				self::poss_ser_de_diferentes_textutras()->setValores([
					Adjetivo::createCompact('de lã'),
					Adjetivo::createCompact('de algodão'),
					Adjetivo::createCompact('de seda'),
					Adjetivo::createCompact('pólo'),
				]),
				Objetos::poss_ser_de_alguma_cor()
			]
		]);
	}

	static function subs_vestido(){
		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'vestido',
			'plural' => 'vestidos',
			'possibilidades' => [
				self::poss_ser_longo_ou_curto(),
				self::poss_custar_preco(120,400,10),
				Objetos::poss_ser_de_alguma_cor()
			]
		]);
	}

	static function subs_calça(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'calça',
			'plural' => 'calça',
			'possibilidades' => [
				self::poss_custar_preco(120,400,10),
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_de_diferentes_textutras()->setValores([
					Adjetivo::createCompact('jeans'),
					Adjetivo::createCompact('de moletom'),
					Adjetivo::createCompact('de abrigo'),
					Adjetivo::createCompact('de couro'),
					Adjetivo::createCompact('social')
				])
			]
		]);
	}

	static function subs_calça_social(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'calça social',
			'plural' => 'calças sociais',
			'possibilidades' => [
				self::poss_custar_preco(150,400,10),
				Objetos::poss_ser_de_alguma_cor(['preto','cinza','azul'])			]
		]);
	}

	static function subs_calção(){
		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'calção',
			'plural' => 'calção',
			'possibilidades' => [
				self::poss_custar_preco(30,90,10),
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_de_diferentes_textutras()->setValores([
					Adjetivo::createCompact('jeans'),
					Adjetivo::createCompact('de moletom'),
					Adjetivo::createCompact('de abrigo')

				])
			]
		]);
	}

	static function subs_shorts(){
		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'shorts',
			'plural' => 'shorts',
			'possibilidades' => [
				self::poss_custar_preco(50,100,10),
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_de_diferentes_textutras()->setValores([
					Adjetivo::createCompact('jeans'),
					Adjetivo::createCompact('de couro')
				])
			]
		]);
	}	

	static function subs_bota(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'bota',
			'plural' => 'botas',
			'possibilidade' => [
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_longo_ou_curto(),
				self::poss_custar_preco(120,400,10),
				self::poss_ser_de_diferentes_textutras()->addValor(
					Adjetivo::createCompact('de camurça')
				)
			]
		]);
	}

	static function subs_tenis(){
		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'tênis',
			'plural' => 'tênis',
			'possibilidade' => [
				self::poss_custar_preco(120,400,10),
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_de_diferentes_textutras()
			]
		]);
	}

	static function subs_chinelo(){
		return Substantivo::create([
			'genero' => 'M',
			'singular' => 'chinelo',
			'plural' => 'chinelos',
			'possibilidade' => [
				self::poss_custar_preco(20,50,10),
				Objetos::poss_ser_de_alguma_cor(),
				self::poss_ser_de_diferentes_textutras()
			]
		]);
	}

	static function subs_sandalha(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'sandalha',
			'plural' => 'sandalhas',
			'possibilidade' => [
				self::poss_custar_preco(50,150,10),
				Objetos::poss_ser_de_alguma_cor()
			]
		]);
	}

	static function subs_sapatilha(){
		return Substantivo::create([
			'genero' => 'F',
			'singular' => 'sapatilha',
			'plural' => 'sapatilhas',
			'possibilidade' => [
				self::poss_custar_preco(50,150,10),
				Objetos::poss_ser_de_alguma_cor()
			]
		]);
	}

	static function getRoupasDeBaixo($genero=null){

		$roupas = [
			self::subs_calção(),
		];

		if(rand(0,2)){
			$roupas[] = self::subs_calça();
		} else {
			$roupas[] = self::subs_calça_social();
		}

		if($genero!='M'){
			//$roupas[] = self::subs_vestido();
			//$roupas[] = self::subs_shorts();
		}

		return $roupas;

	}

	static function getRoupasDeCima($genero=null){
		$roupas = [
			self::subs_camiseta()
		];

		return $roupas;
	}

	static function getCalçados($genero=null){

		$calçados = [
			self::subs_tenis(),
			self::subs_chinelo(),
			self::subs_sandalha()
		];

		if($genero!='M'){
			$calçados[] = self::subs_bota();
			$calçados[] = self::subs_sapatilha();
		}

		return $calçados;

	}

}