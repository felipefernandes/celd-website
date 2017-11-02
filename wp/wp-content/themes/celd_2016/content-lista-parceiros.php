<!-- CASAS PARCEIROS E CASAS AMIGAS -->
<div class="parceiros">
    <h3>Parceiros &amp; Casas Amigas</h3>
    
    <p>Algum parceiros do Centro Espírita Léon Denis. <strong>Clique nos itens abaixo para mais detalhes</strong>:</p>
    
    
    <div class="parceiros_listagem panel-group" id="accordion" role="tablist" aria-multiselectable="true">

        <?php
        $parceiro_count = 0;
        $parceiro_args = array('post_type' => 'parceiro', 'order' => 'ASC', 'posts_per_page' => -1);
        $parceiro_query = new WP_Query( $parceiro_args );

        if( $parceiro_query->have_posts() ):
        while( $parceiro_query->have_posts() ): $parceiro_query->the_post();

        ?>
        
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
              <h4 class="panel-title">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $post->ID; ?>" aria-expanded="true" aria-controls="collapseOne">
                  <div class="pull-left">
                    <?php the_title(); ?>
                  </div>
                  <div class="pull-right">
                    <span class="glyphicon glyphicon-plus text-primary"></span>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </h4>
            </div><!-- .panel-heading -->

            <div id="collapse-<?php echo $post->ID; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body parceiro_item">
                                                                  
                    <?php if(get_field('parceiro_descricao')) {  echo '<p>' . get_field('parceiro_descricao') . '</p>';  } ?>
                    <?php if(get_field('parceiro_website')) {  echo '<a href="http://'. get_field('parceiro_website') .'" target="_blank">' . get_field('parceiro_website') . '</a>';  } ?>

                    <?php 
                        $estudos = get_field('parceiro_reunioes_publicas');
                        if ($estudos): 
                    ?>
                    <hr>

                    <div class="outras">                        
                        <h4><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span> Programação de estudos</h4>
                        <table class="table">
                        <tr>
                            <th>Dia da semana</th>
                            <th>Horário</th>
                            <th>Estudo</th>
                        </tr>
                        <?php
                        
                        if ($estudos) {
                            foreach ($estudos as $estudo):                
                                echo "<tr>";
                                echo "<td>". semanaPorExtenso($estudo['parceiro_reunioes_semana'], true) ."</td>";
                                echo "<td>". $estudo['parceiro_reunioes_hora'] ."</td>";
                                echo "<td>". $estudo['parceiro_reunioes_estudo'] ."</td>";
                                echo "</tr>";
                            endforeach;
                        }
                        ?>   
                        </table>     
                    </div>
                    <?php endif; ?>

                </div><!-- .painel-body -->
            </div><!-- .panel-collapse -->
        </div><!-- .panel-default -->    


        <?php
        $parceiro_count++;
        endwhile;
        wp_reset_postdata();
        endif; //have_posts
        ?>



    </div><!-- panel-group -->



</div><!-- .parceiros -->