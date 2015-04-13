<?php
	include "config.php";
	
	//Se não tiver nem periodo nem Codigo de Promissoria não tem como prosseguir
	if(!isset($_POST["periodo"]) && !isset($_POST["codigoPromissoria"])) {
		echo "Metódo inválido, por favor tente novamente.";
		exit;
	} 
	//Se estiverem todos vazios, também dará problema.
	if(empty($_POST["periodo"]) && empty($_POST["codigoPromissoria"]) && !isset($_POST["cliente"]) && !isset($_POST["checkVencidas"])) {
		echo "Metódo inválido, por favor tente novamente, confira se você selecionou o cliente.";
		exit;
	} 

	connect();

	//se a buscar for por código de promissoria
	if(!empty($_POST["codigoPromissoria"]) && $_POST["checkCodigo"] == "true") {
		
		$codigoPromissoria = $_POST["codigoPromissoria"];

		$query = mysqli_query($con, "SELECT id, codigoPromissoria, cliente, valor, lancamento, vencimento FROM vendasreceber WHERE codigoPromissoria='$codigoPromissoria'");

		//Enviar mensagem se não houver nenhuma promissoria
		if(mysqli_num_rows($query) == 0) {
			echo "Não há nenhuma Promissoria com esse código.";
			exit;
		}
		
		$promissoria = mysqli_fetch_array($query, MYSQLI_ASSOC);

		$tabela =  "<table id='resultadoPesquisa' class='table table-bordered table-striped'>
		                <thead>
		                    <tr>
		                    	<th>Nome</th>
		                        <th>Valor</th>
		                        <th>Data de Lançamento</th>
		                        <th>Data de Vencimento</th>
		                        <th>Código Promissoria</th>
		                    </tr>
		                 </thead>
		                <tbody>
	                        <tr>
	                            <td>".$promissoria["cliente"]."</td>
	                            <td>".$promissoria["valor"]."</td>
	                            <td>".$promissoria["lancamento"]."</td>
	                            <td>".$promissoria["vencimento"]."</td>
	                            <td>".$promissoria["codigoPromissoria"]."</td>
	                        </tr>
	                    </tbody>
	                    <tfoot>
	                        <tr>
	                            <th>Nome</th>
	                            <th>Valor</th>
	                            <th>Data de Lançamento</th>
	                            <th>Data de Vencimento</th>
	                            <th>Código Promissoria</th>
	                        </tr>
	                    </tfoot>
                    </table>";
        echo $tabela;


	} else if($_POST["checkCodigo"] == "false") { //se a busca for por outras variaveis
		//definindo as variaveis
		if(empty($_POST["periodo"])) {
			$queryPeriodo = NULL;
		} else {
			$periodo = $_POST["periodo"];
			$datas = explode("~", $periodo);
			$inicioPeriodo = $datas[0];
			$finalPeriodo = $datas[1];
			$queryPeriodo = " AND vencimento >= '$inicioPeriodo' AND vencimento <= '$finalPeriodo'";
		}
		if(isset($_POST["cliente"]) && !empty($_POST["cliente"])) {
			$cliente = $_POST["cliente"];
			$queryCliente = " AND cliente='$cliente'";
		} else {
			$queryCliente = NULL;
		}
		if($_POST["checkVencidas"] == "true") {
			$checkVencidas = $_POST["checkVencidas"];
			$hoje = date("Y-m-d");
			$queryCheckVencidas = " AND vencimento <= '$hoje'";
		} else {
			$checkVencidas = NULL;
		}

		$query = "SELECT id, codigoPromissoria, cliente, valor, lancamento, vencimento FROM vendasreceber WHERE id != 'NULL'".$queryCliente.$queryPeriodo.$queryCheckVencidas;
		$resultado = mysqli_query($con, $query);
		$tabela =  "<table id='resultadoPesquisa' class='table table-bordered table-striped'>
		                <thead>
		                    <tr>
		                    	<th>Nome</th>
		                        <th>Valor</th>
		                        <th>Data de Lançamento</th>
		                        <th>Data de Vencimento</th>
		                        <th>Código Promissoria</th>
		                    </tr>
		                 </thead>
		                <tbody>";

		while($promissoria = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
			$tabela .= "<tr>
	                            <td>".$promissoria["cliente"]."</td>
	                            <td>".$promissoria["valor"]."</td>
	                            <td>".$promissoria["lancamento"]."</td>
	                            <td>".$promissoria["vencimento"]."</td>
	                            <td>".$promissoria["codigoPromissoria"]."</td>
	                    </tr>";
		}

		$tabela .= "</tbody>
	                    <tfoot>
	                        <tr>
	                            <th>Nome</th>
	                            <th>Valor</th>
	                            <th>Data de Lançamento</th>
	                            <th>Data de Vencimento</th>
	                            <th>Código Promissoria</th>
	                        </tr>
	                    </tfoot>
                    </table>";
        echo $tabela;
	} else {
		echo "É necessário preencher pelo menos um campo.";
	}
?>