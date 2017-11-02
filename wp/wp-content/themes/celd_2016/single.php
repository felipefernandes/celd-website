<?php 
/**
 *  
 *  @package CELD2015
 *  Template name: Single Page
 *
 */
?>
<?php get_header(); ?>  

<!-- SINGLE POST -->  

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

<div id="single" class="container post">
	<div class="row">

    <?php if (have_posts()): the_post(); ?>        
    
    <section id="conteudo" class="post_box col-xs-12 col-sm-12 col-md-8 col-lg-8" style='<?php if (!has_post_thumbnail()) { echo "margin-top:-80px;"; } else { echo "margin-top:-200px;";  } ?>'>   

        <div class="header-pagina">
            <span class="icone institucional"></span>
            <a href="<?php echo esc_url( home_url() ); ?>/estudos-espiritas/artigos/" title="ir para página de Notícias">Notícias</a>
        </div>

        <div class="row">       
        	<?php get_template_part('content-single'); ?>        	
        </div><!-- .row -->                

        <div class="paginacao">
             <?php /*wp_link_pages();*/ posts_nav_link();  ?>         
        </div>

    </section>

    <?php else: /* Silence is Gold */ ?>

    <section id="conteudo" class="post_box col-xs-12 col-sm-12 col-md-8 col-lg-8">
    	<div class="row">       
            <?php get_template_part('content-404'); ?>           
        </div><!-- .row -->                
    </section>

    <?php endif; ?>
        

	<?php get_sidebar(); ?>


	</div><!-- .row -->
</div><!-- /.container -->       


<?php get_footer(); ?>
