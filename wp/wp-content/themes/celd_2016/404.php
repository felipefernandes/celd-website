<?php 
/**
 *  404
 *  @package CELD2015
 *  
 *
 */
?>

<?php get_header(); ?>  

<?php get_template_part('banner-pagina'); ?>

<div class="banner-pagina" <?php echo (isset($thumb_url))? "style='background:url(" . $thumb_url . ") no-repeat; background-size: cover; background-position: center 30%;'" : ""; ?>></div>

<div class="header-pagina">
    <div class="container">
        <span class="icone notfound"></span>404
    </div>
</div>

<div id="page-404" class="container pagina">
	<section id="conteudo">
		<div class="entry">
			<h1>404</h1>
			<h2>Página não encontrada</h2>

			<p>Infelizmente não encontramos
			você digitou, mas você pode
			buscar outros conteúdos.</p>

			<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url() ) ; ?>">                
			    <input type="text" name="s" id="s" class="col-xs-5" placeholder="Pesquisar no site" />
			    <input type="submit" id="searchsubmit" value="OK" />                
			</form>
		
		</div><!-- entry -->
	</section>
</div><!-- /.container -->       


<?php get_footer(); ?>