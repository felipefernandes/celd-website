<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  
 *
 */
?>
<?php get_header(); ?> 
   
        <div class="navbar-pagina">
            <div class="container">
                <?php the_breadcrumb(); ?>
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
                    <?php the_content(); ?>
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
