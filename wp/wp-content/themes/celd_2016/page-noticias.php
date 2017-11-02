<?php 
/**
 *  
 *  @package CELD2015
 *  Template name: Notícias (listagem)
 *
 */
?>
<?php get_header(); ?>  

<?php 
    if (have_posts()) {
        if(has_post_thumbnail()) {
            $banner_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large'  );
            echo '<div class="banner-post" style="background-image:url('. $banner_image_url[0] .')"></div>';
        } 
        else {
            echo '<div class="banner-pagina" ></div>';
        }        
    } 
?>

<div id="noticias-page" class="container post">
	<div class="row">
        
    <div class="list_box col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <div class="row">

<?php 
    $count = 0;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array( 'post_type' => 'post', 'category__not_in' => array( 1 ), 'paged'=>$paged );
    $query = new WP_Query( $args );

    if($query->have_posts()): while($query->have_posts()): $query->the_post(); 
?>     
    
    <section class="conteudo_post">   

    <?php if ($count === 0): ?>
        <div class="header-pagina">
            <span class="icone institucional"></span>
            <a href="<?php echo esc_url( home_url() ); ?>/estudos-espiritas/artigos/" title="ir para página de Notícias">Notícias</a>
        </div>
    <?php endif; ?>

        <div class="row">       
        	<?php get_template_part('content-list'); ?>        	
        </div><!-- .row -->                        

    </section>

    <?php 
        $count++; endwhile;     
    ?>


    <?php if ($query->max_num_pages > 1) { // check if the max number of pages is greater than 1  ?>
      <nav class="prev-next-posts">
        <div class="prev-posts-link">
          <?php echo get_next_posts_link( 'Artigos Anteriores', $query->max_num_pages ); // display older posts link ?>
        </div>
        <div class="next-posts-link">
          <?php echo get_previous_posts_link( 'Artigos mais Novos' ); // display newer posts link ?>
        </div>
      </nav>
    <?php } ?>



    <?php else: ?>

    <section class="conteudo_post" >

        <div class="header-pagina">
            <span class="icone institucional"></span><?php ?>Notícias            
        </div>

    	<div class="row">       
            <?php get_template_part('content-404'); ?>           
        </div><!-- .row -->       

    </section>

    <?php endif; ?>
    
    </div><!-- .row -->

    </div><!-- .col -->    

	<?php get_sidebar(); ?>    


	</div><!-- .row -->
</div><!-- /.container -->       


<?php get_footer(); ?>
