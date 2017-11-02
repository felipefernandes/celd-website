<?php 

$imagem = imagecreatefromjpeg( "../images/mensagens-base-001.png" );
$cor = imagecolorallocate( $imagem, 0, 0, 0 );
$mensagem = urldecode( $_GET['m'] );
$autor = urldecode( $_GET['a'] );

imagestring( $imagem, 5, 15, 515, $mensagem, $cor );
header( 'Content-type: image/jpeg' );
imagejpeg( $imagem, NULL, 80 );

?>