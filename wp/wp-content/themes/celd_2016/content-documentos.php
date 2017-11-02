<?php 
/**
 *  Conteúdo Galeria de Documentos
 *  @package CELD2015
 *  
 *
 */
?>

<?php
    if (isset($_GET['term_id'])) {
        $termID = $_GET['term_id'];        
    } 
    else {
        // get all terms in the taxonomy
        $terms = get_terms( 'documento_tags' ); 
        // convert array of term objects to array of term IDs
        $termID = wp_list_pluck( $terms, 'term_id' );
    }

    $args = array( 'post_type' => 'documento',
                   'posts_per_page' => -1,
                   'tax_query' => array( 
                                    array('taxonomy' => 'documento_tags', 
                                          'field' => 'term_id',
                                          'terms' => $termID,
                                          'operator' => 'IN'))
                   );
    $query = new WP_Query( $args );

    while($query->have_posts()): $query->the_post();            
?>


<div id="post-<?php the_ID(); ?>" <?php post_class('entry galeria-entry col-xs-12 col-sm-6 col-md-4 col-lg-3'); ?>>

    <!-- DO TIPO FOTOS -->

    <?php 
        $url_doc = get_field('documento_arquivo');
        $rotulo_doc = get_field('documento_descricao');
    ?>
    
    <div class="foto">
        <a href="<?php echo $url_doc; ?>" class="popup-doc" target="_blank">            
            <?php if(has_post_thumbnail()): ?>
            <?php the_post_thumbnail('doc-thumb'); ?>                   
            <?php else: ?>
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/download-placeholder.jpg">
            <?php endif; ?>
            <div class="icon"><span class="glyphicon glyphicon-download"></span></div>
        </a>

        <div class="infos">  
            <span class="cat"><?php echo strip_tags(get_the_term_list($post->ID, 'documento_tags','',', ','')); ?></span>
            <div class="descricao">
                <a href="<?php echo $url_doc; ?>" target="_blank">
                    <?php echo $rotulo_doc; ?>
                </a>
            </div>                
        </div>
    </div>
   
</div>

<?php endwhile; ?>