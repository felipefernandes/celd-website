<?php
/* Verifica se há thumbnail cadastrado para página e exibe a header com imagem personalizada */
if ( has_post_thumbnail() ) {
    $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'banner-pagina' );
    $thumb_url = $thumb['0'];
}
?>