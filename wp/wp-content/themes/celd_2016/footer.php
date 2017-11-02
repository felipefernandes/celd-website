<?php 
/**
 *  Footer + Scripts JS
 *  @package CELD2015
 *
 */
?>
        <footer id="principal">    

            <div class="nivel-1">

                <div class="container">

                    <div class="logo">
                        <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo-mini.png" title="<?php bloginfo('name'); ?>" >
                        <h5><?php bloginfo('description'); ?></h5>
                    </div>
<!-- col-lg-2 col-md-2 col-sm-2  -->
                    <div class="coluna-1 col-xs-12">
                        <?php
                            wp_nav_menu( array(
                                'menu'              => 'principal_nav',
                                'theme_location'    => 'principal',
                                'depth'             => 2,
                                'container'         => 'div',
                                'container_id'      => 'bs-example-navbar-collapse-footer-1',
                                'menu_class'        => 'nav navbar-nav'                            
                            ));
                        ?>
                    </div>    


                    <!-- voltar ao topo btn -->
                    <a href="#topo" class="btn btn-para-cima visible-xs visible-sm">
                        <span class="glyphicon glyphicon-upload"></span><br>
                        Voltar ao topo
                    </a>
                    <div class="clearfix"></div>


                </div><!-- container -->                
            </div>

            <div class="nivel-2">      
                <div class="container hide">
                    <div class="coluna-3"><!-- col-lg-8 col-md-8 col-sm-10  -->
                        <div class="row">
                            <div class="newsletter col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <form class="form">
                                    <div class="form-group">
                                        <label class="form-label" for="newsletter">Receba no seu e-mail novidades e atualizações do Site do CELD.</label>
                                        <input type="text" id="newsletter" class="form-control" placeholder="digite seu email"><br>
                                        <em></em>
                                    </div>
                                </form>

                                <div class="redes_sociais">
                                    Nos acompanhe nas redes sociais<br>
                                    [ICON] [ICON] [ICON] [ICON]
                                </div>
                            </div>

                            <div class="redes-sociais col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <img src="http://www.placehold.it/220x180">
                            </div>
                        </div><!-- row -->
                    </div>
                    <div class="clearfix"></div>
                </div> 


                <div class="container copyright">   
                    <div class="pull-left">                 
                        2015 (c) <?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>. Todos os direitos reservados.
                    </div>
                    <div class="pull-right">
                        <!-- FACEBOOK SHARE -->                
                        <div class="fb-like" data-href="<?php echo esc_url( site_url() ); ?>" data-width="450" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>                        
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>    

        </footer>        
            
        <!-- <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/vendor/jquery.mobile-1.4.5.min.js"></script> -->
        <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/vendor/jquery.magnific-popup.min.js"></script>
        <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/vendor/jquery.slides.min.js"></script>        
        <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/main.min.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-19611744-1'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>

        <?php wp_footer(); ?>
        
    </body>
</html>

