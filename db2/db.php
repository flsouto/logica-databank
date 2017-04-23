<?php

$contextos = [];

$pessoas = [
	'singular' => 'pessoa',
	'plural' => 'pessoas',
	'genero' => 'F'
];

///////////////////////////////////////////////////////////////////////
// Laboratório de química

$contexto = [
	'singular' => 'laboratório',
	'genero' => 'M',
	'range' => [50,100]
];

$contexto['sujeito'] = [
	'singular' => 'componente químico',
	'plural' => 'componentes químicos',
	'genero' => 'M'
];

$contexto['predicado'] = [
	'singular' => 'possui #expr',
	'plural' => 'possuem #expr',
	'expr' => [
		'singular' => 'a propriedade #val',
		'plural' => 'as propriedades #val'
	],
	'valores' => range('A','Z')
];

$contextos[] = $contexto;

///////////////////////////////////////////////////////////////////////////////////////////////////
// Escola, alunos e disciplinas

$disciplinas = ['português','matemática','física','história','inglês','geografia','química'];

$estudar_disciplinas = [
	'singular' => 'estuda #val',
	'plural' => 'estudam #val',
	'valores' => $disciplinas
];

$alunos = [
	'singular' => 'aluno',
	'plural' => 'alunos',
	'genero' => 'M'
];

$contextos[] = [
	'singular' => 'escola|universidade|faculdade',
	'genero' => 'F',
	'sujeito' => $alunos,
	'range' => [300,1000],
	'predicado' => $estudar_disciplinas
];

$contextos[] = [
	'singular' => 'sala|classe',
	'genero' => 'F',
	'sujeito' => $alunos,
	'range' => [20,50],
	'predicado' => $estudar_disciplinas
];

$contextos[] = [
	'singular' => 'escola|universidade|faculdade',
	'genero' => 'F',
	'sujeito' => $alunos,
	'range'=>[300,1000],
	'predicado' => [
		'singular' => 'estuda #expr',
		'plural' => 'estudam #expr',
		'expr' => [
			'singular' => 'no turno #val',
			'plural' => 'nos turnos #val'
		],
		'valores' => ['da manhã','da tarde','da noite']
	]
];

////////////////////////////////////////////////////////////////////////////////////
// Falar diferentes línguas

$linguas = ['inglês','espanhol','chinês','italiano','russo','francês','alemão','suéco','dinamarquês'];
$falar_linguas = [
	'singular' => 'fala #val',
	'plural' => 'falam #val',
	'valores' => $linguas
];

$contextos[] = [
	'singular' => 'grupo de turistas',
	'genero' => 'M',
	'sujeito' => $pessoas,
	'range' => [12,60],
	'predicado' => $falar_linguas
];

$contextos[] = [
	'singular' => 'multinacional',
	'genero' => 'F',
	'sujeito' => ['singular'=>'funcionário','plural'=>'funcionários','genero'=>'M'],
	'range' => [100,500],
	'predicado' => $falar_linguas
];

$contextos[] = [
	'singular' => 'organização',
	'genero' => 'F',
	'sujeito' => $pessoas,
	'range' => [100,500],
	'predicado' => $falar_linguas
];

return $contextos;