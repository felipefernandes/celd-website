<?php 
/**
 *  Conteúdo de Contato Form
 *  
 *  @package CELD2015
 *
 */
?>


<div class="container content">

    <div class="row">
        <div id="formulario" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="content">
                <h2 class="titulo">Contato</h2>
                <p class="intro">Dúvidas, críticas e sugestões? Envie-nos uma mensagem.</p>
                <?php 
                    $args_contato = array( 'pagename' => 'contato' );
                    $query_contato = new WP_Query( $args_contato );
                    while ( $query_contato->have_posts() ): $query_contato->the_post();
                        the_content();
                    endwhile; 
                    wp_reset_postdata(); 
                ?>
            </div>
        </div>

        <div class="endereco hidden-xs hidden-sm col-md-4 col-lg-4">
            
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo-med.png">
            <h4>Centro Espírita Léon Denis</h4>
            <span>
                Rua Abílio dos Santos, 137 <bR>
                Bento Ribeiro/RJ<br>
                CEP: 21331-290<br>
                Tel.: (21) 2452-1846
            </span>

        </div>

    </div>
    
</div>

<div id="map_canvas" style="" class="">
    <?php $city = (get_field('location_name')) ? get_field('location_name') : "Rua Abílio dos Santos, 137, Bento Ribeiro, Rio de Janeiro"; ?>
    <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?php echo $city; ?>&zoom=13&size=640x640&scale=2&maptype=roadmap&format=png32
&sensor=false" alt="" />
</div>  