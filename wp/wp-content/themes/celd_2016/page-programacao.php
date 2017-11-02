<?php 
/**
 *  Agenda de Estudos  
 *
 *  @package CELD2015
 *  Template name: Programação
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="header-pagina">
    <div class="container">
        <span class="glyphicon glyphicon-calendar"></span> <?php ?><?php the_title(); ?>
    </div>
</div>

<div class="pagina" id="page-programacao">
    
	<?php /*get_template_part('content', 'programacao-agora'); */ ?>

	<div class="programacao-por-mes">
<?php 	
	/* Verifica se há uma querystring e atribui o valor para a busca */
    $mes_agora = (isset($_GET['mes'])) ? $_GET['mes'] : idate('m');
    $ano_agora = (isset($_GET['ano'])) ? $_GET['ano'] : idate('y');    
    
	$indice = 0;	
	$args = array('post_type' => 'estudo', 
				  'meta_query' => array(
				  		'relation' => 'AND',
				  		array( 'key' => 'ano_referencia', 'value' => $ano_agora, 'compare' => '=' ),
				  		array( 'key' => 'mes_referencia', 'value' => $mes_agora, 'compare' => '=' ),
				  	));
	$query = new WP_Query($args);


	if ($query->have_posts()):
	while($query->have_posts()): $query->the_post();
?>
	    <section id="<?php echo 'estudo_a' . get_field('ano_referencia') . 'm' . get_field('mes_referencia'); ?>" <?php post_class('conteudo'); ?>>       
		    <header class="programacao_grade">
		    	<div class="container">
			        <div class="row">
			        	<div class="col-xs-12">
			        		<h2>Confira toda a programação de <span><?php echo mesPorExtenso(get_field('mes_referencia')); ?> <?php echo '20' . $ano_agora; ?></span></h2>
						</div>
					</div>
				</div><!-- .container -->
			</header><!-- .heading programação -->

			<div class="calendario_header">
				<div class="container">
					<div class="row">
			        	<div class="col-xs-12 cabecalho">
			        		Clique nos dias para ver os detalhes:
			        	</div>
			        	<div class="col-xs-12">
			        		<!-- nav tabs -->
			        		<ul class="nav nav-tabs" role="tablist">
			        			<li role="presentation" class="active"><a href="#segunda" role="tab" data-toggle="tab" data-semana="semana_2" id="2">Segunda-feira</a></li>
			        			<li role="presentation" class=""><a href="#quarta" role="tab" data-toggle="tab" data-semana="semana_4" id="4">Quarta-feira</a></li>
			        			<li role="presentation" class=""><a href="#quinta" role="tab" data-toggle="tab" data-semana="semana_5" id="5">Quinta-feira</a></li>
			        			<li role="presentation" class=""><a href="#sabado" role="tab" data-toggle="tab" data-semana="semana_7" id="7">Sábado</a></li>
			        		</ul>
			        	</div><!-- .col-xs-12 -->
			    	</div><!-- .row -->
			    </div><!-- .container -->
		    </div><!-- .calendario_header -->

		    <div class="calendario_tabs">
		    	
		    		<!-- <div class="row"> -->
		        		<!-- Tab panes -->
					  	<div class="tab-content">
					  		<?php 				
					  			if ( get_field('estudos') ):

						  			$i = 0;
						  			$estudos_arr = array();
						  			$estudos = get_field('estudos');
						  			$estudos_dias_arr = array();

						  			while( have_rows('estudos') ): the_row();

						  				$semana = get_sub_field('estudo_dia_semana');
						  				$estudos_arr[$i]['semana'] = $semana;
						  				$estudos_arr[$i]['infos'] = array();

						  				foreach ($estudos as $estudo) {
						  					$estudos_dias_arr[] = $estudo['estudo_dia'];
						  				}

						  				$i++;
						  								  	
						  			endwhile;

									getTemplatePart('content', 'programacao-semana', array( 'semana' => 2 ));

					  			endif;
					  		?>
					  	</div><!-- .tab-content -->
						
					<!-- </div> -->

		        
			</div><!-- .calendario_tabs -->

	    </section>

		<script type="text/javascript">
			/* Habilita a primeiro item das tab panes SEMANA e DIA */
			$('.tab-semana:first-child').addClass('active');
			$('.tab-dia:first-child').addClass('active');
		</script>

<?php endwhile; ?>
<?php else: ?>

	<header class="programacao_grade">
    	<div class="container">
	        <div class="row">
	        	<div class="col-xs-12">
	        		<h2>Infelizmente não há agenda cadastrada para <span><?php echo mesPorExtenso($mes_agora); ?> <?php echo '20' . $ano_agora; ?></span></h2>
				</div>
			</div>
		</div><!-- .container -->

		<div class="dica">
			<div class="container">
	        	<div class="row">
	        		<div class="col-xs-12">
						<p>Experimente outro <strong>mês</strong> ou <strong>use os botões de navegação</strong> abaixo.</p>
					</div>
				</div>
			</div>
		</div>

	</header><!-- .heading programação -->

<?php endif; ?>

		<div id="nav-programacao" class="container">
			<div class="col-xs-12">
				<?php 
					$proximo_mes = esc_url( home_url() ) . '/agenda-de-estudos/?mes=' . ( $mes_agora + 1 ) . '&ano=' . $ano_agora;
					$anterior_mes = esc_url( home_url() ) . '/agenda-de-estudos/?mes=' . ( $mes_agora - 1 ) . '&ano=' . $ano_agora;
				?>		
				<a href="<?php echo $proximo_mes; ?>" class="nav-btn btn-prox">Próximo mês</a>
				<a href="<?php echo $anterior_mes; ?>" class="nav-btn btn-ante">Anterior mês</a>
			</div>		
		</div>


		<div class="clearfix"></div>
	</div><!-- programacao-por-mes -->
</div><!-- /.pagina -->  


<script type="text/javascript">
	
jQuery(document).ready(function($) {

	$('.calendario_header .nav li a').click(function() {	
		// filtra os dados por dia da semana (seg, quar, qui...)
		// seleciona os dias que tem mesma marcaçnao de semana
		var $ativo = null;
		var flag = true;

		dia_semana_referencia = $(this).data('semana');

		$('.calendario_dias .nav li a').each(function(index, el) {			
			if ($(this).data('semana') != dia_semana_referencia) {
				$(this).fadeOut('fast').parent().removeClass('active');
			} else {
				$(this).fadeIn('slow');

				if (flag) { $(this).click(); flag = false; }
			}
		});

		/* Exibe apenas os conteudos relaciondos com o click na semana 
		(ex. sabado, exibe apenas os conteudos cadastrados para sabdo) */
		$('.calendario_conteudo .estudo_detalhe').each(function(index, el) {

			if ($(this).data('semana') != dia_semana_referencia) {
				$(this).fadeOut('fast').parent().removeClass('active');
			}

		});

	});

	/* Filtra os conteúdos relacionados aos dias
	(ex. dia 03, exibe apenas os itens marcados como dia 03)
	*/
	$('.calendario_dias .nav li a').click(function() {

		dia_referencia = $(this).data('dia');

		$('.estudo_detalhe').each(function(index, el) {

			if ($(this).data('dia') != dia_referencia) {
				$(this).fadeOut('fast');
			} else {
				$(this).fadeIn('slow');
			}

		});

	});

	// INICIALIZA COM O PRIMEIRO ITEM CLICADO
	switch ( window.location.hash ) {

		case "#segunda" : $('.calendario_header .nav li a#2').click(); break;
		case "#quarta" 	: $('.calendario_header .nav li a#4').click(); break;
		case "#quinta" 	: $('.calendario_header .nav li a#5').click(); break;
		case "#sabado" 	: $('.calendario_header .nav li a#7').click(); break;

		default : $('.calendario_header .nav li a').first().click();
	}
	
});


</script>


<?php get_footer(); ?>
