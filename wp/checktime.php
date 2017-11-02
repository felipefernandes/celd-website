<?php 

// set default timezone
date_default_timezone_set('America/Sao_Paulo'); // CDT

$current_date = date('d/m/Y == H:i:s');

echo $current_date;

/*
==========
*/

/* Verifica se há uma querystring e atribui o valor para a busca */	
$agora = array( 'dia' => idate('d'), 
				'mes' => idate('m'),
				'ano' => idate('y'),
				'semana' => idate('w') + 1,
				'hora' => idate('H'),
				'min' => idate('i'),
			);

$selecao = array( 'dia' => idate('d'), 
				  'mes' => idate('m'),
				  'ano' => idate('y'),
				  'semana' => idate('w') + 1,
				  'hora' => idate('H'),
				  'min' => idate('i'),
			);

if ( ($agora['semana'] === 1) ) { $selecao['semana'] = 2; $selecao['dia'] = $agora['dia'] + 1; } // dom -> seg
if ( ($agora['semana'] === 3) ) { $selecao['semana'] = 4; $selecao['dia'] = $agora['dia'] + 1; } // ter -> qua
if ( ($agora['semana'] === 6) ) { $selecao['semana'] = 7; $selecao['dia'] = $agora['dia'] + 1; } // sex -> sab



var_dump($agora); 



var_dump($selecao);


?>