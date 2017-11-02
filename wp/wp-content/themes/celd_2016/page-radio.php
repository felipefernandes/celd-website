<?php 
/**
 *  
 *  @package CELD2015
 *  Template name: CELD Podcast
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="header-pagina">
    <div class="container">
        <span class="icone institucional"></span><?php ?><?php the_title(); ?>
    </div>
</div>


<div id="page-radio" class="container pagina">
	<div class="row">
    <?php if (have_posts()): ?>        
    <section id="conteudo" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
        <header>
            <span>Navegue pelas categorias:</span>
            <?php
                $customPostTaxonomies = get_object_taxonomies('galeria');

                $args = array(
                              'orderby' => 'name',
                              'show_count' => 0,
                              'exclude' => 1,
                              'hierarchical' => 1,
                              'taxonomy' => 'galeria_categoria',
                              'child_of' => 13,
                              'title_li' => ''
                            );

                $categories = get_categories($args);
            ?>

            <ul id="category-menu">
                <li id="cat-todos">
                    <a class="todos ajax" onclick="radio_ajax_get(0);" href="#">
                        Todos
                    </a>
                </li>


                <?php foreach ( $categories as $cat ) { ?>
                <li id="cat-<?php echo $cat->term_id; ?>">
                    <a class="<?php echo $cat->slug; ?> ajax" onclick="radio_ajax_get('<?php echo $cat->term_id; ?>');" href="#">
                        <?php echo $cat->name; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </header>

        <?php endwhile; ?>

        <div class="row">       
        	<?php get_template_part('content-radio'); ?>        	
        </div><!-- .row -->        

        
    </section>
    <?php else: /* Silence is Gold */ ?>
        
        <?php get_template_part('content-404'); ?>
        
    <?php endif; ?>
        

	<?php get_sidebar(); ?>


	</div><!-- .row -->
</div><!-- /.container -->  









<script type="text/javascript">
/*
    Funcao para filtrar a página de categorias
*/    
function radio_ajax_get( cat_id ) 
{
    jQuery('#category-menu li').removeClass('atual');
    
    if ( 0 !== cat_id ) {
        jQuery('#category-menu li#cat-' + cat_id ).addClass('atual');
        document.location.href = '<?php echo esc_url( home_url() ); ?>/estudos-espiritas/celd-podcast/?term_id=' + cat_id;
    }
    else {
        jQuery('#category-menu li#cat-todos').addClass('atual');
        document.location.href = '<?php echo esc_url( home_url() ); ?>/estudos-espiritas/celd-podcast/';
    }
}

</script>      


<?php get_footer(); ?>
