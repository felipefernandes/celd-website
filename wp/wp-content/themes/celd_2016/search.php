<?php 
/**
 *  
 *  @package CELD2015
 *  Template name: Resultado de Busca
 *
 */
?>
<?php get_header(); ?>    

<div class="banner-pagina">    
</div>

<div class="header-pagina">
    <div class="container">
        <span class="glyphicon glyphicon-search"></span> Busca no site
    </div>
</div>


<div class="container pagina listagem_posts pagina_busca" id="page-noticias">

	<div class="page_intro">
		<h3>Você buscou <span class='chave'>'<?php printf( '%s', get_search_query() ); ?>'</span></h3>
	</div>

	<div class="resultados">

		<?php /* se for busca */ 

			while (have_posts()) : the_post();
		?>

		<?php /* FIM */ ?>

		<div class="row">		

			<section class="col-xs-12">   
				<a href="<?php the_permalink(); ?>" title="Link para <?php the_title(); ?>" id="post-<?php echo $post->ID; ?>" <?php post_class(); ?>>
					<h3><?php the_title(); ?></h3>
					<div class="resumo">
						<?php the_excerpt(); ?>
					</div>
				</a><!-- item -->
			</section>

		</div><!-- .row -->

	<?php endwhile; ?>

	</div><!-- resulatos -->

</div>

<?php get_footer(); ?>