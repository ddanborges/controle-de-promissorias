<?php
include "GExtenso.php";
function data_extenso ($data = false)

{

    if ($data)

    {

        $mes = date('m', strtotime($data));

    }

    else

    {

        $mes = date('m');

        $data = date('Y-m-d');

    }

    $meses = array

    (

        '01' => 'janeiro',

        '02' => 'fevereiro',

        '03' => 'março',

        '04' => 'abril',

        '05' => 'maio',

        '06' => 'junho',

        '07' => 'julho',
		
        '08' => 'agosto',

        '09' => 'setembro',

        '10' => 'outubro',

        '11' => 'novembro',

        '12' => 'dezembro'

    );

    $dias = array

    (

        0 => 'Domingo',

      1 => 'Segunda-feira',

        2 => 'Terça-feira',

        3 => 'Quarta-feira',

        4 => 'Quinta-feira',

        5 => 'Sexta-feira',

        6 => 'Sábado'

    );
    //+ 0 aqui só para transformar os meses 01 em 1, e a classe GExtenso nao dar erro.
    return  GExtenso::numero(date('d', strtotime($data))+0) . ' de ' . $meses[$mes] . ' de ' . GExtenso::numero(date('Y', strtotime($data)));

}
// MODELO DE PEDIR DADO DE SAÍDA: data_extenso('2011-09-01');

// Função que valida o CPF
function validaCPF($cpf)
{	// Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(preg_replace('/[^0-9]/', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
	return false;
    }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

function listaBairros($bairro, $i) {
echo "<select name='bairro' id='bairro' onBlur=\"javascript: logradouros('a$i');\"><option value='$bairro' selected='selected'>$bairro</option>";
	
$queryBairros = mysql_query("SELECT bairro FROM bairros");
$numRowsBairros = mysql_num_rows($queryBairros);

for($a=1;$a<=$numRowsBairros;$a++) {
$queryBairros2 = mysql_query("SELECT bairro FROM bairros WHERE cod = '$a'"); //ESSA PARTE AQUI QUE COLOCA ATÉ O QUE DELETOU. solucao seria verificar se existe linha com o ID referido aintes de lançar.
$arrayBairros = mysql_fetch_array($queryBairros2);
$nomeBairro = $arrayBairros["bairro"];
echo "<option value='$nomeBairro'>$nomeBairro</option>";
 }
echo "</select>";
}
 ?>
 
 