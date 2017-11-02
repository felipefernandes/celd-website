<?php 
/**
 *  Conteúdo de listagem de Biblioteca (HOMEPAGE)
 *  
 *  @package CELD2015
 *
 */
?>

<?php 
    $biblioteca_args = array(
        'post_type' => 'documento', 
        'posts_per_page' => 6,
        'tax_query' => array(
                        array('taxonomy' => 'documento_tags', 
                             'field' => 'slug',
                             'terms' => 'livro'
                        ),
                ),
        );
    $biblioteca_query = new WP_Query( $biblioteca_args );

    if ( $biblioteca_query->have_posts() ):
?>

<div class="container">
    <h2>Biblioteca CELD</h2>
    <p class="intro">Aqui trazemos sugestões de livros para estudos individualizado ou relacionados aos temas apresentados durante a semana.</p>

    <div id="carrossel-livros" class="row">

    <?php 
        while ( $biblioteca_query->have_posts() ): $biblioteca_query->the_post();

    ?>
        <div class="livro col-xs-6 col-sm-4 col-md-2 col-lg-2 <?php echo ($i > 2) ? "hidden-xs hidden-sm" : ""; ?> <?php echo ($i == 2) ? "hidden-xs" : ""; ?>">
            <a class="imagem" href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('biblioteca-livro'); ?>
                
            </a>
            <div class="descricao">
                <span class="nome"><?php the_title(); ?></span>
                <span class="autor"><?php if (get_field('autor')) { the_field('autor'); } ?> <?php if (get_field('psicografia')) { echo "/ " . get_field('psicografia'); } ?></span>
            </div>
            <div class="footer">
                <a href="<?php the_permalink(); ?>" class="btn-resenha btn">
                    <span class="icone"></span> Resenha do Livro
                </a>
                <a href="<?php the_field('documento_arquivo'); ?>" class="btn-download btn">
                    <span class="icone"></span> Download
                </a>
            </div>
        </div><!-- .livro -->
       
    <?php endwhile; wp_reset_postdata(); ?>



        <div class="clearfix"></div>
    </div><!-- ./carrosel-livros -->

</div><!-- ./container -->

<?php endif; ?>