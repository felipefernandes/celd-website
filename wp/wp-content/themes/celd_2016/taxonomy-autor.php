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
        <span class="icone institucional"></span>Cursos CELD - <?php echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ','')); ?>
    </div>
</div>

<div class="container pagina">
    <?php if (have_posts()): ?>        
    <section id="conteudo">            
        <div class="entry">
        <h2>Confira a lista de Cursos do autor <strong>'<?php echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ','')); ?></strong>'</h2>
        <hr>
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <h4><?php the_title(); ?></h4>            
            </a>                                 
        <?php endwhile; ?>
        </div>
        

    </section>
    <?php else: /* Silence is Gold */ ?>
    <section id="conteudo">
        <h2>Não tem nada aqui! :(</h2>
    </section>
    <?php endif; ?>
    

</div><!-- /.container -->        


<?php get_footer(); ?>
