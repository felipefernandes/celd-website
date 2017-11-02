<?php 
/**
 *  Homepage
 *  @package CELD2015
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="banner-pagina" <?php echo (isset($thumb_url))? "style='background:url(" . $thumb_url . ") no-repeat; background-size: cover; background-position: center 30%;'" : ""; ?>></div>

<div class="header-pagina">
    <div class="container">
        <span class="icone institucional"></span>Cursos CELD - <?php the_title(); ?>
    </div>
</div>

<div class="container pagina">
    <?php if (have_posts()): ?>        
    <section id="conteudo">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
        
        <div class="entry">            
            <h2><?php the_title(); ?></h2>
            <small>Autor: <?php echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ','')); ?></small>
            <hr>
            <div class="row">
                <div class="descricao col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <?php $attachment_id = get_field('ementa_pdf'); ?>
                    <p>
                        <a href="<?php echo $attachment_id['url']; ?>" target="_blank">
                        Faça download do programa do curso
                        <!-- <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/download-placeholder.jpg"> -->
                        </a>
                    </p>
                    <?php if ( get_field('mini_descricao') ): ?>
                    <p><?php the_field('mini_descricao'); ?></p>
                    <?php endif; ?>
                </div>

                <div class="pdf col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                </div>
            </div><!-- row -->
            
            
        </div>

        <?php endwhile; ?>

    </section>
    <?php else: /* Silence is Gold */ ?>
    <section id="conteudo">
        <h2>Não tem nada aqui! :(</h2>
    </section>
    <?php endif; ?>
    

</div><!-- /.container -->        


<?php get_footer(); ?>
