<?php 

$num_aleatorio = rand(1,3);

// Carrega a base
$imagem = ImageCreateFromJPEG( "mensagens-base-00". $num_aleatorio .".jpg" );

// Carrega a fonte a ser utilizada
$fonte_mensagem = 'opensans-italic.ttf';
$fonte_autor = 'opensans.ttf';

// Define o tamanho da fonte
$tamanhofonte = 22;

// Cor de saída
$cor = imagecolorallocate( $imagem, 0, 0, 0 );
$branco = imagecolorallocate( $imagem, 255, 255, 255 );
/* @Parametros
 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
 * 255 - Cor vermelha ( RGB )
 * 255 - Cor verde ( RGB )
 * 255 - Cor azul ( RGB )
 * -- No caso acima é branco
 */

// Texto que será escrito na imagem
$mensagem = urldecode( $_GET['m'] );
$autor = urldecode( $_GET['a'] );


// Quebra a mensagem em linhas de 40 caracteres
$lines = explode('|', wordwrap($mensagem, 37, '|'));

// Posição Y inicial
$y = 70;

// Posição X inicial
$x = 40; 

// Faz um loop entre as linhas e as coloca na imagem
foreach ($lines as $line)
{
    imagettftext($imagem, $tamanhofonte, 0, $x+1.3, $y+1.3, $branco, $fonte_mensagem, $line); //faz uma sombrinha branca
    imagettftext($imagem, $tamanhofonte, 0, $x, $y, $cor, $fonte_mensagem, $line);

    // Incrementa o Y para criar a próxima linha
    $y += 30;
}

$y += 20;

// Posiciona o texto do Autor na imagem
imagettftext($imagem, 14, 0, $x+1, $y+1, $branco, $fonte_autor, $autor); //faz uma sombrinha branca
imagettftext($imagem, 14, 0, $x, $y, $cor, $fonte_autor, $autor);
/*
array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
*/

// Define o HEADER para criar a imagem
header( 'Content-type: image/jpeg' );

// Cria a imagem
imagejpeg( $imagem );
/* @Parametros
 * $imagem - Imagem previamente criada Usei imagecreatefromjpeg
 * NULL - O caminho para salvar o arquivo.
          Se não definido ou NULL, o stream da imagem será mostrado diretamente.
 * 80 - Qualidade da compresão da imagem.
 */

// Destroi a imagem para liberar memória
imagedestroy($imagem);
?>