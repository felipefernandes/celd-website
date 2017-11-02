<?php 
	//que dia é hoje?
	//seleciona o ano, mês e o dia mais próximo com o dia de hoje

	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	date_default_timezone_set('America/Sao_Paulo');

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

?>

<section id="calendario" class="widget col-md-6 col-lg-6">
    <h3 class="titulo">Programação de <?php echo ( ($agora['semana'] === 1) || ($agora['semana'] === 3) || ($agora['semana'] === 6) ) ? "Amanhã" : "Hoje"; ?></h3>
    <h5 class="titulo-data">
    <?php echo $selecao['dia'] . " de " . mesPorExtenso($selecao['mes']) . " de " . idate('Y'); ?>
    </h5>
    
    <table class="programa">
        <tbody>
<?php 
		$args = array('post_type' => 'estudo', 
					  'meta_query' => array(
					  		'relation' => 'AND',
					  		array( 'key' => 'ano_referencia', 'value' => $selecao['ano'], 'compare' => '=' ),
					  		array( 'key' => 'mes_referencia', 'value' => $agora['mes'], 'compare' => '=' ),					  		
					  	));


		//s($args);

		$query_programa = new WP_Query($args);

		if ($query_programa->have_posts()):
		while($query_programa->have_posts()): $query_programa->the_post();

			$estudos = get_field('estudos');

			while( have_rows('estudos') ): the_row();

			if ( get_sub_field('estudo_dia') == $selecao['dia'] ) {

				$estudo_horario 	= get_sub_field('estudo_horario');

				$expositor_field = get_sub_field('estudo_expositor');

				foreach ( $expositor_field as $p ) {
					$estudo_expositor = get_the_title( $p->ID );
				}				
			
?>
            <tr>
                <td class="hora"><?php echo $estudo_horario; ?></td>
                <td class="palestrante"><?php echo $estudo_expositor ?></td>
            </tr>

<?php 
			/*the_title();*/

			}
			endwhile;
		endwhile;
		wp_reset_postdata();
		endif;
?>
        </tbody>                    
    </table>   
    
    <a href="<?php echo esc_url( home_url() ); ?>/programacao-doutrinaria/agenda-de-estudos/#<?php echo semanaPorExtenso($selecao['semana']) ?>" class="programacao-link">Veja a programação do mês</a>
</section><!-- /calendario -->