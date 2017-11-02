<?php 
/**
 *  
 *  @package CELD2015
 *  
 *	LISTAGEM DE POSTS
 *
 */
?>

<section class="col-xs-12">   

	<div id="post-<?php echo $post->ID; ?>" <?php post_class(); ?>>		
		<?php 
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail_size' );
			$thumb_url = $thumb['0']; 
		?>
		<div>

			<div class="data">publicado em <?php the_time('d F Y'); ?></div>

			<a href="<?php the_permalink(); ?>" title="Link para <?php the_title(); ?>">

				<?php if (has_post_thumbnail()): ?>
				<div class="post-thumbnail">
					<img src="<?php echo $thumb_url; ?>" alt="<?php the_title(); ?>">
				</div>
				<?php endif; ?>

				<h3><?php the_title(); ?></h3>
				<div class="resumo">
					<?php the_excerpt(); ?>
				</div>

			</a>

			<?php if (!is_search()): ?>

			<div class="meta">
				<div class="tags">
					<?php the_tags('','',''); ?>
				</div>
				<div class="comentarios">
					<?php 
					$args = array(
						'post_id' => $post->ID, 
					    'count' => true 
					);
					$comments = get_comments($args);					

					if ($comments == 0):					
					?>
					<a href="<?php comments_link(); ?>">
						Nenhum comentário para esta noticia, seja o primeiro!
					</a>
					<?php else: ?>
					<a href="<?php comments_link(); ?>">
						<?php  echo $comments; ?> comentários. Fazer um novo comentário
					</a>
					<?php endif; ?>
				</div>
			</div>

			<?php endif; ?>

		</div>

	</div>

</section>