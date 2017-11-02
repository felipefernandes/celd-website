<header id="programacao-agora">
	<div class="container">

<?php 
	//que dia é hoje?
	//seleciona o ano, mês e o dia mais próximo com o dia de hoje

	setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
	date_default_timezone_set('America/Sao_Paulo');

	/* Verifica se há uma querystring e atribui o valor para a busca */	
	$agora = array( 'dia' => 26, //idate('d'), 
					'mes' => idate('m'),
					'ano' => idate('y'),
					'semana' => 4, //idate('w') + 1,
					'hora' => 15, //idate('H'),
					'min' => 12, //idate('i'),
				);

	printf('agora->semana %s <br>', $agora['semana']);
	printf('agora->hora %s:%s <br>', $agora['hora'], $agora['min']);

	
	$args = array('post_type' => 'estudo',
				  'posts_per_page' => -1, 
				  'meta_query' => array(
				  		'relation' => 'AND',
				  		 array( 'key' => 'ano_referencia', 'value' => $agora['ano'], 'compare' => '=' ),
				  	 	 array( 'key' => 'mes_referencia', 'value' => $agora['mes'], 'compare' => '=' ),					  						  	 	 
				  	));
	$query = new WP_Query($args);

	while($query->have_posts()): $query->the_post();

	$estudo_id = 0;		
	$estudo_mes = get_field('mes_referencia');
	$estudo_ano = get_field('ano_referencia');

	$estudos_rows = get_field('estudos');
	$estudo_ids = array();
	$indice = 0;

	//busca todas as ocorrencias que do dia, e guarda os indices.
	foreach ($estudos_rows as $estudo) {
		if ($estudo['estudo_dia'] == $agora['dia']) {
			array_push($estudo_ids, $indice);
		}
		$indice++;
	}


	// Verifica se há mais uma ocorrencia de estudo por dia
	if ( count($estudo_ids) == 1 ) {

		/* atribui ao estudo_selected as informacoes sobre o estudo */
		$estudo_selected = $estudos_rows[ $estudo_ids[0] ];

		/* 
			recupero as principais infos dos campos 
		*/
		$dirigente_field = $estudo_selected['estudo_dirigente'];
		foreach ( $dirigente_field as $p ) { $dirigente = get_the_title( $p->ID ); }

		$expositor_field = $estudo_selected['estudo_expositor'];
		foreach ( $expositor_field as $p ) { $expositor = get_the_title( $p->ID ); }

		$comentarios_field = $estudo_selected['estudo_comentario'];
		if ( $comentarios_field ) {
			foreach ( $comentarios_field as $p ) { $comentarios = get_the_title( $p->ID ); }	
		}

		/*
			Dados para checar o intervalo entre palestras
		 
			Definição o fuso 
		*/
		$estudo_data_str = $estudo_ano .'-'. $estudo_mes .'-'. $estudo_selected['estudo_dia'] .' '. $estudo_selected['estudo_horario'];
		$estudo_data = strtotime( $estudo_data_str );

		$agora_fake = '2015-08-26 20:30';
		$agora = strtotime($agora_fake);
		/*$agora = date('Y-m-d H:i');	// VALENDO!!!!!! */	

		$hora_estudo = new DateTime( $estudo_data_str ); // formato: '2015-06-25 23:10'

		$dt_fim = new DateTime();
		$intervalo = $hora_estudo->diff($dt_fim);
?>

		<div id="estudo-<?php echo $estudo_id; ?>" class="bloco-infos-estudo">

			<div class="quando">
				<div class="hora"><?php echo date('H:i', $estudo_data) ?></div>
				<h2 class="data">Dia <?php echo date('d F \d\e Y', $estudo_data) ?></h2>
			</div>
			<div class="prox-estudo">

			<?php 
				// Exibe o horario da PROXIMA PALESTRA se o dia for hoje e não estiver no horario da palestra.
				if ( $intervalo->format("%d") == 0 && $intervalo->format("%h") != 0 ) {
					echo 'Próxima palestra às <a href="#" class="btn-prox-estudo">' . date('H:i', $estudo_data) . '</a>';
				}
			?>
							
			</div>

			<div class="palestrantes">
				<div class="palestrante col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<span class="posicao">Dirigente</span>
					<h3><?php echo $dirigente; ?></h3>
				</div>
				<div class="palestrante col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<span class="posicao">Expositor</span>
					<h3><?php echo $expositor; ?></h3>
				</div>
				<div class="palestrante col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<span class="posicao">Comentários</span>
					<h3><?php echo $comentarios; ?></h3>
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="infos row">
				<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
					<div class="tema-bloco">
						<div class="titulo col-xs-2">Tema: </div>
						<div class="titulo_descricao col-xs-10"><?php echo $estudo_selected['estudo_tema']; ?></div>
						<div class="clearfix"></div>
					</div>
					<div class="exposicao-bloco">
						<div class="titulo col-xs-2">Exposição: </div>
						<div class="titulo_descricao col-xs-10"><?php echo $estudo_selected['estudo_exposicao']; ?></div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

				<?php if ( $estudo_selected['pagina_de_abertura'] ): ?>

					<div class="pagina-abertura">							
						<a class="titulo" href="<?php echo $estudo_selected['pagina_de_abertura']; ?>" target="_blank">
							<span class="icone_download">
								<i class="glyphicon glyphicon-download"></i>
							</span>
							<div class="arquivo">
								<span>Página de abertura</span><br>
								<?php echo $estudo_selected['estudo_pag_abertura_titulo'];  ?>
							</div>
						</a>
						<div class="clearfix"></div>
					</div>

					<?php 
					/*
						Exibe o link de STREAMING (celd tv ao vivo)
						Se estiver no dia correto, e também
						Se estiver durante a HORA da palestra.
					*/
				        $streamingTime = checkStreamingTime( $agora['semana'], $agora['hora'], $agora['min'] );
					
						if ( $streamingTime ): 
					?>
					<div class="celd-tv">							
						<a class="titulo" href="<?php echo esc_url( home_url() ); ?>/estudos-espiritas/celd-tv/ao-vivo" target="_blank">
							<span class="icone_download">
								<i class="glyphicon glyphicon-film"></i>
							</span>
							<div class="titulo">
								<span>CELD <small>TV</small></span><br>
								Acompanhe ao vivo</div>
						</a>
						<div class="clearfix"></div>
					</div>
					<?php endif; ?>

				<?php endif; ?>
				</div>
			</div><!-- infos -->
			
		</div><!-- bloco info estudo --> 


<?php

	}
	/*
		Para no caso de haver mais de uma palestra por dia
		Identifica quais
		Exibe a com o horario mais próximo
	*/
	elseif ( count($estudo_ids) > 1 ) {
			
		$estudo_indice = 0;		

		/*
			definições temporais	
		*/
		$estudo_data_str = $estudo_ano .'-'. $estudo_mes .'-'. $estudo['estudo_dia'] .' '. $estudo['estudo_horario'];
		$estudo_data = strtotime( $estudo_data_str );

?>
		<div id="estudo-<?php echo $estudo_indice; ?>" class="bloco-infos-estudo estudo_multiplos">

			<div class="quando">
				<div class="hora"><?php echo date('H:i', $estudo_data) ?></div>
				<h2 class="data">Dia <?php echo date('d F \d\e Y', $estudo_data) ?></h2>
			</div>

<?php
		foreach ($estudos_rows as $estudo):

			$controle = 0;

			foreach ($estudo_ids as $id):

				$streamingTime = checkStreamingTime( $agora['semana'], $agora['hora'], $agora['min'] );

				if ($id == $estudo_indice):					
					/* 
						recupero as principais infos dos campos 
					*/
					$dirigente_field = $estudo['estudo_dirigente'];
					foreach ( $dirigente_field as $p ) { $dirigente = get_the_title( $p->ID ); }

					$expositor_field = $estudo['estudo_expositor'];
					foreach ( $expositor_field as $p ) { $expositor = get_the_title( $p->ID ); }

					$comentarios_field = $estudo['estudo_comentario'];
					if ( $comentarios_field ) {
						foreach ( $comentarios_field as $p ) { $comentarios = get_the_title( $p->ID ); }	
					}

?>					
				<div class="estudo_row">

					<div class="prox-estudo">

					<?php 
						// Exibe o horario da PROXIMA PALESTRA se o dia for hoje e 
						// não estiver no horario da palestra.							
						$horario = $estudo['estudo_horario'];								

						if ( checkProxEstudo($horario, $agora['semana']) !== NULL ) {
							printf('Próxima palestra às <a href="#" class="btn-prox-estudo">%s</a>', checkProxEstudo($horario, $agora['semana']));
						}
					?>
					</div><!-- proximo estudo -->

					<div class="palestrantes">
						<div class="palestrante col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<span class="posicao">Dirigente</span>
							<h3><?php echo $dirigente; ?></h3>
						</div>
						<div class="palestrante col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<span class="posicao">Expositor</span>
							<h3><?php echo $expositor; ?></h3>
						</div>
						<div class="palestrante col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<span class="posicao">Comentários</span>
							<h3><?php echo $comentarios; ?></h3>
						</div>
						<div class="clearfix"></div>
					</div><!-- palestrantes -->

					<div class="infos row">
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div class="tema-bloco">
								<div class="titulo col-xs-2">Tema: </div>
								<div class="titulo_descricao col-xs-10"><?php echo $estudo['estudo_tema']; ?></div>
								<div class="clearfix"></div>
							</div>
							<div class="exposicao-bloco">
								<div class="titulo col-xs-2">Exposição: </div>
								<div class="titulo_descricao col-xs-10"><?php echo $estudo['estudo_exposicao']; ?></div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

						<?php if ( $estudo['pagina_de_abertura'] ): ?>

							<div class="pagina-abertura">							
								<a class="titulo" href="<?php echo $estudo['pagina_de_abertura']; ?>" target="_blank">
									<span class="icone_download">
										<i class="glyphicon glyphicon-download"></i>
									</span>
									<div class="arquivo">
										<span>Página de abertura</span><br>
										<?php echo $estudo['estudo_pag_abertura_titulo'];  ?>
									</div>
								</a>
								<div class="clearfix"></div>
							</div>

							<?php 
							/*
								Exibe o link de STREAMING (celd tv ao vivo)
								Se estiver no dia correto, e também
								Se estiver durante a HORA da palestra.
							*/ 
						        $streamingTime = checkStreamingTime( $agora['semana'], $agora['hora'], $agora['min'] );
							
								if ( $streamingTime ): 
							?>
							<div class="celd-tv">							
								<a class="titulo" href="<?php echo esc_url( home_url() ); ?>/estudos-espiritas/celd-tv/ao-vivo" target="_blank">
									<span class="icone_download">
										<i class="glyphicon glyphicon-film"></i>
									</span>
									<div class="titulo">
										<span>CELD <small>TV</small></span><br>
										Acompanhe ao vivo</div>
								</a>
								<div class="clearfix"></div>
							</div>
							<?php endif; ?>

						<?php endif; ?>
						</div>
					</div><!-- infos -->

				</div>
<?php
				endif; //($id == $estudo_indice)
				$controle++;

			endforeach; //foreach ($estudo_ids as $id):		

			$estudo_indice++;
		endforeach;

?>
		</div><!-- bloco info estudo --> 		
<?php

	} 

	else {

		echo 'ou talvez..';

	}



	?>		

		<?php 
			$estudo_id++; 
			//endif; 
			//endwhile; //estudos (acf) ?>

	

	<?php endwhile; wp_reset_postdata(); ?>

	</div><!-- container -->

</header><!-- ./header -->

