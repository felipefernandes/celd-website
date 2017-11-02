<?php
/**
 *  Worpdress Features
 *
 */
ini_set( 'mysql.trace_mode', 0 );
ini_set( 'upload_max_size' , '64M' );
ini_set( 'post_max_size', '64M');
ini_set( 'max_execution_time', '300' );

require_once 'includes/kint/Kint.class.php';
require_once('includes/wp_bootstrap_navwalker.php');

/* Habilita o feed RSS */
add_theme_support( 'automatic-feed-links' );

/* Habilita suporte a Imagem destacada */
add_theme_support('post-thumbnails', array('post','page','documento'));

/* Imagem destacada tamanho personalizado */
add_image_size( 'banner-pagina', 1020, 160, true );
add_image_size( 'quadrado-homepage', 262, 262, true );
add_image_size( 'retangulo-homepage', 533, 289, true );
add_image_size( 'publi-homepage', 555, 90 );
add_image_size( 'biblioteca-livro', 165, 229 );
add_image_size( 'doc-thumb', 300, 100, array('center', 'top') );


/* Habilita suporte ao menus */
register_nav_menu( 'principal', __( 'Navegação principal', 'celd2015' ) );
register_nav_menu( 'secundaria', __( 'Navegação secundária', 'celd2015' ) );


add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );
function baw_hack_wp_title_for_home( $title )
{
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return __( 'Página Inicial', 'theme_domain' ) . ' | ' . get_bloginfo( 'description' );
  } else {
  	return $title . ' | ' . get_bloginfo( 'description' );
  }
  return $title;
}

/* Cria area de Widgets */
function theme_sidebar_widgets_init() {	
	register_sidebar(array(
		'name'=> 'Lateral Sidebar',
		'id' => 'lateral_sidebar',
		'before_widget' => '<div id="%1$s" class="widget sidebox %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	));
}
add_action( 'widgets_init', 'theme_sidebar_widgets_init' );


/* Ajuste no titulo da homepage */
/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function theme_name_wp_title( $title, $sep ) {
	if ( is_feed() ) {
		return $title;
	}
	
	global $page, $paged;

	// Add the blog name
	$title .= " " . get_bloginfo( 'name', 'display' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title .= " $sep $site_description ";
	}

	// Add a page number if necessary:
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title .= " $sep " . sprintf( __( 'Página %s', '_s' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'theme_name_wp_title', 10, 2 );




/**
 * Coluna personalizada para CURSOS
 */
add_filter( 'manage_edit-curso_columns', 'my_edit_curso_columns' ) ;

function my_edit_curso_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Cursos' ),
		'autor' => __( 'Autor' ),
		'date' => __( 'Date' )
	);

	return $columns;
}

add_action( 'manage_curso_posts_custom_column', 'my_manage_curso_columns', 10, 2 );

function my_manage_curso_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'autor' column. */
		case 'autor' :

			/* Get the autors for the post. */
			$terms = get_the_terms( $post_id, 'autor' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'autor' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'autor', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'Nenhum autor selecionado' );
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}


/* 
	funcao de paginacao 
*/
if ( ! function_exists( 'my_pagination' ) ) :
	function my_pagination() {
		global $wp_query;

		$big = 999999999; // need an unlikely integer
		
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $wp_query->max_num_pages
		) );
	}
endif;



function prefix_post_radio( $post_id ) {
    $current_post = get_post( $post_id );

    // This makes sure the taxonomy is only set when a new post is created
    if ( $current_post->post_date == $current_post->post_modified ) {
        wp_set_object_terms( $post_id, 'radio-celd', 'galeria_categoria', true );
    }
}
add_action( 'save_post_radio_celd', 'prefix_post_radio' );



/* The Breadcrumbs 
 * from: http://thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin

*/

function the_breadcrumb () {
	
	// Settings
	$separator	= '&gt;';
	$id 		= 'breadcrumbs';
	$class 		= 'breadcrumbs';
	$home_title = '';
	
    // Get the query & post information
	global $post,$wp_query;
	$category = get_the_category();
	
	// Build the breadcrums
    echo '<ul id="' . $id . '" class="' . $class . '">';
	
	// Do not display on the homepage
    if ( !is_front_page() ) {
		
		// Home page
        //echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        //echo '<li class="separator separator-home"> ' . $separator . ' </li>';
		
        if ( is_single() ) {
			
			// Single post (Only display the first category)
			echo '<li class="item-cat item-cat-' . $category[0]->term_id . ' item-cat-' . $category[0]->category_nicename . '"><a class="bread-cat bread-cat-' . $category[0]->term_id . ' bread-cat-' . $category[0]->category_nicename . '" href="' . get_category_link($category[0]->term_id ) . '" title="' . $category[0]->cat_name . '">' . $category[0]->cat_name . '</a></li>';
			echo '<li class="separator separator-' . $category[0]->term_id . '"> ' . $separator . ' </li>';
			echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</span></li>';
			
        } else if ( is_category() ) {
			
			// Category page
			echo '<li class="item-current item-cat-' . $category[0]->term_id . ' item-cat-' . $category[0]->category_nicename . '"><span class="bread-current bread-cat-' . $category[0]->term_id . ' bread-cat-' . $category[0]->category_nicename . '">' . $category[0]->cat_name . '</span></li>';
			
        } else if ( is_page() ) {
			
			// Standard page
            if( $post->post_parent ){
				
				// If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
				
				// Get parents in the right order
				$anc = array_reverse($anc);
				
				// Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
					$parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
				
				// Display parent pages
                echo $parents;
				
				// Current page
                echo '<li class="item-current item-' . $post->ID . '"><span title="' . get_the_title() . '"> ' . get_the_title() . '</span></li>';
				
            } else {
				
				// Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><span class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</span></li>';
				
            }
			
        } else if ( is_tag() ) {
			
			// Tag page
			
			// Get tag information
			$term_id = get_query_var('tag_id');
			$taxonomy = 'post_tag';
			$args ='include=' . $term_id;
			$terms = get_terms( $taxonomy, $args );
			
			// Display the tag name
			echo '<li class="item-current item-tag-' . $terms[0]->term_id . ' item-tag-' . $terms[0]->slug . '"><span class="bread-current bread-tag-' . $terms[0]->term_id . ' bread-tag-' . $terms[0]->slug . '">' . $terms[0]->name . '</span></li>';
		
		} elseif ( is_day() ) {
			
			// Day archive
			
			// Year link
			echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
			echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
			
			// Month link
			echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
			echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
			
			// Day display
			echo '<li class="item-current item-' . get_the_time('j') . '"><span class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</span></li>';
			
		} else if ( is_month() ) {
			
			// Month Archive
			
			// Year link
			echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
			echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
			
			// Month display
			echo '<li class="item-month item-month-' . get_the_time('m') . '"><span class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</span></li>';
			
		} else if ( is_year() ) {
			
			// Display year archive
			echo '<li class="item-current item-current-' . get_the_time('Y') . '"><span class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</span></li>';
			
		} else if ( is_author() ) {
			
			// Auhor archive
			
			// Get the author information
			global $author;
            $userdata = get_userdata( $author );
			
			// Display author name
			echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><span class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</span></li>';
		
		} else if ( get_query_var('paged') ) {
			
			// Paginated archives
			echo '<li class="item-current item-current-' . get_query_var('paged') . '"><span class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</span></li>';
			
		} else if ( is_search() ) {
		
			// Search results page
			echo '<li class="item-current item-current-' . get_search_query() . '"><span class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</span></li>';
		
		} elseif ( is_404() ) {
			
			// 404 page
			echo '<li>' . 'Error 404' . '</li>';
		}
		
    }
    
    echo '</ul>';
	
}






function cptui_register_my_taxes_galeria_categoria() {
	register_taxonomy( 'galeria_categoria',
						array ( 0 => 'galeria', 
								1 => 'radio_celd'
						),

						array( 
							'hierarchical' => true,
							'label' => 'Categorias',
							'show_ui' => true,
							'query_var' => true,
							'show_admin_column' => false,
							'rewrite' => array(
									'slug' => 'galeria',
									'with_front' => false
								),
							'labels' => array (
							  'search_items' => 'Categorias',
							  'popular_items' => '',
							  'all_items' => '',
							  'parent_item' => '',
							  'parent_item_colon' => '',
							  'edit_item' => '',
							  'update_item' => '',
							  'add_new_item' => '',
							  'new_item_name' => '',
							  'separate_items_with_commas' => '',
							  'add_or_remove_items' => '',
							  'choose_from_most_used' => '',
							)
						)
					); 
}

add_action('init', 'cptui_register_my_taxes_galeria_categoria');



function filter_post_type_link($link, $post)
{
    if ($post->post_type != 'galeria')
        return $link;

    if ($cats = get_the_terms($post->ID, 'galeria_categoria'))
        $link = str_replace('%galeria_categoria%', array_pop($cats)->slug, $link);
    return $link;
}
add_filter('post_type_link', 'filter_post_type_link', 10, 2);



/**
 * get youtube video ID from URL
 *
 * @param string $url
 * @return string Youtube video id or FALSE if none found. 
 */
function get_youtube_video_id( $url ) {

	if (stristr($url,'youtu.be/')) {
        	preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID); 
        	return $final_ID[4]; 
	}
    else {
        	@preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD); 
        	return $IDD[5]; 
    }   
}


function get_youtube_video_image($youtube_code)
{
	// get the video code if this is an embed code	(old embed)
	preg_match('/youtube\.com\/v\/([\w\-]+)/', $youtube_code, $match);
 
	// if old embed returned an empty ID, try capuring the ID from the new iframe embed
	if($match[1] == '')
		preg_match('/youtube\.com\/embed\/([\w\-]+)/', $youtube_code, $match);
 
	// if it is not an embed code, get the video code from the youtube URL	
	if($match[1] == '')
		preg_match('/v\=(.+)&/',$youtube_code ,$match);
 
	// get the corresponding thumbnail images	
	$full_size_thumbnail_image = "http://img.youtube.com/vi/".$match[1]."/hqdefault.jpg";
	$small_thumbnail_image1 = "http://img.youtube.com/vi/".$match[1]."/default.jpg";
	$small_thumbnail_image2 = "http://img.youtube.com/vi/".$match[1]."/mqdefault.jpg";
	$small_thumbnail_image3 = "http://img.youtube.com/vi/".$match[1]."/maxresdefault.jpg";
 
	// return whichever thumbnail image you would like to retrieve
	return $full_size_thumbnail_image;		
}



// add taxonomy nicenames in body and post class
/*function taxonomy_id_class( $classes ) {
	global $post;
	foreach ( ( get_the_terms( $post->ID ) ) as $term ) {
		$classes[] = $term->slug;
	}
	return $classes;
}
add_filter( 'post_class', 'taxonomy_id_class' );*/

/**
* Add Custom Taxonomy Terms To The Post Class
*/

add_filter( 'post_class', 'wpse_2266_custom_taxonomy_post_class', 10, 3 );

if ( ! function_exists('wpse_2266_custom_taxonomy_post_class') ) {
    function wpse_2266_custom_taxonomy_post_class($classes, $class, $ID) {

        $taxonomies_args = array(
            'public' => true,
            '_builtin' => false,
        );

        $taxonomies = get_taxonomies( $taxonomies_args, 'names', 'and' );

        $terms = get_the_terms( (int) $ID, (array) $taxonomies );

        if ( ! empty( $terms ) ) {
            foreach ( (array) $terms as $order => $term ) {
                if ( ! in_array( $term->slug, $classes ) ) {
                    $classes[] = $term->slug;
                }
            }
        }

        $classes[] = 'clearfix';

        return $classes;
    }
}



/**
  *  Tipo Post Personalizado: Galeria
  *
  */
add_action('init', 'cptui_register_my_cpt_galeria');

function cptui_register_my_cpt_galeria() {
	register_post_type('galeria', array(
			'label' => 'Galeria CELD',
			'description' => '',
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'galeria', 'with_front' => true),
			'query_var' => true,
			'supports' => array('title'),
			'labels' => array (
			  'name' => 'Galeria CELD',
			  'singular_name' => 'Galeria',
			  'menu_name' => 'Galeria CELD',
			  'add_new' => 'Adicionar Novo',
			  'add_new_item' => 'Adicionar nova Galeria',
			  'edit' => 'Edit',
			  'edit_item' => 'Edit Galeria',
			  'new_item' => 'New Galeria',
			  'view' => 'View Galeria',
			  'view_item' => 'View Galeria',
			  'search_items' => 'Search Galerias',
			  'not_found' => 'No Galerias Found',
			  'not_found_in_trash' => 'No Galerias Found in Trash',
			  'parent' => 'Parent Galeria',
			)
		) 
	); 
}


/**
  *  Tipo Post Personalizado: Galeria
  *
  */
add_action('init', 'cptui_register_my_cpt_radio');

function cptui_register_my_cpt_radio() {
	register_post_type('radio_celd', array(
			'label' => 'Radio CELD',
			'description' => '',
			'public' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
			'map_meta_cap' => true,
			'hierarchical' => true,
			'rewrite' => array('slug' => 'radio_celd', 'with_front' => true),
			'query_var' => true,
			'supports' => array('title'),
			'labels' => array (
			  'name' => 'Radio CELD',
			  'singular_name' => 'Radio',
			  'menu_name' => 'Radio CELD',
			  'add_new' => 'Adicionar novo',
			  'add_new_item' => 'Adicionar Nova Sonora',
			  'edit' => 'Edit',
			  'edit_item' => 'Editar Sonora',
			  'new_item' => 'Nova Sonora',
			  'view' => 'Abrir Sonora',
			  'view_item' => 'Abrir Sonora',
			  'search_items' => 'Buscar Sonora em Radio CELD',
			  'not_found' => 'Nenhuma Sonora Encontrada',
			  'not_found_in_trash' => 'Nenhuma Sonora na Lixeira',
			  'parent' => 'Sonora Relacionada',
			)
		) 
	); 
}


add_action('init', 'cptui_register_my_cpt_destaque');
function cptui_register_my_cpt_destaque() {
	register_post_type('destaque', array(
		'label' => 'Destaques',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'destaque', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title','page-attributes'),
		'labels' => array (
		  'name' => 'Destaques',
		  'singular_name' => 'Destaque',
		  'menu_name' => 'Destaques',
		  'add_new' => 'Add Destaque',
		  'add_new_item' => 'Adicionar novo Destaque',
		  'edit' => 'Edit',
		  'edit_item' => 'Editar Destaque',
		  'new_item' => 'Novo Destaque',
		  'view' => 'Abrir Destaque',
		  'view_item' => 'Abrir Destaque',
		  'search_items' => 'Buscar Destaques',
		  'not_found' => 'Nenhum Destaques encontrado',
		  'not_found_in_trash' => 'Nenhum Destaques encontrado na lixeira',
		  'parent' => 'Destaque-pai',
		  )
		) 
	); 
}

add_action('init', 'cptui_register_my_cpt_estudo');
function cptui_register_my_cpt_estudo() {
	register_post_type('estudo', array(
		'label' => 'Programação',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'estudo', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title'),
		'labels' => array (
		  'name' => 'Programação',
		  'singular_name' => 'Estudo',
		  'menu_name' => 'Programação',
		  'add_new' => 'Add Estudo',
		  'add_new_item' => 'Add New Estudo',
		  'edit' => 'Edit',
		  'edit_item' => 'Edit Estudo',
		  'new_item' => 'New Estudo',
		  'view' => 'View Estudo',
		  'view_item' => 'View Estudo',
		  'search_items' => 'Search Programação',
		  'not_found' => 'No Programação Found',
		  'not_found_in_trash' => 'No Programação Found in Trash',
		  'parent' => 'Parent Estudo',
		  )
		) 
	); 
}

add_action('init', 'cptui_register_my_cpt_palestrante');
function cptui_register_my_cpt_palestrante() {
	register_post_type('palestrante', array(
		'label' => 'Palestrantes',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'palestrante', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title'),
		'labels' => array (
		  'name' => 'Palestrantes',
		  'singular_name' => 'Palestrante',
		  'menu_name' => 'Palestrantes',
		  'add_new' => 'Add Palestrante',
		  'add_new_item' => 'Add New Palestrante',
		  'edit' => 'Edit',
		  'edit_item' => 'Edit Palestrante',
		  'new_item' => 'New Palestrante',
		  'view' => 'View Palestrante',
		  'view_item' => 'View Palestrante',
		  'search_items' => 'Search Palestrantes',
		  'not_found' => 'No Palestrantes Found',
		  'not_found_in_trash' => 'No Palestrantes Found in Trash',
		  'parent' => 'Parent Palestrante',
		  )
		) 
	); 
}

add_action('init', 'cptui_register_my_cpt_documento');
function cptui_register_my_cpt_documento() {
	register_post_type('documento', array(
		'label' => 'Documentos',
		'description' => 'Cadastro de documentos PDF para aulas, palestras, apostilas, apresentações e etc.',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'documento', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title','thumbnail'),
		'labels' => array (
		  'name' => 'Documentos',
		  'singular_name' => 'Documento',
		  'menu_name' => 'Documentos',
		  'add_new' => 'Cadastrar novo',
		  'add_new_item' => 'Cadastrar novo documento',
		  'edit' => 'Editar',
		  'edit_item' => 'Editar informações',
		  'new_item' => 'Novo documento',
		  'view' => 'Visualizar',
		  'view_item' => 'View Documento',
		  'search_items' => 'Buscar documentos',
		  'not_found' => 'Nenhum documento encontrado',
		  'not_found_in_trash' => 'Nenhum documento encontrado na lixeira',
		  'parent' => 'Parent Documento',
		  )
		) 
	); 
}


add_action('init', 'cptui_register_my_taxes_documento_tags');
function cptui_register_my_taxes_documento_tags() {
	register_taxonomy( 'documento_tags',array (
	  0 => 'documento',
	),
	array( 'hierarchical' => false,
		'label' => 'Tags',
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => false,
		'labels' => array (
		  'search_items' => 'Tag',
		  'popular_items' => '',
		  'all_items' => '',
		  'parent_item' => '',
		  'parent_item_colon' => '',
		  'edit_item' => '',
		  'update_item' => '',
		  'add_new_item' => '',
		  'new_item_name' => '',
		  'separate_items_with_commas' => '',
		  'add_or_remove_items' => '',
		  'choose_from_most_used' => '',
		  )
		) 
 	); 
}

add_action('init', 'cptui_register_my_cpt_casa_coligada');
function cptui_register_my_cpt_casa_coligada() {
	register_post_type('casa_coligada', array(
		'label' => 'Casas Coligadas',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'casa_coligada', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title'),
		'labels' => array (
		  'name' => 'Casas Coligadas',
		  'singular_name' => 'Casa Coligada',
		  'menu_name' => 'Casas Coligadas',
		  'add_new' => 'Adicionar Nova',
		  'add_new_item' => 'Adicionar nova Casa Coligada',
		  'edit' => 'Editar',
		  'edit_item' => 'Editar Casa Coligada',
		  'new_item' => 'Nova Casa Coligada',
		  'view' => 'Visualizar Casa Coligada',
		  'view_item' => 'Visualizar Casa Coligada',
		  'search_items' => 'Buscar Casas Coligadas',
		  'not_found' => 'Nenhuma Casa Coligada Encontrada',
		  'not_found_in_trash' => 'Nenhuma Casas Coligadas Encontrada na Lixeira',
		  'parent' => 'Parent Casa Coligada',
		  )
		) 
	); 
}


add_action('init', 'cptui_register_my_cpt_parceiro');
function cptui_register_my_cpt_parceiro() {
	register_post_type('parceiro', array(
		'label' => 'Parcerios',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'parceiro', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
		'labels' => array (
		  'name' => 'Parcerios',
		  'singular_name' => '',
		  'menu_name' => 'Parcerios',
		  'add_new' => 'Cadastrar novo',
		  'add_new_item' => 'Cadastrar novo parceiro',
		  'edit' => 'Edit',
		  'edit_item' => 'Edit Parcerios',
		  'new_item' => 'New Parcerios',
		  'view' => 'View Parcerios',
		  'view_item' => 'View Parcerios',
		  'search_items' => 'Search Parcerios',
		  'not_found' => 'No Parcerios Found',
		  'not_found_in_trash' => 'No Parcerios Found in Trash',
		  'parent' => 'Parent Parcerios',
		  )
		) 
	); 
}


add_action('init', 'cptui_register_my_cpt_encontro_seminario');
function cptui_register_my_cpt_encontro_seminario() {
	register_post_type('encontro_seminario', array(
		'label' => 'Encontro/ Seminário',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'encontro_seminario', 'with_front' => true),
		'query_var' => true,
		'supports' => array('title'),
		'labels' => array (
		  'name' => 'Encontros/ Seminários',
		  'singular_name' => 'Encontro/ Seminário',
		  'menu_name' => 'Encontro/ Seminário',
		  'add_new' => 'Cadastrar novo',
		  'add_new_item' => 'Cadastrar novo Encontro/ Seminário',
		  'edit' => 'Edit',
		  'edit_item' => 'Edit Encontro/ Seminário',
		  'new_item' => 'New Encontro/ Seminário',
		  'view' => 'View Encontro/ Seminário',
		  'view_item' => 'View Encontro/ Seminário',
		  'search_items' => 'Search Encontro/ Seminário',
		  'not_found' => 'Nenhum Encontro/ Seminário Encontrado',
		  'not_found_in_trash' => 'Nenhum Encontro/ Seminário Encontrado na lixeira',
		  'parent' => 'Parent Encontro/ Seminário',
		  )
		) 
	); 
}

add_action('init', 'cptui_register_my_cpt_curso');
function cptui_register_my_cpt_curso() {
register_post_type('curso', array(
'label' => 'Cursos',
'description' => '',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => false,
'rewrite' => array('slug' => 'curso', 'with_front' => true),
'query_var' => true,
'supports' => array('title'),
'labels' => array (
  'name' => 'Cursos',
  'singular_name' => '',
  'menu_name' => 'Cursos',
  'add_new' => 'Add Cursos',
  'add_new_item' => 'Add New Cursos',
  'edit' => 'Edit',
  'edit_item' => 'Edit Cursos',
  'new_item' => 'New Cursos',
  'view' => 'View Cursos',
  'view_item' => 'View Cursos',
  'search_items' => 'Search Cursos',
  'not_found' => 'No Cursos Found',
  'not_found_in_trash' => 'No Cursos Found in Trash',
  'parent' => 'Parent Cursos',
)
) ); }

add_action('init', 'cptui_register_my_taxes_autor');
function cptui_register_my_taxes_autor() {
register_taxonomy( 'autor',array (
  0 => 'curso',
),
array( 'hierarchical' => true,
	'label' => 'Autores',
	'show_ui' => true,
	'query_var' => true,
	'show_admin_column' => false,
	'labels' => array (
  'search_items' => 'Autor',
  'popular_items' => '',
  'all_items' => '',
  'parent_item' => '',
  'parent_item_colon' => '',
  'edit_item' => '',
  'update_item' => '',
  'add_new_item' => '',
  'new_item_name' => '',
  'separate_items_with_commas' => '',
  'add_or_remove_items' => '',
  'choose_from_most_used' => '',
)
) ); 
}



/** ********************** 
 *  CUSTOM FIELDS 
 *************************
 */
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_mensagens-inspiradoras',
		'title' => 'Mensagens Inspiradoras',
		'fields' => array (
			array (
				'key' => 'field_55bbd328eba59',
				'label' => 'Mensagens Inspiradoras',
				'name' => 'mensagens_inspiradoras',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55bbd337eba5a',
						'label' => 'Mensagem',
						'name' => 'mensagem',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_55bbd34ceba5b',
						'label' => 'Autor',
						'name' => 'autor',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Adicionar',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '2',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_parceiros',
		'title' => 'Parceiros',
		'fields' => array (
			array (
				'key' => 'field_55c2163d60388',
				'label' => 'Descrição',
				'name' => 'parceiro_descricao',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_55c2165e60389',
				'label' => 'Website',
				'name' => 'parceiro_website',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'http://',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55c216886038a',
				'label' => 'Reuniões Públicas',
				'name' => 'parceiro_reunioes_publicas',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55c216b56038b',
						'label' => 'Dia da Semana',
						'name' => 'parceiro_reunioes_semana',
						'type' => 'select',
						'required' => 1,
						'column_width' => '',
						'choices' => array (
							1 => 'Domingo',
							2 => 'Segunda-feira',
							3 => 'Terça-feira',
							4 => 'Quarta-feira',
							5 => 'Quinta-feira',
							6 => 'Sexta-feira',
							7 => 'Sábado',
						),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_55c2171a6038c',
						'label' => 'Horário',
						'name' => 'parceiro_reunioes_hora',
						'type' => 'text',
						'required' => 1,
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
					array (
						'key' => 'field_55c217546038d',
						'label' => 'Estudo',
						'name' => 'parceiro_reunioes_estudo',
						'type' => 'text',
						'required' => 1,
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Adicionar novo',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'parceiro',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'permalink',
				1 => 'the_content',
				2 => 'excerpt',
				3 => 'custom_fields',
				4 => 'discussion',
				5 => 'comments',
				6 => 'revisions',
				7 => 'slug',
				8 => 'author',
				9 => 'format',
				10 => 'featured_image',
				11 => 'categories',
				12 => 'tags',
				13 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}



if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_noticias',
		'title' => 'Notícias',
		'fields' => array (
			array (
				'key' => 'field_55c1f03bd63e8',
				'label' => 'Autor',
				'name' => 'noticias_autor',
				'type' => 'text',
				'instructions' => 'Preencha esse campo no caso do autor for diferente do usuário que irá publicar a notícia.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}



if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_encontro-seminario',
		'title' => 'Encontro / Seminário',
		'fields' => array (
			array (
				'key' => 'field_55ca638b75589',
				'label' => 'Edição	/ Descrição',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55ca60c217ee2',
				'label' => 'Edição',
				'name' => 'edicao',
				'type' => 'number',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_55ca60e317ee3',
				'label' => 'Tema / Programação Completa',
				'name' => 'tema',
				'type' => 'textarea',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_55ca61e417ee6',
				'label' => 'Website',
				'name' => 'site',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => 'http://',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55ca62a617ee7',
				'label' => 'Configuração de datas',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55ca610417ee4',
				'label' => 'Data de referência',
				'name' => 'data_referencia',
				'type' => 'date_picker',
				'instructions' => 'Esta data serve como referência de ordenação. No caso do evento tiver mais de um dia marque apenas o primeiro dia.',
				'required' => 1,
				'date_format' => 'yymmdd',
				'display_format' => 'dd/mm/yy',
				'first_day' => 1,
			),
			array (
				'key' => 'field_55ca619c17ee5',
				'label' => 'Dias de evento',
				'name' => 'dias_evento',
				'type' => 'text',
				'instructions' => 'Preencha todas as datas de realização do evento. Ex. 13, 14 e 15 de fevereiro.',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'encontro_seminario',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

/* SETOR DE CURSOS */
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_setor-de-cursos',
		'title' => 'Setor de Cursos',
		'fields' => array (
			array (
				'key' => 'field_55ce2fcb900f6',
				'label' => 'Organograma',
				'name' => 'organograma_pdf',
				'type' => 'file',
				'instructions' => 'Selecione um arquivo (.pdf) do organograma de cursos.',
				'save_format' => 'url',
				'library' => 'all',
			),
			array (
				'key' => 'field_55ce520405616',
				'label' => 'Horário dos Cursos',
				'name' => 'horario_cursos',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55ce523205617',
						'label' => 'Dia da semana',
						'name' => 'dia_semana',
						'type' => 'select',
						'column_width' => '',
						'choices' => array (
							1 => 'Domingo',
							2 => 'Segunda-feira',
							3 => 'Terça-feira',
							4 => 'Quarta-feira',
							5 => 'Quinta-feira',
							7 => 'Sábado',
						),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_55ce52e205618',
						'label' => 'Horário',
						'name' => 'horario',
						'type' => 'select',
						'column_width' => '',
						'choices' => array (
							1 => '8h',
							2 => '9h',
							3 => '13h',
							4 => '15h',
							5 => '16h',
							6 => '16h40',
							7 => '17h',
							8 => '18h',
							9 => '19h30',
						),
						'default_value' => '',
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_55ce52f605619',
						'label' => 'Curso',
						'name' => 'curso',
						'type' => 'relationship',
						'column_width' => '',
						'return_format' => 'object',
						'post_type' => array (
							0 => 'curso',
						),
						'taxonomy' => array (
							0 => 'all',
						),
						'filters' => array (
							0 => 'search',
						),
						'result_elements' => array (
							0 => 'post_type',
							1 => 'post_title',
						),
						'max' => '',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-setor_cursos.php',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_cursos',
		'title' => 'Cursos',
		'fields' => array (
			array (
				'key' => 'field_55ce515e48b2d',
				'label' => 'Mini Descrição',
				'name' => 'mini_descricao',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55ce517b48b2e',
				'label' => 'Ementa (.PDF)',
				'name' => 'ementa_pdf',
				'type' => 'file',
				'save_format' => 'object',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'curso',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}


if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_blocos-em-destaque-na-homepage',
		'title' => 'Blocos em Destaque na Homepage',
		'fields' => array (
			array (
				'key' => 'field_55d861ffd8841',
				'label' => 'Quadrado ( 262 x 262 )',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55d860f68d2a6',
				'label' => 'Configuração Quadrado (Posição A)',
				'name' => 'bloco_a',
				'type' => 'post_object',
				'instructions' => 'Bloco Homepage Menor.',
				'post_type' => array (
					0 => 'all',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_55d868401892c2',
				'label' => 'Imagem',
				'name' => 'bloco_a_imagem',
				'type' => 'image',
				'instructions' => 'Tamanho recomendado: 263 x 263 pixels',
				'column_width' => '',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_55d86231d8842',
				'label' => 'Retângulo ( 533 x 289 )',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55d861868d2a8',
				'label' => 'Configuração Retângulo (Posição B)',
				'name' => 'bloco_b',
				'type' => 'post_object',
				'instructions' => 'Bloco Homepage Maior.',
				'post_type' => array (
					0 => 'all',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_55d868402013g2',
				'label' => 'Imagem',
				'name' => 'bloco_b_imagem',
				'type' => 'image',
				'instructions' => 'Tamanho recomendado: 555 x 175 pixels',
				'column_width' => '',
				'save_format' => 'id',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
			array (
				'key' => 'field_55d866d276f8e',
				'label' => 'Publicidade',
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_55d86819100c1',
				'label' => 'Banners',
				'name' => 'banners',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'field_55d86840100c2',
						'label' => 'Imagem',
						'name' => 'imagem',
						'type' => 'image',
						'instructions' => 'Tamanho: 555 x 90 pixels',
						'column_width' => '',
						'save_format' => 'id',
						'preview_size' => 'thumbnail',
						'library' => 'all',
					),
					array (
						'key' => 'field_55d86859100c3',
						'label' => 'Link',
						'name' => 'link',
						'type' => 'text',
						'column_width' => '',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => 'http://',
						'append' => '',
						'formatting' => 'html',
						'maxlength' => '',
					),
				),
				'row_min' => '',
				'row_limit' => 2,
				'layout' => 'row',
				'button_label' => 'Adicionar',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '2',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'the_content',
			),
		),
		'menu_order' => 0,
	));
}

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_biblioteca',
		'title' => 'Biblioteca',
		'fields' => array (
			array (
				'key' => 'field_55d878efdadf6',
				'label' => 'É um livro?',
				'name' => 'check_livro',
				'type' => 'select',
				'choices' => array (
					'não' => 'NÃO',
					'sim' => 'SIM',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_55d87a2ece06f',
				'label' => 'Autor do Livro',
				'name' => 'autor',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55d878efdadf6',
							'operator' => '==',
							'value' => 'sim',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55d87a49ce070',
				'label' => 'Psicografia',
				'name' => 'psicografia',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55d878efdadf6',
							'operator' => '==',
							'value' => 'sim',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55d87a5cce071',
				'label' => 'Ano de Publicação',
				'name' => 'ano_publicacao',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55d878efdadf6',
							'operator' => '==',
							'value' => 'sim',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55d87b24e2acf',
				'label' => 'Editora',
				'name' => 'editora',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55d878efdadf6',
							'operator' => '==',
							'value' => 'sim',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_55d87b9433cda',
				'label' => 'ISBN',
				'name' => 'isbn',
				'type' => 'text',
				'conditional_logic' => array (
					'status' => 1,
					'rules' => array (
						array (
							'field' => 'field_55d878efdadf6',
							'operator' => '==',
							'value' => 'sim',
						),
					),
					'allorany' => 'all',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'documento',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 39,
	));
}


if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_celd-ao-vivo',
		'title' => 'CELD ao vivo',
		'fields' => array (
			array (
				'key' => 'field_55dcf3901e116',
				'label' => '',
				'name' => 'streaming',
				'type' => 'true_false',
				'instructions' => 'Configure essa opção caso queira habilitar o streaming na homepage do site.',
				'message' => 'Habilitar',
				'default_value' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'page',
					'operator' => '==',
					'value' => '2',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}





/** 
 *  ==============================================================================================================================
 *	Funções de Apoio
 *  ==============================================================================================================================
 */


function mesPorExtenso($mes, $abrev = false) {
	switch ($mes) {
		case 1:  $output = ($abrev) ? "Jan" : "Janeiro"; 	break;
		case 2:  $output = ($abrev) ? "Fev" : "Fevereiro"; 	break;
		case 3:  $output = ($abrev) ? "Mar" : "Março"; 		break;
		case 4:  $output = ($abrev) ? "Abr" : "Abril"; 		break;
		case 5:  $output = ($abrev) ? "Mai" : "Maio"; 		break;
		case 6:  $output = ($abrev) ? "Jun" : "Junho"; 		break;
		case 7:  $output = ($abrev) ? "Jul" : "Julho"; 		break;
		case 8:  $output = ($abrev) ? "Ago" : "Agosto"; 	break;
		case 9:  $output = ($abrev) ? "Set" : "Setembro"; 	break;
		case 10: $output = ($abrev) ? "Out" : "Outubro"; 	break;
		case 11: $output = ($abrev) ? "Nov" : "Novembro"; 	break;
		case 12: $output = ($abrev) ? "Dez" : "Dezembro"; 	break;
	}
	return $output;
}

function semanaPorExtenso($semana, $acentos = false) {
	switch ($semana) {
		case 1:  $output = "domingo"; break;
		case 2:  $output = "segunda"; break;
		case 3:  $output = ($acentos) ? "terça" : "terca"; break;
		case 4:  $output = "quarta"; break;
		case 5:  $output = "quinta"; break;
		case 6:  $output = "sexta"; break;
		case 7:  $output = ($acentos) ? "sábado" : "sabado"; break;
	}
	return $output;
}

/*

*/
function traduzHorariosSetorCursos($opcao) {
	switch ($opcao) {
		case 1: $output = "8h"; break;
		case 2: $output = "9h"; break;
		case 3: $output = "13h"; break;
		case 4: $output = "15h"; break;
		case 5: $output = "16h"; break;
		case 6: $output = "16h40"; break;
		case 7: $output = "17h"; break;
		case 8: $output = "18h"; break;
		case 9: $output = "19h30"; break;
	}
	return $output;
}


function getTemplatePart($slug = null, $name = null, array $params = array()) {
    global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;

    do_action("get_template_part_{$slug}", $slug, $name);
    $templates = array();
    if (isset($name))
        $templates[] = "{$slug}-{$name}.php";

    $templates[] = "{$slug}.php";

    $_template_file = locate_template($templates, false, false);

    if (is_array($wp_query->query_vars)) {
        extract($wp_query->query_vars, EXTR_SKIP);
    }
    extract($params, EXTR_SKIP);

    require($_template_file);
}

function unique_multidim_array($array, $key){
    $temp_array = array();
    $i = 0;
    $key_array = array();
    
    foreach($array as $val){
        if(!in_array($val[$key],$key_array)){
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

/*
Here is a function to sort an array by the key of his sub-array.
*/

function sksort(&$array, $subkey="id", $sort_ascending=false) {

    if (count($array))
        $temp_array[key($array)] = array_shift($array);

    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val)
        {
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
            {
                $temp_array = array_merge(    (array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }

    if ($sort_ascending) $array = array_reverse($temp_array);

    else $array = $temp_array;
}


function aasort (&$array, $key) {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va[$key];
    }
    asort($sorter);
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
}


function insertStreamingPlayer() {
?>
	<div id="video" class="video destaque" id="001" style="background-color:#000;">		
		<iframe width="100%" height="325" style="border:0; margin:0 auto;" frameborder="0" scrolling="0" marginheight="0" marginwidth="0" src="https://www.youtube.com/embed/lfP8507t7dc?rel=0&amp;showinfo=0" allowfullscreen></iframe>

		<div class="info">            
            <div class="descricao">
                <a class="tvceld" href="<?php echo esc_url( home_url() ); ?>/estudos-espiritas/celd-ao-vivo/ajuda/" target="_blank" style="font-size:10px; text-align:center;">Problemas em assitir o vídeo ?</a>	  			
            </div>
        </div>	  	
	</div>	
<?php
}


function checkStreamingTime($semana, $hora, $min) {

	$debug = false;
	$output = false;

	if ( $debug ) {
		echo ' s ' . $semana;
		echo ' h ' . $hora;
		echo ' m ' . $min;
		echo '<br>';
	}
	

	switch ($semana) {
		case 2:
			if ( ( ($hora == 15) && ($min < 59) ) || ( ($hora == 17) && ($min < 59) ) ) {
	            $output = true;
	        }   

	        if ( ($hora == 19) && ($min > 45) ) {
	        	$output = true;
	        }

	        if ( ($hora == 20) && ($min < 45) ) {
	        	$output = true;
	        }
			break;

		case 4:
			if ( ( ($hora == 9) && ($min < 59) ) || ( ($hora == 15) && ($min < 59) ) || ( ($hora == 17) && ($min < 59) ) ) {
	            $output = true;
	        }   

	        if ( ($hora == 19) && ($min > 45) ) {
	        	$output = true;
	        }

	        if ( ($hora == 20) && ($min < 45) ) {
	        	$output = true;
	        }
			break;

		case 5:
	        if ( ($hora == 19) && ($min > 31) ) {
	        	$output = true;
	        }

	        if ( ($hora == 20) && ($min < 45) ) {
	        	$output = true;
	        }
			break;

		case 7:
			if ( ( ($hora == 10) && ($min < 59) ) || 
			     ( ($hora == 15) && ($min < 59) ) || 
			     ( ($hora == 17) && ($min < 59) ) || 
			     ( ($hora == 19) && ($min < 59) ) ) {
	            $output = true;
	        } 	
	        break;

	    default:	
	    	$output = false;
	    	break;
	}

    if ($output && $debug) {
    	echo 'OK';
    }    

    return $output;

}

/*
	Exibe o horario da PROXIMA PALESTRA se o dia for hoje e 
	não estiver no horario da palestra.							
	
	retorno: string(com horario) | boolean(false)
*/
function checkProxEstudo($horario, $semana) {

	if ( $horario !== '19:30' ) {

		if ( $horario === '17:00' ) {
			if ( ($semana === 2) || ($semana === 4) ) {
				$prox_horario = '19:30';	
			}
			elseif ($semana === 7) {
				$prox_horario = '19:00';	
			}										
		} 
		elseif ( $horario === '15:00' ) {
			$prox_horario = '17:00';	
		}
		elseif ( ($horario === '10:00') || $horario === '9:00' ) {
			$prox_horario = '15:00';	
		}
		else {
			$prox_horario = NULL;
		}		
	} 
	else {
		$prox_horario = NULL;
	}

	return $prox_horario;
}

?>