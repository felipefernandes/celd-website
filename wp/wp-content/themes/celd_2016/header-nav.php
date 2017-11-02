<?php 
/**
 *  Footer Nav / Navegação principal
 *  @package CELD2015
 *
 */
?>

<div class="navbar" role="navigation">
    <!-- Ancora TOPO -->
    <a id="topo"></a>

    <div class="container">
        <div class="navbar-busca hidden-sm hidden-xs">
            <form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url() ) ; ?>">                
                <input type="text" name="s" id="s" placeholder="Pesquisar no site" />
                <input type="submit" id="searchsubmit" value="OK" />                
            </form>
        </div>


        <div class="navbar-header navbar-fixed-top">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>  

            <div class="the-name">
                CELD<br><span>Centro Espírita Leon Denis</span>
            </div>

        </div>
        <div class="navbar-header-brand">
            <a class="navbar-brand" href="<?php echo esc_url( home_url() ) ; ?>"><?php bloginfo('name'); ?></a>
        </div>

        <?php
            wp_nav_menu( array(
                'menu'              => 'principal_nav',
                'theme_location'    => 'principal',
                'depth'             => 2,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
            );
        ?>
        <!--/.nav-collapse -->

        <div class="navbar-footer"></div>
    </div>
</div><!-- .navbar -->
