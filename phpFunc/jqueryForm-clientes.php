<?php

include "config.php";

if(!isset($_POST["nomeDigitado"])) {
	echo "Metodo inválido, variaveis do JS nao setadas";	
} else {


	$nomeDigitado = $_POST["nomeDigitado"];// ex: logradouro, bairro
	connect();

		$query = mysqli_query($con, "SELECT nome FROM clientes WHERE nome LIKE '%$nomeDigitado%' LIMIT 4") or die("Erro na consulta");
		$num_resultados = mysqli_num_rows($query);

		echo "<label for='cliente'>Selecione o Cliente</label>
          	  	<select class='form-control' name='cliente' id='cliente' size='$num_resultados'>";

		while($arr = mysqli_fetch_array($query, MYSQL_ASSOC)) {	
			echo"<option value='"; echo $arr["nome"]; echo"'>";echo $arr["nome"]; echo"</option>";
	
		}
			
	echo "</select>
          	";

mysqli_close($con);

}

?>