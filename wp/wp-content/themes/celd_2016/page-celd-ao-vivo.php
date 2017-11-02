<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: CELD ao vivo
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="banner-pagina" <?php echo (isset($thumb_url))? "style='background:url(" . $thumb_url . ") no-repeat; background-size: cover; background-position: center 30%;'" : ""; ?>></div>

<div class="header-pagina">
    <div class="container">
        <span class="icone" style="background: url(<?php echo esc_url( get_template_directory_uri() ); ?>/images/ico-celdtv.png) no-repeat;"></span>        

        <?php the_title(); ?>
    </div>
</div>

<div class="container pagina">      
    <section id="conteudo">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>        
        <div class="entry">

            <div style="width:740px; margin:0 auto;">
            <?php
                /*setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
                date_default_timezone_set('America/Sao_Paulo');
                $hoje = getdate();                    
                $agora = array( 'semana' => $hoje['wday'] + 1,
                                'hora'   => $hoje['hours'],
                                'min'    => $hoje['minutes'] );
                $streamingTime = checkStreamingTime( $agora['semana'], $agora['hora'], $agora['min'] );
                $streamingTimeExtra = get_field('streaming');

                if ( $streamingTime || $streamingTimeExtra ):*/
                    //insere o player streaming se tiverno intervalo das reuniões
                    echo "<div style='background-color: #000; width:540px; margin:0 auto;' >";
                    //insertStreamingPlayer();
                    ?>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/nToKDc9RTUw" frameborder="0" allowfullscreen style="margin:0 auto;"></iframe>
                    <?php
                    echo "</div>";

                    
                /*else :
                https://www.youtube.com/watch?v=

                    echo "<h3>No momento não estamos transmitindo...</h3>";

                    the_content();                    
                    
                endif;*/
            ?>  

            <br><br>

            <?php the_content(); ?>

            </div>

        </div>
        <?php endwhile; ?>
    </section>
    
    

</div><!-- /.container -->        


<?php get_footer(); ?>
