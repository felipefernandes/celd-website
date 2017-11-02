<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: Página inicial
 *
 */
?>
<?php get_header(); ?>

        <?php get_template_part('content-webdoor'); ?>

        <div class="header-pagina hidden-xs hidden-sm">
            <div class="container"></div>
        </div>

        <div class="container">   

            <div class="row">
                
                <sidebar class="barra_lateral_a col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    
                    <div class="row">


                        <?php get_template_part('content', 'box-programacao'); ?>


                        <section id="campanhas" class="widget col-md-6 col-lg-6">                            
                             <?php 
                                /* Configurado em HOMEPAGE */
                                $bloco_a = get_field('bloco_a');
                                $bloco_a_imagem = get_field('bloco_a_imagem');
                                if ( $bloco_a ):
                                    $post = $bloco_a;
                                    setup_postdata( $post );

                                    if ( $bloco_a_imagem ) {
                                        $post_image_url = wp_get_attachment_image( $bloco_a_imagem, 'quadrado-homepage');
                                    } 
                                    else {
                                        $post_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'quadrado-homepage');    
                                    }
                            ?>
                            <div class="banner">
                                <!-- <a href="<?php the_permalink(); ?>"> -->
                                <a href="https://www.youtube.com/channel/UCtK8ecXzegmtiIlzmI0W5iA/live" target="_blank">
                                    <?php 
                                        if ($bloco_a_imagem) {
                                            echo wp_get_attachment_image( $bloco_a_imagem, 'quadrado-homepage');
                                        } 
                                        else {
                                            echo "<img src='" . $post_image_url[0] . "' width=263 >";
                                        }

                                    ?>
                                </a>
                            </div>
                            <?php wp_reset_postdata(); endif; ?>
                        </section>


                        <section id="post-destaque" class="widget col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <?php 
                                /* Configurado em HOMEPAGE */
                                $bloco_a = get_field('bloco_b');
                                if ( $bloco_a ):
                                    $post = $bloco_a;
                                    setup_postdata( $post );
                                    $post_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'retangulo-homepage'  );
                            ?>
                            <div class="content">

                                <div class="post_thumbnail">
                                    <img src="<?php echo $post_image_url[0]; ?>">
                                </div>

                                <a class="titulo-link" href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?><span class="icone glyphicon glyphicon-chevron-right"></span>
                                </a> 

                            </div>
                            <?php wp_reset_postdata(); endif; ?>
                        </section><!-- .post-destaque -->



                        <section id="publicidade" class="widget col-md-12 col-lg-12 hidden-xs hidden-sm">
                            <?php 
                            $banners = get_field('banners');

                            if ($banners):
                            foreach ( $banners as $banner ):
                            ?>
                            <div class="banner">
                                <a href="<?php if ( $banner['link'] !== '#' || $banner['link'] !== NULL ) { echo $banner['link']; } else { echo "#"; } ?>" target="_blank">
                                    <?php echo wp_get_attachment_image( $banner['imagem'], 'publi-homepage' ); ?>
                                </a>
                            </div>
                             <?php endforeach; endif; ?>
                        </section>
                    
                    </div>


                </sidebar><!-- .sidebar -->

                

                <div class="coluna_principal col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    
                    <?php 
                        $count = 0;
                        $args = array('post_type' => 'post',                                       
                                      'category_name' => 'em-destaque',
                                      'posts_per_page' => 3
                                    );
                        $query = new WP_Query ( $args );
                    ?>

                    <?php if ($query->have_posts()): ?>
                    <!-- AREA DE NOTICIAS -->
                    <section id="noticias">

                        <h3 class="titulo">Artigos &amp; Notícias</h3>

                        <?php
                            while($query->have_posts()): $query->the_post();
                            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
                        ?>

                        <article id="<?php the_ID(); ?>" class="post_item <?php echo ( $count == 0 ) ? "primeiro-post" : ""; ?>">
                            <div class="titulo-artigo">
                                <div class="bg bg-parallax" style="background-image:url('<?php echo $post_thumb_url; ?>');">
                                <a href="#" class="cat">notícias</a>
                                <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                            </div>
                            <div class="rodape">
                                <div class="meta">
                                    <?php the_time(); ?> /    
                                    <a href="<?php the_permalink(); ?>/#respond">
                                        <?php comments_number( 'comente este post', 'um comentário', '% comentários' ); ?>
                                    </a>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="btn leia-mais">Continue lendo...</a>
                                <div class="clearfix"></div>
                            </div>
                        </article>

                        <?php $count++; endwhile; ?>

                    </section>
                    <?php else: /* Silence is Gold */ ?>

                    <?php endif; ?>

                </div>

                <div class="clearfix"></div>
            </div>


        </div><!-- .container -->


        <section id="biblioteca" class="expandido">            
            
            <?php get_template_part('content-list-biblioteca'); ?>

        </section><!-- ./biblioteca -->


        <div class="container">

            <section id="multimidia">

                <h2>CELD multimidia</h2>
                <p class="intro">Confira as palestras em tempo real e ouça os programas gravados na nossa Rádio online.</p>

                <section id="celdtv" class="col-xs-12 col-sm-12 col-md-6 col-md-6">
                    <h3 class="titulo">
                        <span class="icone"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/ico-celdtv.png"></span> 
                        <span class="nome">CELD<small>tube</small></span>
                    </h3>

                    <?php   
                        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
                        date_default_timezone_set('America/Sao_Paulo');
                        $hoje = getdate(); 

                        /*$hoje = array( 'wday'    => 4,
                                       'hours'   => 20,
                                       'minutes' => 30 );*/                        

                        $agora = array( 'semana' => $hoje['wday'] + 1,
                                        'hora'   => $hoje['hours'],
                                        'min'    => $hoje['minutes'] );

                        $streamingTime = checkStreamingTime( $agora['semana'], $agora['hora'], $agora['min'] );
                        $streamingTimeExtra = get_field('streaming');

                        if ( $streamingTime || $streamingTimeExtra ):

                            //echo '<script>parent.window.location.reload(true);</script>';
                            //insere o player streaming se tiverno intervalo das reuniões
                            insertStreamingPlayer();
                        else :

                        $video_args = array(
                            'post_type' => 'galeria', 
                            'posts_per_page' => 1,
                            'tax_query' => array(
                                            'relation' => 'AND',
                                            array('taxonomy' => 'galeria_categoria', 
                                                  'field' => 'slug',
                                                  'terms' => 'em-destaque-celd-tv',
                                                  'operator' => 'IN' 
                                            ),
                                            array('taxonomy' => 'galeria_categoria', 
                                                  'field' => 'slug',
                                                  'terms' => 'celd-tv',
                                                  'operator' => 'IN' 
                                            ),
                                        ),
                            );
                        $video_query = new WP_Query( $video_args );

                        if ( $video_query->have_posts() ):
                        while ( $video_query->have_posts() ): $video_query->the_post();

                        if(have_rows('galeria_videos')): 
                        while ( have_rows('galeria_videos') ) : the_row();

                        $url_video = get_sub_field('url_video');
                        $video_id = get_youtube_video_id( $url_video );
                        $video_thumb = "http://img.youtube.com/vi/".$video_id."/hqdefault.jpg";
                        $rotulo_video = get_sub_field('rotulo_video');
                    ?>

                    <script type="text/javascript">

                    $(document).ready(function() {                    
                        checkST = setInterval(function() {
                            //window.location.reload();
                            $.ajax({
                                url: "",
                                context: document.body,
                                success: function(s,x){
                                    $(this).html(s);
                                }
                            });
                            console.log('r');
                        }, 1200000); //20min


                    });

                    </script>


                    <div class="video destaque" id="001">
                        <a href="<?php echo $url_video; ?>" class="popup-youtube popup-video" data-type="video" data-vid="<?php echo $video_id; ?>">
                            <img src="<?php echo $video_thumb; ?>" title="<?php echo $rotulo_video; ?>" />
                        </a>

                        <div class="info">
                            <!--<span class="cat"><?php echo strip_tags(get_the_term_list($post->ID, 'galeria_categoria','',', ','')); ?></span>-->
                            <div class="descricao">
                                <strong>Tema</strong>: <?php echo $rotulo_video; ?><br>
                                <!-- <strong>Expositor</strong>: Deuza Nogueira -->
                            </div>
                        </div>
                    </div>

                    <?php endwhile; endif; endwhile; wp_reset_postdata(); endif; ?>

                    <?php endif; ?>

                    <div class="rodape">
                        <a href="<?php echo esc_url( home_url() ); ?>/celd-tube">Ir para lista de vídeos</a>
                    </div>
                </section>

                

                <section id="radioceld" class="col-xs-12 col-sm-12 col-md-6 col-md-6">
                    <h3 class="titulo"><span class="icone"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/ico-radioceld.png"></span> CELD<small>cast</small></h3>

                    <div class="playlist">

                        <?php 
                            $radio_args = array('post_type' => 'radio_celd', 'posts_per_page' => 3);
                            $radio_query = new WP_Query( $radio_args );

                            if ( $radio_query->have_posts() ):
                            while ( $radio_query->have_posts() ): $radio_query->the_post();
                        ?>

                        <div class="podcast novo" id="audio-<?php the_ID(); ?>">
                            <!--<div class="cat"><?php echo get_the_term_list($post->ID, 'galeria_categoria','',', ',''); ?></div>-->
                            <small class="data">publicado em <?php the_time('d F, Y'); ?></small>

                            <audio id="audio_player" preload="none" autostart="0" controls>
                                <source src="<?php the_field('sonora'); ?>" type="audio/mp3" />
                                Infelizmente seu navegador não suporta este recurso.
                            </audio>
                                                        
                            <div class="descricao">
                                <span class="titulo"><?php the_title(); ?></span>                                
                                <div class="clearfix"></div>
                            </div>                            
                        </div>

                        <?php endwhile; wp_reset_postdata(); endif; ?>

                    </div>

                    <div class="rodape">
                        <a href="<?php echo esc_url( home_url() ); ?>/estudos-espiritas/celd-podcast/">Ir para lista de todos os programas</a>
                    </div>
                </section>

                <div class="clearfix"></div>
            </section>

        </div><!-- .container --><!-- ./multimidia -->


        <section id="mensagens">            
            <?php get_template_part('content-mensagens'); ?>
        </section><!-- ./mensagens-inspiradoras -->


        <section id="doacoes" class="expandido">
            <div class="container">
                <h2>Doações</h2>
                <p>O CELD - Centro Espírita Leon Denis - é uma instituição que sobrevive a partir da doação dps seus frequentadores. E, para que isso seja feito, há diversas maneiras:</p>

                <a href="<?php echo esc_url( home_url() ); ?>/a-instituicao/doacoes/" class="btn">Boleto Bancário</a>
                <a href="<?php echo esc_url( home_url() ); ?>/a-instituicao/doacoes/" class="btn">Depósito Bancário</a>

                <p>Você ainda pode fazer doações diretamente nos caixas da nossa Livraria ou, ainda, pelo gazofilácio, localizado nos corredores do CELD.</p>
            </div>
        </section><!-- ./doacoes -->


        
        <section id="contato">
            <?php get_template_part('content-contato'); ?>
        </section>
    


<?php get_footer(); ?>
