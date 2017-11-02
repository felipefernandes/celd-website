<?php 
	//
	//recebe os argumentos da funcao hm_get_template_part
	//
	$semana = $template_args['semana'];
	$semana_extenso = semanaPorExtenso( $template_args['semana'] );

	$estudos = get_field('estudos');
	$i = 0;

	// MONTA UM ARRAY COM OS DIAS DISPONIVEIS + SEMANA + HORARIO
	while( have_rows('estudos') ): the_row();	

		foreach ($estudos as $estudo) {
			$estudos_dias_arr[] = array( 'dia' => $estudo['estudo_dia'],
										 'semana' => $estudo['estudo_dia_semana'],
										 'horario' => $estudo['estudo_horario'] 
									);
		}

		$i++;					

	endwhile;

	//remove as duplicadas do array
	$estudos_dias_arr = unique_multidim_array($estudos_dias_arr, 'dia');

?>
<div role="tabpanel" class="tab-pane fade in tab-semana" id="<?php echo $semana_extenso; ?>">
    <div class="calendario_dias">
    	<div class="container">
	    	<ul class="nav nav-tabs" role="tablist">
	    	<?php 
	    		$indice = 0;
	    		foreach ($estudos_dias_arr as $estudo_dia_busca):
			?>
    				<li role="presentation" <?php echo ($indice == 0) ? "class='active'" : "";  ?>>
    					<a href="#dia_<?php echo $estudo_dia_busca['dia']; ?>" role="tab" data-toggle="tab" data-semana="<?php echo 'semana_' . $estudo_dia_busca['semana']; ?>" data-dia="dia_<?php echo $estudo_dia_busca['dia']; ?>"><?php echo $estudo_dia_busca['dia']; ?></a>
    				</li>
	    	<?php
	    				$indice++;
	    		endforeach;
	    	?>
	    	</ul>
    	</div><!-- container -->
    </div><!-- calendario_dias -->

	<div class="calendario_conteudo">
		<div class="container">

	    	<div class="tab-content">
	    		<?php 
	    		$contador_dias = 0;
	    		$indice_estudos = 0;
	    		$historico_dia = 0;

				
				// PARA CADA DIA FAZ UMA BUSCA
				foreach ($estudos_dias_arr as $estudo_dia_busca):

					while( have_rows('estudos') ): the_row();
						/* 
							PARA ESTUDOS DO DIA 
						*/    					
    					if (get_sub_field('estudo_dia') == $estudo_dia_busca['dia']):

    						$dirigente_field = get_sub_field('estudo_dirigente');

							foreach ( $dirigente_field as $p ) {
								$dirigente = get_the_title( $p->ID );
							}

							$expositor_field = get_sub_field('estudo_expositor');

							foreach ( $expositor_field as $p ) {
								$expositor = get_the_title( $p->ID );
							}

							$comentarios_field = get_sub_field('estudo_comentario');

							if ( $comentarios_field ) {
								foreach ( $comentarios_field as $p ) {
									$comentarios = get_the_title( $p->ID );
								}	
							}

							/*
							// ***** DEBUG ****
							echo $estudo_dia_busca . "<br>";
							echo get_sub_field('estudo_horario') . "<br>";
							echo $dirigente . "<br>";
							echo $expositor . "<br>";*/
							?>

							<!-- #### DIA #### -->								    		
				    			<div id="<?php echo 'id_' . $indice_estudos; ?>" class="estudo_detalhe <?php echo "semana_" . $estudo_dia_busca['semana']; ?> <?php if ( get_sub_field('pagina_de_abertura') ) { echo 'has_pagina_abertura'; }  ?>" data-semana="<?php echo 'semana_' . $estudo_dia_busca['semana']; ?>" data-dia="dia_<?php echo $estudo_dia_busca['dia']; ?>">
				    				<div class="estudo_horario col-xs-12 col-sm-12 col-md-2 col-lg-2"><?php echo get_sub_field('estudo_horario'); ?></div>
				    				<div class="estudo_infos col-xs-12 col-sm-12 col-md-10 col-lg-10">
				    					<div class="estudo_tema"><strong><?php echo get_sub_field('estudo_tema'); ?></strong> <?php if (get_sub_field('estudo_exposicao')) { echo "( " . get_sub_field('estudo_exposicao') . " )"; } ?></div>
				    					<div class="estudo_mesa">
				    						<div class="estudo_dirigente col-xs-4">
				    							<span>Dirigente</span>
				    							<?php echo $dirigente; ?>
				    						</div>
				    						<div class="estudo_expositor col-xs-4">
				    							<span>Expositor</span>
				    							<?php echo $expositor; ?>
				    						</div>
				    						<div class="estudo_comentario col-xs-4">
				    							<span>Comentários</span>
				    							<?php echo $comentarios; ?>
				    						</div>
				    						<div class="clearfix"></div>
				    					</div>
				    					<?php if ( get_sub_field('pagina_de_abertura') ): ?>
				    					<div class="estudo_pagina_abertura estudo_tema">
				    						<small>Página de Abertura</small><br>
				    						<a class="titulo" href="<?php echo get_sub_field('pagina_de_abertura'); ?>" target="_blank">
				    							<?php echo get_sub_field('estudo_pag_abertura_titulo');  ?>
				    						</a>
				    					</div>
				    					<?php endif; ?>
				    				</div>
				    				<div class="clearfix"></div>
				    			</div>
							
							<!-- #### DIA * END #### -->
				<?php								
	    					endif;
							$indice_estudos++;	    				

	    			endwhile;

	    		endforeach;

	    		?>

    		</div><!-- tab-content -->
    	</div><!-- .container -->
	</div><!-- calendario_conteudo -->
</div><!-- tabpanel -->