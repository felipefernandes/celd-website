<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: Modelo Padrão: Página
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="banner-pagina" <?php echo (isset($thumb_url))? "style='background:url(" . $thumb_url . ") no-repeat; background-size: cover; background-position: center 30%;'" : ""; ?>></div>

<div class="header-pagina">
    <div class="container">
        <span class="icone institucional"></span><?php the_title(); ?>
    </div>
</div>

<div class="navbar-pagina">
    <?php if (!is_front_page()): ?>
    <div class='container'>  
        <span class='titulo-faixa'><?php /*if (have_posts()): the_title(); endif;*/ ?></span>
    </div>            
    <?php endif; ?>
</div>


<div class="container pagina">
    <?php if (have_posts()): ?>        
    <section id="conteudo">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
        
        <div class="entry">
        <?php if( get_field('duas_colunas') ): ?>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                    <?php the_content(); ?>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
                    <?php the_field('conteudo_coluna'); ?>
                </div>
            </div>
        <?php else: ?>
            <?php the_content(); ?>
        <?php endif; ?>
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
