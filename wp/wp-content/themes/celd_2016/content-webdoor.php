<?php 
/**
 *
 * Webdoor, slideshow homepage
 *
 */
?>


<!-- WEBDOOR -->
<div id="webdoor">  
  
  <div id="myCarousel" class="carousel slide slider" data-ride="carousel">   

  <!-- <?php echo esc_url( get_template_directory_uri() ); ?>/images/destaque-mobile.jpg -->        

<?php 
  $count = 0;
  $args = array( 'post_type' => 'destaque', 'posts_per_page' => 3, 'orderby'=>'menu_order','order'=>'ASC' );
  $webdoor_query = new WP_Query( $args );

  if ( $webdoor_query->have_posts() ):     

    /* indicadores & links  */
    echo '<ol class="carousel-indicators">';
    while ( $webdoor_query->have_posts() ): $webdoor_query->the_post();
    $relacionado = get_field('conteudo_relacionado');
    foreach( $relacionado as $p ):  

      //guarda o permalink do conteúdo relacionado
      $relacionado_link = get_permalink( $p->ID );  
?>
      <li data-target="myCarousel" 
          data-slide-to="<?php echo $count; ?>" 
          class="<?php echo ($count == 0) ? 'active' : ''; ?>"
          style="<?php if (get_field('cor_do_titulo')) { echo 'border-color:' . get_field('cor_do_titulo') . ';'; } ?>">
      </li>      
<?php
    $count++;
    endforeach;
    endwhile;
    
    echo "</ol>"; /* carousel-indicators */
    echo '<div class="carousel-inner">';
    
    $count = 0; /* reiniciando a contagem de sliders */

    while ( $webdoor_query->have_posts() ): $webdoor_query->the_post();
?>
      <div class="item <?php echo ($count == 0) ? 'active' : ''; ?>">       
<?php 
        //pega o link do conteúdo relacionado ao CPT Destaque
        $relacionado = get_field('conteudo_relacionado');
        foreach( $relacionado as $p ) {           
          echo '<a href="'. get_permalink( $p->ID ) .'" title="'. get_the_title( $p->ID ) .'">';
        }
?>        
          <div class="webdoor_link_img">
            <img src="<?php the_field('imagem'); ?>" data-src="holder.js/900x500/auto/#7cbf00:#fff/text: " alt="First slide">
          </div>
          <?php if(get_field('exibir_titulo') == '1'): ?>
          <div class="webdoor_link_titulo">
            <h2><?php the_title(); ?></h2>
          </div>
          <?php endif; ?>
        </a>
        <div class="container">
          <div class="carousel-caption">
            <h2> 
            <?php 
            $relacionado = get_field('conteudo_relacionado');
            
            if (get_field('cor_do_titulo')) {
              $estilo_link = 'color: ' . get_field('cor_do_titulo') . '; ';
            }

            if (get_field('bg_contraste') == 'sim') {
              $estilo_link = $estilo_link . 'text-shadow:1px 1px 1px ' . get_field('bg_contraste') . '; ';
            }            
            ?>
            </h2>
            <!-- <p></p> -->
          </div>
        </div>
      </div>
<?php 
  $count++;
  endwhile;
  wp_reset_postdata();

  echo "</div>"; /* carrosel inner */
?>

    <a class="left carousel-control hidden-xs hidden-sm" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
    </a>

    <a class="right carousel-control hidden-xs hidden-sm" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
    </a>    

</div><!-- #myCarousel -->

<?php
  else:
?>

<?php    
  endif;

?>

</div><!-- .webdoor -->