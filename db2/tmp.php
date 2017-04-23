<?php


function generateData($qtde){

	$data = [
		'all' => $qtde,
		'A' => 0,
		'B' => 0,
		'A&&B' => 0,
		'A||B' => 0,
		'A-B' => 0,
		'B-A' => 0,
		'none' => 0
	];

	for($i=1;$i<=$qtde;$i++){
		$A = rand(0,1);
		$B = rand(0,1);
		if($A) $data['A']++;
		if($B) $data['B']++;
		if($A||$B) $data['A||B']++;
		if($A&&$B) $data['A&&B']++;
		if($A&&!$B) $data['A-B']++;
		if($B&&!$A) $data['B-A']++;
		if(!$B&&!$A) $data['none']++;
	}

	return $data;

}

$contextos = require 'db.php';

$contexto = $contextos[array_rand($contextos)];

shuffle($contexto['predicado']['valores']);
$contexto['predicado']['valores'] = array_combine(['A','B'],array_slice($contexto['predicado']['valores'],0,2));

$data = generateData(rand($contexto['range'][0],$contexto['range'][1]));

function describe($contexto, $data, $key){
	
	$qtde = $data[$key];
	$sujp = $contexto['sujeito']['plural'];

	$A_ = $contexto['predicado']['valores']['A'];
	$B_ = $contexto['predicado']['valores']['B'];

	$plural = $contexto['predicado']['plural'];

	if(stristr($plural,'#expr')){
		$plural_apenas = str_replace('#expr','apenas '.$contexto['predicado']['expr']['singular'],$plural);
		if(in_array($key,['A&&B','A||B'])){
			$plural = str_replace('#expr',$contexto['predicado']['expr']['plural'],$plural);
		} else {
			$plural = str_replace('#expr',$contexto['predicado']['expr']['singular'],$plural);
		}
	} else {
		$plural_apenas = str_replace('#val','apenas #val',$plural);
	}

	$A = str_replace('#val',$A_, $plural);
	$B = str_replace('#val',$B_, $plural);

	$A_e_B = str_replace('#val', "$A_ e $B_", $plural);
	$A_ou_B = str_replace('#val', "$A_ ou $B_", $plural);
	$A_not_B = str_replace('#val', "$A_", $plural_apenas);
	$B_not_A = str_replace('#val', "$B_", $plural_apenas);
	$none = 'não '.str_replace('#val',"$A_ nem $B_", $plural);

	switch($key){
		case 'all' :
			return "existe um total de $qtde $sujp";
		break;
		case 'A' :
			return "$qtde $sujp $A";
		break;
		case 'B' :
			return "$qtde $sujp $B";
		break;
		case 'A&&B' :
			return "$qtde $sujp $A_e_B";
		break;
		case 'A||B' :
			return "$qtde $sujp $A_ou_B";
		break;
		case 'A-B' :
			return "$qtde $sujp $A_not_B";
		break;
		case 'B-A' :
			return "$qtde $sujp $B_not_A";
		break;
		case 'none' :
			return "$qtde $sujp $none";
		break;

	}

}

if($contexto['genero']=='M'){
	echo "Num ";
} else {
	echo "Numa ";
}

$singular = explode('|',$contexto['singular']);
shuffle($singular);
$singular = current($singular);

echo $singular.' ';

$keys = array_keys($data);
shuffle($keys);
$keys = array_slice($keys,0,3);
if(($i=array_search('all',$keys))!==false){
	$first = 'all';
	unset($keys[$i]);
} else {
	$first = array_shift($keys);
}

echo describe($contexto, $data, $first).'. '.PHP_EOL;
foreach($keys as $key){
	echo ucfirst(describe($contexto, $data, array_shift($keys))).'. '.PHP_EOL;
}