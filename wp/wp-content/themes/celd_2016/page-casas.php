<?php 
/**  
 *  @package CELD2015
 *  Template name: Casas Coligadas
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="header-pagina">
    <div class="container">
        <span class="icone institucional"></span><?php the_title(); ?>
    </div>
</div>

<div class="navbar-pagina"></div>


<div id="casas_coligadas" class="container pagina">

    <?php if (have_posts()): ?>        
    <section id="conteudo">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
        
        <div class="entry">        
            <?php the_content(); ?>
        </div>

        <?php endwhile; wp_reset_postdata(); ?>
    </section>

    <?php else: /* Silence is Gold */ ?>
    
    <section id="conteudo">
        <h2>Não tem nada aqui! :(</h2>
    </section>
    
    <?php endif; ?>

    <?php get_template_part('content-lista-parceiros'); ?> 

    <?php get_template_part('content-lista-casas'); ?>
    

</div><!-- /.container -->        


<?php get_footer(); ?>
