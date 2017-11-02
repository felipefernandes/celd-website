<?php 
/**
 *  Conteúdo Radio CELD
 *  @package CELD2015
 *  
 *
 */
?>

<?php
    if (isset($_GET['term_id'])) {
        $termID = $_GET['term_id'];        
    } 
    else {
        // get all terms in the taxonomy
        $terms = get_terms( 'galeria_categoria' ); 
        // convert array of term objects to array of term IDs
        $termID = wp_list_pluck( $terms, 'term_id' );
    }

    $args = array( 'post_type' => 'radio_celd', 
                   'tax_query' => array( 
                                    array('taxonomy' => 'galeria_categoria', 
                                          'field' => 'term_id',
                                          'terms' => $termID,
                                          'operator' => 'IN'))
                   );
    $query = new WP_Query( $args );

    while($query->have_posts()): $query->the_post();




?>
<div id="post-<?php the_ID(); ?>" <?php post_class('entry galeria-entry sonora '); ?>>

	<?php if(get_field('is_novo') == 'sim'): ?>
		<span class="label-novo"></span>
	<?php endif; ?>

	<div class="col-xs-12">
		<span class="cat"><?php echo get_the_term_list($post->ID, 'galeria_categoria','',', ',''); ?></span>

		<span class="data">publicado em <?php the_time('d F, Y'); ?></span>

		<div class="player">
			<audio autostart="0" controls>
				<source src="<?php the_field('sonora'); ?>" type="audio/mp3" />
				Infelizmente seu navegador não suporta este recurso.
			</audio>
		</div>

		<h5><?php the_title(); ?></h5>
	</div>
	<div class="col-xs-12 descricao">
		<div class="">
			<?php the_field('mini_descricao') ?>
		</div>	

		
	</div>
	<a href="#podcast-<?php the_ID(); ?>" class="btn btn_abre_descricao">
		<i class="glyphicon glyphicon-chevron-up"></i>
	</a>
    
    <div class="clearfix"></div>
</div>
<?php endwhile; ?>