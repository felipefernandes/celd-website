<?php 
/**
 *  Single post
 *  @package CELD2015
 *  
 *
 */
?>
<div id="post-<?php the_ID(); ?>" class="entry">

	<header>
		<h2>
			<a href="<?php the_permalink(); ?>" title="Link para <?php the_title(); ?>"><?php the_title(); ?></a>
		</h2>
		<div class="meta">
			<span class="data">publicado em <?php the_time('d F \d\e Y'); ?> • <?php echo (get_field('noticias_autor')) ? get_field('noticias_autor') : get_the_author(); ?></span>			
		</div>
	</header>

	<div class="content">
		<?php the_content(); ?>
	</div>

	<div class="meta meta_footer">
		<span class="tags">
			<?php 
				if( $tags = get_the_tags() ) {					
					foreach( $tags as $tag ) {
					    $sep = ( $tag === end( $tags ) ) ? '' : ', ';
					    echo '<a href="' . get_term_link( $tag, $tag->taxonomy ) . '">#' . $tag->name . '</a>' . $sep;
					}
				} 
			?>
		</span>
	</div>

	<div class="clearfix"></div>
</div>

<div class="post_navs">
	<?php 
		$prev_post = get_previous_post();
		if (!empty( $prev_post )):
	?>
	<div class="prev_post">
		<span>ARTIGO ANTERIOR</span>
		<?php previous_post_link('%link','%title', TRUE); ?>
	</div>
	<?php endif; ?>
	<?php 
		$next_post = get_next_post();
		if ( is_a( $next_post , 'WP_Post' ) ): 
	?>
	<div class="next_post">
		<span>PRÓXIMO ARTIGO</span>
		<?php next_post_link('%link','%title', TRUE); ?>
	</div>
	<?php endif; ?>
</div>

<div class="comentarios">
	<?php comments_template(); ?> 
</div>