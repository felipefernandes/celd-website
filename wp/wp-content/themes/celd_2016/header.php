<?php 
/**
 *  Header
 *  @package CELD2015
 */
?>
<!DOCTYPE html >
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title><?php wp_title(''); ?></title>
        <meta name="description" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">                
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- FB TAGS -->
        <meta property="og:url"     content="<?php echo esc_url( home_url() ) ; ?>" />
        <meta property="og:type"    content="website" />
        <meta property="og:title"   content="CELD" />
        <meta property="og:description"   content="Centro Espírita Leon Denis" />
        <meta property="og:image"   content="<?php echo esc_url( home_url() ) ; ?>/wp-content/themes/celd_2016/images/logo.jpg" />    
        
        <!-- STYLES -->
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/magnific-popup.min.css">   
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css">  
        <link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap-theme.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/main.min.css" />
        

        <!-- SCRIPTS JS LOAD -->
        <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/vendor/jquery-1.9.1.min.js"></script>

        <?php wp_head(); ?>        
    </head>
    <body <?php body_class(); ?>>
        <!--[if lt IE 7]>
            <p class="chromeframe">Você está usando um navegador <strong>desatualizado</strong>. Por favor <a href="http://browsehappy.com/">atualize seu navegador</a> ou <a href="http://www.google.com/chromeframe/?redirect=true">ative o Google Chrome Frame</a> para melhorar sua experiência de navegação.</p>
        <![endif]-->

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.6&appId=1667836133432876";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>


        <!-- Cabeçalho de navegação -->
        <?php get_header('nav'); ?>

