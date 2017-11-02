<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: Encontros & Seminarios
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div id="page-seminarios">

<div class="header-pagina">
    <div class="container">
        <span class="glyphicon glyphicon-calendar"></span> <?php ?><?php the_title(); ?>
    </div>
</div>


<div class="container pagina" id="page-galeria">    
    <section id="conteudo">

    <?php if ( have_posts() ): ?>

        <div class="entry">

        <div class="row">
        
        <?php    
            setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
            date_default_timezone_set('America/Sao_Paulo');
            $hoje = getdate(); 

            $args = array( 'post_type' => 'encontro_seminario',                            
                           'posts_per_page' => -1, 
                           'meta_key' => 'data_referencia',
                           'orderby' => 'meta_value',
                           'order' => 'DESC',);

            $query = new WP_Query( $args );

            while($query->have_posts()): $query->the_post();  

                $date = get_field('data_referencia');
                // $date = 19881123 (23/11/1988)

                // extract Y,M,D
                $y = substr($date, 0, 4);
                $m = substr($date, 4, 2);
                $d = substr($date, 6, 2);  

                if ( ($y <= $hoje['year']) && ($m <= $hoje['mon']) && ($d <= $hoje['mday'])) {
                    $passou = true;
                }                 
                else 
                if ( ($y > $hoje['year']) && ($m > $hoje['mon']) && ($d > $hoje['mday'])) {                 
                    $passou = false;
                }
        ?>


        <div id="post-<?php the_ID(); ?>" <?php post_class('entry col-xs-12 col-sm-6 col-md-6 col-lg-6'); ?>>

            <div class="evento-item <?php if($passou) { echo 'passou'; } else { echo 'ativo'; } ?>">
                <div class="cabecalho">
                    <div class="data_ref">
                        <h2>
                        <?php 
                            // format date (23/11/1988)
                            echo "<div class='dia'>" . $d . "</div>";
                            echo "<div class='mes'>" . mesPorExtenso($m, true) . "</div>";
                            echo "<div class='ano'>" . $y . "</div>";                            
                        ?>
                        </h2>
                    </div>
                    <div class="titulo"><h3><?php the_title(); ?></h3></div>
                    <div class="edicao">
                        <span class="numero"><?php the_field('edicao'); ?><sup>a</sup></span>
                        <span class="compl"> Ed.</span>
                    </div>
                    <div class="clearfix"></div>
                </div>    

                <div class="rodape">
                    <div class="datas">
                        <?php 
                        if ( get_field('dias_evento') ):
                            the_field('dias_evento');
                        else:
                            echo $d . " de " . mesPorExtenso($m);
                        endif;
                        ?>
                    </div>
                    <div class="abre_infos">
                        <a href="#item-<?php the_ID(); ?>" class="link_abre_infos">Confira a programação</a>
                    </div>
                    <div class="clearfix"></div>
                </div>


                <div class="infos">                  
                    <div class="tema">
                        <h5>Temas</h5>
                        <?php the_field('tema'); ?>
                    </div>                
                    <div class="site">
                        <a href='http://<?php the_field('site'); ?>' target="_blank"><?php the_field('site'); ?></a>
                    </div>
                </div>
            </div>
            
           
        </div>

        <?php endwhile; ?>

        </div><!-- .row -->

        </div><!-- .entry -->
        
    </section>
    <?php else: /* Silence is Gold */ ?>
    
        <?php get_template_part('content-404'); ?>
    
    <?php endif; ?>
    

</div><!-- /.container -->  

</div><!-- page-seminarios -->


<script type="text/javascript">
jQuery(document).ready(function ($) {

    /* Abre Descrição */
    $('.link_abre_infos').click(function() {
        $(this).parent().parent().siblings('.infos').slideToggle('fast');        

        if ( $(this).hasClass('aberto') ) {
            $(this).html('Confira a programação');
            $(this).removeClass('aberto');
        } else {
            $(this).html('Fechar a programação'); 
            $(this).addClass('aberto');       
        }
    });

    /* INICIALIZA - fecha todas as descrições */
    $('.infos').slideUp('fast');    

    //return false;


    setTimeout(function() {

        $('.ativo:last').attr('id','alvo');

        var y = $('#alvo').offset().top;
        var scrollY = $(window).scrollTop();
        var compensa = 35
        var padY = y - scrollY - compensa;
        
        $('html,body').animate({
          scrollTop: padY
        }, 1000);    

        console.log(padY);

    }, 2000);

});

/*
$(window).scroll(function() {
        var y = $(".passou:first").offset().top;
        var scrollY = $(window).scrollTop();
        if (scrollY > y) {
            var padY = scrollY - y;
            $(".passou:first").css("paddingTop", padY);            
        }
        console.log(y);
    });
*/

</script>      


<?php get_footer(); ?>
