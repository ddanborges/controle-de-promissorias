<?php
include "config.php";
include "extraFunctions.php";

connect();

//Vendo se alguma variavel veio fora do formulatio 
if(!isset($_POST["cliente"])
|| !isset($_POST["telefone"]) 
|| !isset($_POST["bairro"]) 
|| !isset($_POST["endereco"]) 
|| !isset($_POST["valor"]) 
|| !isset($_POST["lancamento"]) 
|| !isset($_POST["vencimento"]) 
) {
	echo "Método inválido, valores têm que vir do fórmulario, tente novamente<a href='clientes.php'>Voltar</a>";
	exit;
} 

//Exlpode nas datas e formatando para inserir no MYSQL.
if(!empty($_POST["lancamento"])) {	
	$lancamento = explode("/", $_POST["lancamento"]);
	$lancamentoOficial = "$lancamento[2]-$lancamento[1]-$lancamento[0]";
if(strlen($lancamento[0]) != 2 || strlen($lancamento[1]) != 2 || strlen($lancamento[2]) != 4 || $lancamento[0] > 31 || $lancamento[1] > 12 ) {
	echo "Data de lancamento inválida<a href='clientes.php'>Voltar</a>";
	exit;	
 }	
} else {
	$lancamentoOficial = NULL;	
}

if(!empty($_POST["vencimento"])) {
	$vencimento = explode("/", $_POST["vencimento"]);
	$vencimentoOficial = "$vencimento[2]-$vencimento[1]-$vencimento[0]";
if (strlen($vencimento[0]) != 2 || strlen($vencimento[1]) != 2 || strlen($vencimento[2]) != 4 || $vencimento[0] > 31 || $vencimento[1] > 12) {
	echo "Data de vencimento inválida<a href='clientes.php'>Voltar</a>";
	exit;
 }
} else {
	$vencimentoOficial = NULL;	
}

//Aqui estao Datas validadas, agora vamos testar as outras variaveis
$cliente = $_POST["cliente"];
$valor = $_POST["valor"];

if(isset($_POST["bairro"])) {
	$bairro = $_POST["bairro"];	
} else {
	$bairro = NULL;
}
if(isset($_POST["codPromissoria"])) {
	$codPromissoria = $_POST["codPromissoria"];	
} else {
	$codPromissoria = NULL;
}
if(isset($_POST["endereco"])) {
	$endereco = $_POST["endereco"];	
} else {
	$endereco = NULL;
}
if(empty($_POST["telefone"])) {
	$telefone = NULL;
} else {
	$telefonePartes = explode("(",$_POST["telefone"]);
	$telefoneParte1 = explode(")",$telefonePartes[1]); //075 = $telefoneParte1[0]
	$telefoneParteY = explode(" ",$telefoneParte1[1]);// 3631-2597 = $telefoneParteY[0]
	$telefoneParte23 = explode("-",$telefoneParteY[1]); //3631 = telefoneParte23[0], 2597 = telefoneParte23[1]
	$telefone = "$telefoneParte1[0]$telefoneParte23[0]$telefoneParte23[1]";
}

//inserindo valores
$cadastrarVendas = mysqli_query($con, "INSERT INTO vendasreceber VALUES( NULL, '$codPromissoria', '$telefone', '$cliente', '$bairro', '$endereco', 'Prazo', '$valor', '$lancamentoOficial', '$vencimentoOficial', '0')");

if(!$cadastrarVendas) {
	printf("Error: %s\n", mysqli_error($con));
	echo "- </br>";
} else {
	echo "Cadastro realizado com sucesso <a href='../cadastrarPromissoria.html'>Voltar</a>";
}
?>
