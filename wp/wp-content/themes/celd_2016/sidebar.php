<?php 
/**
 *  MAIN SIDEBAR
 *  @package CELD2015
 *  
 *
 */
?>

<sidebar class="sidebar main hidden-xs col-sm-12 col-md-4 col-lg-4">
	
	<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Lateral Sidebar')) : ?>
	
		<!-- Conteúdo de exemplo, caso não haja Widgets configurados -->
		<div class="sidebox widget">
			<h3>
				<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
				Titulo do widget
			</h3>
			<div class="content">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tempus lorem quam, suscipit posuere nulla rhoncus et. Pellentesque vestibulum finibus sapien. Duis est turpis, tempor vitae sem nec</p>
			</div>
		</div>

	<?php endif; ?>

</sidebar>