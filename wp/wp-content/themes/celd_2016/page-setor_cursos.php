<?php 
/**
 *  Homepage
 *  @package CELD2015
 *  Template name: Setor de Cursos
 *
 */
?>
<?php get_header(); ?>
<?php get_template_part('banner-pagina'); ?>

<div class="banner-pagina" <?php echo (isset($thumb_url))? "style='background:url(" . $thumb_url . ") no-repeat; background-size: cover; background-position: center 30%;'" : ""; ?>></div>

<div class="header-pagina">
    <div class="container">
        <span class="icone institucional"></span><?php the_title(); ?>
    </div>
</div>

<div class="navbar-pagina">
    <?php if (!is_front_page()): ?>
    <div class='container'>  
        <span class='titulo-faixa'><?php /*if (have_posts()): the_title(); endif;*/ ?></span>
    </div>            
    <?php endif; ?>
</div>

<div id="page-setorcursos" class="container pagina">
    <?php if (have_posts()): ?>        
    <section id="conteudo">
        <?php
            while(have_posts()): the_post();
            $post_thumb_url = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
        ?>
        
        <div class="entry">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <?php the_content(); ?>
                </div>
            </div>
            
            <div class="row">               
                <div class="col-lg-7 col-md-7 col-xs-12 col-sm-12">
                    <h3>Cursos CELD</h3>    
                    <p>Nossos cursos estão divididos por autores, 
                    conheça o planejamento de cada um clicando no autor:</p>

                    <div class="row">
                        <div class="col-xs-3 autores">
                            <a href="<?php echo esc_url( home_url() ) ; ?>/autor/allan-kardec/">
                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/allan_kardec.jpg" class="img-thumbnail">
                                <div class="titulo">
                                    Allan Kardec
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-3 autores">
                            <a href="<?php echo esc_url( home_url() ) ; ?>/autor/leon-denis/">
                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/leon_denis.png" class="img-thumbnail">
                                <div class="titulo">
                                    Léon Denis
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-3 autores">
                            <a href="<?php echo esc_url( home_url() ) ; ?>/autor/yvonne-pereira/">
                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/yvonne_pereira.png" class="img-thumbnail">
                                <div class="titulo">
                                    Yvonne Pereira
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-3 autores">
                            <a href="<?php echo esc_url( home_url() ) ; ?>/autor/outros/">
                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/outros.png" class="img-thumbnail">
                                <div class="titulo">
                                    Outros
                                </div>
                            </a>
                        </div>

                        <div class="clearfix"></div>
                    </div><!-- row -->
                </div><!-- col -->

                <div class="col-lg-5 col-md-5 col-xs-12 col-sm-12 organograma">
                    <h3>Organograma de estudos</h3>
                    <p>Conheça a hierarquia do programa de estudos do CELD.</p>

                    <a href="<?php echo (get_field('organograma_pdf')) ? the_field('organograma_pdf') : "#"; ?>" target="_blank">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/organograma-download.png" width="100%">
                    </a>                    
                </div><!-- col -->

                <!-- <div class="clearfix"></div> -->
            </div><!-- row -->

            <div class="row grade_horarios">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <h3>Grade de Horários</h3>

                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#segunda" aria-controls="segunda" role="tab" data-toggle="tab">Segunda-feira</a></li>
                        <li role="presentation"><a href="#terca" aria-controls="terca" role="tab" data-toggle="tab">Terça-feira</a></li>
                        <li role="presentation"><a href="#quinta" aria-controls="quinta" role="tab" data-toggle="tab">Quinta-feira</a></li>
                        <li role="presentation"><a href="#sabado" aria-controls="sabado" role="tab" data-toggle="tab">Sábado</a></li>
                    </ul>

                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="segunda">                            
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                <?php
                                    $horarios = get_field('horario_cursos');                                    
                                    sksort($horarios, "horario", true); //ordena o vetor

                                    if($horarios):
                                        foreach ($horarios as $horario):                                    
                                            /* Segunda */
                                            if ( $horario['dia_semana'] === "2" ):                                            
                                                echo "<tr>";
                                                echo '<td class="horario">'. traduzHorariosSetorCursos($horario['horario']) .'</td>';

                                                /* coleção de cursos */
                                                $cursos = $horario['curso'];

                                                if ($cursos):
                                                    echo '<td class="estudos"><ul>';
                                                    foreach ($cursos as $curso):
                                                        echo '<li><a href="'. get_permalink( $curso->ID ) .'">'. get_the_title( $curso->ID ) .'</a> (';
                                                        echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ',''));
                                                        echo ')</li>';
                                                    endforeach;
                                                    echo '</ul></td>';
                                                endif;

                                                echo "</tr>";
                                            endif;
                                        endforeach;
                                    else:
                                        echo "Nenhum curso agendado para este dia";
                                    endif;
                                ?>                
                                </table>
                            </div><!-- table-responsive -->


                        </div><!-- tabpane -->

                        <div role="tabpanel" class="tab-pane" id="terca">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                <?php
                                    $horarios = get_field('horario_cursos');                                    
                                    sksort($horarios, "horario", true); //ordena o vetor

                                    if($horarios):
                                        foreach ($horarios as $horario):                                    
                                            /* Terça */
                                            if ( $horario['dia_semana'] === "3" ):                                            
                                                echo "<tr>";
                                                echo '<td class="horario">'. traduzHorariosSetorCursos($horario['horario']) .'</td>';

                                                /* coleção de cursos */
                                                $cursos = $horario['curso'];

                                                if ($cursos):
                                                    echo '<td class="estudos"><ul>';
                                                    foreach ($cursos as $curso):
                                                        echo '<li><a href="'. get_permalink( $curso->ID ) .'">'. get_the_title( $curso->ID ) .'</a> (';
                                                        echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ',''));
                                                        echo ')</li>';
                                                    endforeach;
                                                    echo '</ul></td>';
                                                endif;

                                                echo "</tr>";
                                            endif;
                                        endforeach;
                                    else:
                                        echo "Nenhum curso agendado para este dia";
                                    endif;
                                ?>                
                                </table>
                            </div><!-- table-responsive -->
                        </div><!-- tabpane -->
                        <div role="tabpanel" class="tab-pane" id="quinta">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                <?php
                                    $horarios = get_field('horario_cursos');                                    
                                    sksort($horarios, "horario", true); //ordena o vetor

                                    if($horarios):
                                        foreach ($horarios as $horario):                                    
                                            /* Quinta */
                                            if ( $horario['dia_semana'] === "5" ):                                            
                                                echo "<tr>";
                                                echo '<td class="horario">'. traduzHorariosSetorCursos($horario['horario']) .'</td>';

                                                /* coleção de cursos */
                                                $cursos = $horario['curso'];

                                                if ($cursos):
                                                    echo '<td class="estudos"><ul>';
                                                    foreach ($cursos as $curso):
                                                        echo '<li><a href="'. get_permalink( $curso->ID ) .'">'. get_the_title( $curso->ID ) .'</a> (';
                                                        echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ',''));
                                                        echo ')</li>';
                                                    endforeach;
                                                    echo '</ul></td>';
                                                endif;

                                                echo "</tr>";
                                            endif;
                                        endforeach;
                                    else:
                                        echo "Nenhum curso agendado para este dia";
                                    endif;
                                ?>                
                                </table>
                            </div><!-- table-responsive -->
                        </div><!-- tabpane -->
                        <div role="tabpanel" class="tab-pane" id="sabado">
                            <div class="table-responsive">
                                <table class="table table-bordered table-condensed">
                                <?php
                                    $horarios = get_field('horario_cursos');                                    
                                    sksort($horarios, "horario", true); //ordena o vetor

                                    if($horarios):
                                        foreach ($horarios as $horario):                                    
                                            /* Sabado */
                                            if ( $horario['dia_semana'] === "7" ):                                            
                                                echo "<tr>";
                                                echo '<td class="horario">'. traduzHorariosSetorCursos($horario['horario']) .'</td>';

                                                /* coleção de cursos */
                                                $cursos = $horario['curso'];

                                                if ($cursos):
                                                    echo '<td class="estudos"><ul>';
                                                    foreach ($cursos as $curso):
                                                        echo '<li><a href="'. get_permalink( $curso->ID ) .'">'. get_the_title( $curso->ID ) .'</a> (';
                                                        echo strip_tags(get_the_term_list($curso->ID, 'autor','',', ',''));
                                                        echo ')</li>';
                                                    endforeach;
                                                    echo '</ul></td>';
                                                endif;

                                                echo "</tr>";
                                            endif;
                                        endforeach;
                                    else:
                                        echo "Nenhum curso agendado para este dia";
                                    endif;
                                ?>                
                                </table>
                            </div><!-- table-responsive -->
                        </div><!-- tabpane -->

                    </div>
                </div>
            </div>

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
