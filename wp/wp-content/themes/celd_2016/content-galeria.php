<?php 
/**
 *  Conteúdo Galeria
 *  @package CELD2015
 *  
 *
 */
?>

<div id="grid-fotos" class="">

<?php
    if (isset($_GET['term_id'])) {
        $termID = $_GET['term_id'];        
    } 
    else {
        // get all terms in the taxonomy
        $terms = get_terms( 'galeria_categoria' ); 
        // convert array of term objects to array of term IDs
        $termID = wp_list_pluck( $terms, 'term_id' );
    }

    $args = array( 'post_type' => 'galeria', 
                   'tax_query' => array( 
                                    array('taxonomy' => 'galeria_categoria', 
                                          'field' => 'term_id',
                                          'terms' => $termID,
                                          'operator' => 'IN'))
                   );
    $query = new WP_Query( $args );

    while($query->have_posts()): $query->the_post();            
?>


    <!-- DO TIPO FOTOS -->

    <?php 
        if(have_rows('galeria_fotos')): 
        
        // loop through the rows of data
        while ( have_rows('galeria_fotos') ) : the_row();

        $url_foto = get_sub_field('url_foto');
        $rotulo_foto = get_sub_field('rotulo_foto');
    ?>
    
    <div <?php post_class('foto entry galeria-entry col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>>
        <a href="<?php echo $url_foto['url']; ?>" class="popup-image">
            <img src="<?php echo $url_foto['sizes']['thumbnail']; ?>" title="<?php echo $rotulo_foto; ?>" />
        </a>

        <div class="infos">                
            <!-- <span class="cat"><?php echo strip_tags(get_the_term_list($post->ID, 'galeria_categoria','',', ','')); ?></span> -->
            <div class="descricao">
                <a href="<?php echo $url_video; ?>">
                    <?php echo $rotulo_foto; ?>
                </a>
            </div>                
        </div>
    </div>

    <?php endwhile; ?>
    <?php endif; ?>

    <!-- DO TIPO VIDEO -->

    <?php if(have_rows('galeria_videos')): 

        // loop through the rows of data
        while ( have_rows('galeria_videos') ) : the_row();

        $url_video = get_sub_field('url_video');
        $video_id = get_youtube_video_id( $url_video );
        $video_thumb = "http://img.youtube.com/vi/".$video_id."/hqdefault.jpg";
        $rotulo_video = get_sub_field('rotulo_video');
    ?>

    <div <?php post_class('foto entry galeria-entry col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>>
    <?php if ( 0 !== $video_id ): ?>                
        <a href="<?php echo $url_video; ?>" class="popup-youtube" data-type="video" data-vid="<?php echo $video_id; ?>">
            <img src="<?php echo $video_thumb; ?>" title="<?php echo $rotulo_video; ?>" />
        </a>
    <?php else: ?>
        <img src="<?php echo esc_url( home_url() ); ?>/images/image_placeholder.png" title="<?php echo $rotulo_video; ?>" />
    <?php endif; ?>
        <div class="infos">                
            <!-- <span class="cat"><?php echo strip_tags(get_the_term_list($post->ID, 'galeria_categoria','',', ','')); ?></span> -->
            <a href="<?php echo $url_video; ?>">
                <div class="descricao"><?php echo $rotulo_video; ?></div>                
            </a>
        </div>
    </div><!-- foto -->

    <?php endwhile; ?>
    <?php endif; ?>

<?php endwhile; ?>

    <div class="clearfix"></div>
</div><!-- post -->