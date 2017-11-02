<?php 
/**
 *  Conteúdo de listagem de Mensagens Inspiradoras
 *  
 *  @package CELD2015
 *  
 *  sharethis api 308c13f7c48c7c19bed2230835637fad
 *
 */
?>

<span class="leia-mais btn">Mensagens inspiradoras</span>

<div id="mensagens-carousel" class="carrossel-mensagens carousel slide">
<div class="carousel-inner">
<?php 
    $query_page = new WP_Query('pagename=pagina-inicial');
    
    while($query_page->have_posts()): $query_page->the_post(); $c = 1;
    
    //carrega a lista de mensagens
    $rows = get_field('mensagens_inspiradoras'); 
    
    if($rows): 
        //embaralha as linhas    
        shuffle( $rows );

        foreach($rows as $row):                 
            $mensagem_row = $row['mensagem']; 
            $mensagem_autor_row = $row['autor'];
            $mensagem_url = esc_url( site_url() ) .'/mensagem-inspiradora.php?m='. $mensagem_row .'&a='. $mensagem_autor_row;
?>
        <div id="mensagem-pos-<?php echo $c; ?>" class="mensagem-item item <?php if($c == 1) { echo 'active'; } ?>">
            <blockquote><?php echo $mensagem_row; ?></blockquote>
            <span class="autor"><?php echo $mensagem_autor_row; ?></span>

            <div class="compartilhar">
<?php
                $title=urlencode( 'CELD' );
                $url= urlencode( 'http://www.celd.org.br' );
                $summary= $mensagem_url;                
?>
                <div class="fb-like" data-href="<?php echo $summary; ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
            </div><!-- /.compartilhar -->
        </div><!-- /.mensagem-item -->
<?php 
        $c++;
        endforeach;
    endif; //if($rows): 
    
    endwhile; //WP_Query  
    wp_reset_postdata(); 
?>
    </div><!-- .carousel-inner -->


    <ol class="carousel-indicators hide">
        <li data-target="#mensagens-carousel" data-slide-to="0" class="active"></li>    
    </ol>

    <!-- carousel-nav -->
    <div class="nav">
        <a href="#mensagens-carousel" class="carousel-control nav-anterior left" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
        <a href="#mensagens-carousel" class="carousel-control nav-proximo right" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- .nav -->

</div><!-- carrosel-msgs -->