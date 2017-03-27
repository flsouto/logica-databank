<?php

function __autoload($class){
	require(__DIR__.'/'.$class.'.php');
}

error_reporting(E_ALL);

$inst = Databank::find(3, 2);


echo $inst->entidade_que_faz_itemX_da_propA_faz_itemX_da_propB(0,0,1).PHP_EOL;
echo $inst->entidade_que_faz_itemX_da_propA_nao_faz_itemY_da_propB(0,0,1,1).PHP_EOL;
echo $inst->cada_entidade_faz_uma_propA_diferente(0).PHP_EOL;