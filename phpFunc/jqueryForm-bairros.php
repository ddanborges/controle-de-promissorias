<?php

include "config.php";

if(!isset($_POST["tipo"]) || !isset($_POST["variavel"])) {
	echo "Metodo inválido, variaveis do JS nao setadas";	
} else {
	$tipo = $_POST["tipo"];// ex: logradouro, bairro
	$bairro = $_POST["variavel"]; // ex, maria preta, cruz das almas

	connect();

	//PARA O BAIRRO: (caso vá para varias cidades, habilitar o campo cidade. e pesquisar pelos bairros onde o codigo da cidade seja tal
	if($tipo == "bairro") {

		$query = mysqli_query($con, "SELECT * FROM bairros ORDER BY bairro ASC") or die("Erro na consulta");

		while($arr = mysqli_fetch_array($query, MYSQL_ASSOC)) {	
			echo"<option value='"; echo $arr["bairro"]; echo"'>";echo $arr["bairro"]; echo"</option>";
	
		}	
	} 

mysqli_close($con);

}

?>