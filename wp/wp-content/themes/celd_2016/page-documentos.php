<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: Modelo Padrão: Galeria Documentos para Download
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="header-pagina">
    <div class="container">
        <span class="icone download"></span><?php ?><?php the_title(); ?>
    </div>
</div>


<div class="container pagina pagina-documentos" id="page-galeria">
    <?php if (have_posts()): ?>        
    <section id="conteudo">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
        <header>
            <span>Navegue pelas categorias:</span>
            <?php
                $customPostTaxonomies = get_object_taxonomies('documento');

                $args = array(
                              'orderby' => 'name',
                              'show_count' => 0,
                              'hierarchical' => 1,
                              'taxonomy' => 'documento_tags',
                              'title_li' => ''
                            );

                $categories = get_categories($args);
            ?>

            <ul id="category-menu">
                <li id="cat-todos">
                    <a class="todos ajax" onclick="galeria_ajax_get(0);" href="#">
                        Todos
                    </a>
                </li>


                <?php foreach ( $categories as $cat ) { ?>
                <li id="cat-<?php echo $cat->term_id; ?>">
                    <a class="<?php echo $cat->slug; ?> ajax" onclick="galeria_ajax_get('<?php echo $cat->term_id; ?>');" href="#">
                        <?php echo $cat->name; ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </header>

        <?php endwhile; ?>

        <div class="row">
        
        <?php get_template_part('content-documentos'); ?>

        </div><!-- .row -->
        
    </section>
    <?php else: /* Silence is Gold */ ?>
    
        <?php get_template_part('content-404'); ?>
    
    <?php endif; ?>
    

</div><!-- /.container -->  


<script type="text/javascript">
/*
    Funcao para filtrar a página de categorias
*/    
function galeria_ajax_get( cat_id ) 
{
    jQuery('#category-menu li').removeClass('atual');
    
    if ( 0 !== cat_id ) {
        jQuery('#category-menu li#cat-' + cat_id ).addClass('atual');
        document.location.href = '<?php echo esc_url( home_url() ); ?>/estudos-espiritas/arquivos-para-download/?term_id=' + cat_id;
    }
    else {
        jQuery('#category-menu li#cat-todos').addClass('atual');
        document.location.href = '<?php echo esc_url( home_url() ); ?>/estudos-espiritas/arquivos-para-download/';
    }
}

</script>      


<?php get_footer(); ?>
