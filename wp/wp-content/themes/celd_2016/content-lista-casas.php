<!-- CASAS COLIGADAS -->
<div class="casas_coligadas_listagem">    
    <h3>Lista de Casas Coligadas</h3>

    <div class="row">

    <div class="col-xs-12">
        <p>Veja a lista de Centros Espíritas, que acompanham nossa programação e suas atividades, e suas respectivas Obras Sociais.</p>
        <br>
    </div>

    <?php 
    $query = new WP_Query( 'post_type=casa_coligada&posts_per_page=-1&orderby=title&order=ASC' );

    while ($query->have_posts()): $query->the_post();
    ?>
    <div class='col-xs-12 col-sm-12 col-md-6 col-lg-6'>
        <div <?php post_class('casa'); ?>>
            <div class="casa_nome">
                <h4><?php the_title(); ?> </h4>
                <small>fundado em: <?php 

                $date = get_field('casa_dt_fundacao');
                // $date = 19881123 (23/11/1988)

                // extract Y,M,D
                $y = substr($date, 4, 8);
                $m = substr($date, 2, 2);
                $d = substr($date, 0, 2);
            
                // format date (23/11/1988)
                echo $d . "/" . $m . "/" . $y;

                ?></small>
            </div>

            <div class="descricao">

                <div class="casa_endereco">
                    <?php $endereco = get_field('casa_endereco'); echo $endereco['address']; ?>
                </div>
                
                <?php if (get_field('casa_email')):  ?>
                <div class="casa_contato_email">
                    <a href="mailto:<?php the_field('casa_email'); ?>">
                    <?php the_field('casa_email'); ?>
                    </a>
                </div>
                <?php endif; ?>
                
                <?php if (get_field('casa_contato_tel')):  ?>
                <div class="casa_contato_tel"><?php the_field('casa_tel'); ?></div>        
                <?php endif; ?>

                <div class="casa_reunioespublicas">
                    <h5>
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    Reunião Públicas</h5>
                    <table class="table">
                        <tr>
                            <th>Dia da semana</th>
                            <th>Horário</th>
                            <th>Estudo</th>
                        </tr>
                        <?php
                        $estudos = get_field('casa_reunicoes_publicas');
                        foreach ($estudos as $estudo):                
                            echo "<tr>";
                            echo "<td>". semanaPorExtenso($estudo['casa_reunioes_semana'], true) ."</td>";
                            echo "<td>". $estudo['casa_reunioes_hora'] ."</td>";
                            echo "<td>". $estudo['casa_reunioes_estudo'] ."</td>";
                            echo "</tr>";
                        endforeach;
                        ?>                
                    </table>     
                    <div class="clearfix"></div>
                </div>

                <?php if (get_field('casa_outrasinfos')):  ?>
                <div class="casa_outrasinfos">
                    <h5>
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Informações</h5>
                    <?php the_field('casa_outrasinfos'); ?>
                </div>
                <?php endif; ?>

                <?php if (get_field('casa_doacoes')):  ?>
                <div class="casa_doacao">
                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span> 
                    <strong>Doações: </strong><?php the_field('casa_doacoes'); ?>
                </div>
                <?php endif; ?>

            </div><!-- .descricao -->
            <a href="#<?php echo 'post-' . $post->ID; ?>" class="btn btn_abre_casa">
                <i class="glyphicon glyphicon-chevron-down"></i>
            </a>
        </div><!-- .casa -->        
    </div>
    <?php  
    endwhile;
    ?>

    <?php
    wp_reset_postdata();

    ?>
    </div><!-- row -->
</div><!-- casas_coligadas_listagem -->


<script type="text/javascript">
jQuery(document).ready(function ($) {

    /* Abre Descrição */
    $('.btn_abre_casa').click(function() {
        $(this).siblings('.descricao').slideToggle('fast');

        $(this).children('i').toggleClass('glyphicon-chevron-down');
        $(this).children('i').toggleClass('glyphicon-chevron-up');

        /*if ( $(this).children('i').hasClass('glyphicon-chevron-up') ) {
            $(this).css('padding-top', '2px');
        } else {
            $(this).css('padding-top', '5px');
        }*/
    });

    /* INICIALIZA - fecha todas as descrições */
    $('.descricao').slideUp('fast');

    /* function() {
        $(this).children('.btn_abre_descricao').css('padding-top', '2px');
    } */

});

</script>      