<?php
include "config.php";
include "extraFunctions.php";

connect();

//Vendo se alguma variavel veio fora do formulatio 
if(!isset($_POST["nome"])
|| !isset($_POST["apelido"]) 
|| !isset($_POST["telefone1"]) 
|| !isset($_POST["telefone2"]) 
|| !isset($_POST["cpf"]) 
|| !isset($_POST["rg"]) 
|| !isset($_POST["nascimento"]) 
|| !isset($_POST["registro"])
|| !isset($_POST["obs"])
) {
	echo "Método inválido, valores têm que vir do fórmulario, tente novamente<a href='clientes.php'>Voltar</a>";
	exit;
} 

//Exlpode nas datas e formatando para inserir no MYSQL.
if(!empty($_POST["nascimento"])) {	
	$nascimento = explode("/", $_POST["nascimento"]);
	$nascimentoOficial = "$nascimento[2]-$nascimento[1]-$nascimento[0]";
if(strlen($nascimento[0]) != 2 || strlen($nascimento[1]) != 2 || strlen($nascimento[2]) != 4 || $nascimento[0] > 31 || $nascimento[1] > 12 ) {
	echo "Data de nascimento inválida<a href='clientes.php'>Voltar</a>";
	exit;	
 }	
} else {
	$nascimentoOficial = NULL;	
}

if(!empty($_POST["registro"])) {
	$registro = explode("/", $_POST["registro"]);
	$registroOficial = "$registro[2]-$registro[1]-$registro[0]";
if (strlen($registro[0]) != 2 || strlen($registro[1]) != 2 || strlen($registro[2]) != 4 || $registro[0] > 31 || $registro[1] > 12) {
	echo "Data de Registro inválida<a href='clientes.php'>Voltar</a>";
	exit;
 }
} else {
	$registroOficial = NULL;	
}

if(!empty($_POST["cpf"]) && validaCPF($_POST["cpf"]) == false) {
	echo "CPF não válido<a href='clientes.php'>Voltar</a>";	
	exit;
} 

//Aqui estão CPF validados, e datas validadas. RG nao testei pq nao segue regra, agora vamos formatar tudo
$nome = $_POST["nome"];
$apelido = $_POST["apelido"];
if(isset($_POST["bairro"])) {
	$bairro = $_POST["bairro"];	
} else {
	$bairro = NULL;
}
if(isset($_POST["endereco"])) {
	$endereco = $_POST["endereco"];	
} else {
	$endereco = NULL;
}
	$obs = $_POST["obs"];
if(empty($_POST["telefone1"]) && empty($_POST["telefone2"])) {
	$telefone1 = NULL;
	$telefone2 = NULL; 	
} elseif(empty($_POST["telefone1"]) && !empty($_POST["telefone2"])) {
	$telefonePartes = explode("(",$_POST["telefone2"]);
	$telefoneParte1 = explode(")",$telefonePartes[1]); //075 = $telefoneParte1[0]
	$telefoneParteY = explode(" ",$telefoneParte1[1]);// 3631-2597 = $telefoneParteY[0]
	$telefoneParte23 = explode("-",$telefoneParteY[1]); //3631 = telefoneParte23[0], 2597 = telefoneParte23[1]
	$telefone2 = "$telefoneParte1[0]$telefoneParte23[0]$telefoneParte23[1]";
	$telefone1 = NULL;
} elseif(empty($_POST["telefone2"]) && !empty($_POST["telefone1"])) {
	$telefonePartes = explode("(",$_POST["telefone1"]);
	$telefoneParte1 = explode(")",$telefonePartes[1]); //075 = $telefoneParte1[0]
	$telefoneParteY = explode(" ",$telefoneParte1[1]);// 3631-2597 = $telefoneParteY[0]
	$telefoneParte23 = explode("-",$telefoneParteY[1]); //3631 = telefoneParte23[0], 2597 = telefoneParte23[1]
	$telefone1 = "$telefoneParte1[0]$telefoneParte23[0]$telefoneParte23[1]";
	$telefone2 = NULL;
} elseif(!empty($_POST["telefone1"]) && !empty($_POST["telefone2"])) {
	$telefonePartes = explode("(",$_POST["telefone1"]);
	$telefoneParte1 = explode(")",$telefonePartes[1]); //075 = $telefoneParte1[0]
	$telefoneParteY = explode(" ",$telefoneParte1[1]);// 3631-2597 = $telefoneParteY[0]
	$telefoneParte23 = explode("-",$telefoneParteY[1]); //3631 = telefoneParte23[0], 2597 = telefoneParte23[1]
	$telefone1 = "$telefoneParte1[0]$telefoneParte23[0]$telefoneParte23[1]";
	$telefonePartes = explode("(",$_POST["telefone2"]);
	$telefoneParte1 = explode(")",$telefonePartes[1]); //075 = $telefoneParte1[0]
	$telefoneParteY = explode(" ",$telefoneParte1[1]);// 3631-2597 = $telefoneParteY[0]
	$telefoneParte23 = explode("-",$telefoneParteY[1]); //3631 = telefoneParte23[0], 2597 = telefoneParte23[1]
	$telefone2 = "$telefoneParte1[0]$telefoneParte23[0]$telefoneParte23[1]";
}
$cpf = str_pad(preg_replace('/[^0-9]/', '', $_POST["cpf"]), 11, '0', STR_PAD_LEFT);
$rg = $_POST["rg"]; // A MASK DO RG NO CLIENTES.PHP SO PERMITI NUMEROS, dai ja ta formatado


//inserindo valores
$cadastrarCliente = mysqli_query($con, "INSERT INTO clientes VALUES( NULL, '$nome', '$apelido', '$endereco', '$bairro', '$telefone1', '$telefone2', '$cpf', '$rg', '$nascimentoOficial', '$registroOficial', '$obs')");

if(!$cadastrarCliente) {
	printf("Error: %s\n", mysqli_error($con));
	echo "- </br>";
} else {
	echo "Cadastro realizado com sucesso <a href='../cadastroCliente.html'>Voltar</a>";
}
?>
