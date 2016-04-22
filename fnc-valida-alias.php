<?php
/*include_once "conexao.php";*/
if(isset($_GET['form_access'])){
$alias     = $_GET['banco'];
$estacao = $_GET['estacao'];
}
/* Conexão no banco gerente para consultar o Alias*/
require_once 'conexDB_chave.php';
try{
/*Verificar se retorna algum registro online que coincide com o n° guardado na tabela offline*/
/*Sr a variavel ativou voltar numerico ativa, do contrário não ativa*/
	   $qstmte = $conecta->getConectar()->prepare("SELECT * FROM validar_alias 
	                                               WHERE 
												   bd_alias = :bu AND bd_estacao = :es LIMIT 1");
       $qstmte->bindParam(':bu', $alias);
	   $qstmte->bindParam(':es', $estacao);
	   $qstmte->execute();
       $qtotal = $qstmte->rowCount();
	   $qexecuta = $qstmte->execute();
       if($qexecuta){
           while($qreg = $qstmte->fetch(PDO::FETCH_ASSOC)){
                $residual  = $qreg['bd_nome'];
				$nome_banco  = $qreg['bd_nome'];
				$ativou      = $qreg['bd_ativou'];						
           }
       }
if ($qtotal > 0){
/*Se o total é maior que zero, atualiza o registro no banco web*/
echo $residual . ";" . $nome_banco . ";" . $ativou;
$maior_que_zero = 1;
try{
	$sentenca = $conecta->getConectar()->prepare("UPDATE validar_alias
                                                  SET
												  bd_ativou = :boo 
												  WHERE bd_alias = '$alias' AND bd_estacao = '$estacao' 
												  LIMIT 1");  
    $sentenca->bindParam(':boo', $maior_que_zero);
    $execut = $sentenca->execute();
    }catch ( PDOException $e ) {
		var_dump( $e->getMessage() );
		echo 'Erro', PHP_EOL;
}
}else{
$ativou = "Nada zero";
echo $residual . ";" . $nome_banco . ";" . $ativou;
}
}catch ( PDOException $e ) {
		var_dump( $e->getMessage() );
		echo 'Erro', PHP_EOL;
}