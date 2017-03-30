<?php

$n_entities = 4;
$n_properties = 4;

$rows = [];
$letters = range('A','Z');

$lines []= 'all_diff(L) :- \+ (select(X,L,R), memberchk(X,R)).';
$lines []= 'solution(Result) :- ';

for($i=1;$i<=$n_entities;$i++){

	$row = [];

	for($j=1;$j<=$n_properties;$j++){
		$row[] = $letters[$j-1].$i;
	}

	$rows[] = '['.implode(',',$row).']';

}

$lines[]= "\tTable = [".implode(',',$rows).'],';


for($i=1;$i<=$n_properties;$i++){

	$values = [];

	for($j=1;$j<=$n_entities;$j++){
		$values[] = strtolower($letters[$i-1]).'v'.$j;
	}

	$L = $letters[$i-1];

	$lines [] = "\t".$L.'L = ['.implode(',',$values).'],';

	$vars = [];
	for($j=1;$j<=$n_entities;$j++){
		$lines[] = "\t"."member({$L}{$j}, {$L}L),";
		$vars[] = $L.$j;
	}

	$lines[] = "\t"."all_diff([".implode(",",$vars)."]),";

}

// generate premisses

$random_letter = function($not_letter='') use($n_properties){
	$letters = array_slice(range('a','z'), 0, $n_properties);
	shuffle($letters);
	
	do{
		$letter = array_pop($letters);
	} while($letter==$not_letter);

	return $letter;
};

$random_number = function($not_number=null) use($n_entities){
	$numbers = range(1,$n_entities);
	shuffle($numbers);
	do{
		$number = array_pop($numbers);
	} while($number==$not_number);
	return $number;
};

$tmp_var = function(){
	static $cnt=0;
	$cnt++;
	return 'Tmp'.$cnt;
};

$premisses = [];

while(count($premisses)<10){
	$p = [];
	$p['l1'] = $random_letter();
	$p['l2'] = $random_letter($p['l1']);
	$p['n1'] = $random_number();
	if(rand(0,2)){
		$p['n2'] = 0;
	} else {
		$p['n2'] = $random_number($p['n1']);
	}

	$hash = [$p['l1'],$p['l2'],$p['n1']];
	sort($hash);
	$hash = implode($hash);

	$premisses[$hash] = $p;
}

$letters = range('a','z');
foreach($premisses as $p){

	$row = [];

	for($i=1;$i<=$n_properties;$i++){
		$row[$letters[$i-1]] = '_';
	}
	$row[$p['l1']] = $p['l1'].'v'.$p['n1'];

	if($p['n2']){
		// negation
		$tmp = $tmp_var();
		$row[$p['l2']] = $tmp;
	} else {
		$row[$p['l2']] = $p['l2'].'v'.$p['n1'];
	}


	$line = "\t"."member([".implode(',',$row)."],Table),";
	if($p['n2']){
		$line .= $tmp.' \= '.$p['l2'].'v'.$p['n2'].',';
	}
	$lines[] = $line;
}
$lines[] = "\t".'sort(Table,Result).';
echo implode("\n",$lines);




