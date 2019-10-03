<?php 
function GeraHash($qtd){ 
	$Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$QuantidadeCaracteres = strlen($Caracteres); 
	$QuantidadeCaracteres--; 
	$Hash=NULL; 
	for($x=1;$x<=$qtd;$x++){ 
			$Posicao = rand(0,$QuantidadeCaracteres); 
			$Hash .= substr($Caracteres,$Posicao,1); 
	} 
	return $Hash; 
} 

echo GeraHash(5); 