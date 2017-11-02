<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: Revistas de Estudos: Galeria Documentos para Download
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="header-pagina">
    <div class="container">
        <span class="icone download"></span><?php ?><?php the_title(); ?>
    </div>
</div>


<div class="container pagina pagina-documentos pagina-revistas" id="page-galeria">
    <?php if (have_posts()): ?>        
    <section id="conteudo">        
        <div class="row">
        
        <div class="entry">
            <?php 
            $termID = get_term_by('name', 'revista', 'documento_tags');   
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
                        <?php the_post_thumbnail(); ?>                   
                        <?php else: ?>
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/download-placeholder.jpg">
                        <?php endif; ?>
                        <div class="icon"><span class="glyphicon glyphicon-download"></span></div>
                    </a>

                    <div class="infos">                          
                        <div class="descricao">
                            <a href="<?php echo $url_doc; ?>" target="_blank">
                                <?php echo $rotulo_doc; ?>
                            </a>
                        </div>                
                    </div>
                </div>
               
            </div>

            <?php endwhile; ?>


        </div>

        </div><!-- .row -->
        
    </section>
    <?php else: /* Silence is Gold */ ?>
    
        <?php get_template_part('content-404'); ?>
    
    <?php endif; ?>
    

</div><!-- /.container -->  


<?php get_footer(); ?>
