<?php
if(isset($_GET['form_access'])){
$Estacao     = $_GET['estacao'];
$CodWeb_a    = $_GET['codweb'];
$Alias       = filter_var($_GET['alias']);
}
/* Conex�o no banco para consultar chave da esta��o de trabalho*/
require_once 'conexDB_chave.php';
try{
/*Objetivo � capturar o nome do banco de dados que est� relacionado com a esta��o de trabalho*/
	   $qstmte = $conecta->getConectar()->prepare("SELECT * FROM validar_alias  
	                                               WHERE 
												   bd_estacao = :es AND bd_alias = :al LIMIT 1");
	   $qstmte->bindParam(':es', $Estacao);
	   $qstmte->bindParam(':al', $Alias);
	   $qstmte->execute();
       $total_banco = $qstmte->rowCount();
	   $qexecuta = $qstmte->execute();
       if($qexecuta){
           while($qreg = $qstmte->fetch(PDO::FETCH_ASSOC)){
				$nome_banco  = $qreg['bd_nome'];					
           }
       }
	}catch ( PDOException $e ) {
		var_dump( $e->getMessage() );
		echo 'Erro', PHP_EOL;
}
/*Se total_banco � maior que zero, � porque a esta��o est� autorizada e 
   existe banco de dados para manter*/
if ($total_banco > 0){
/* Conex�o no banco de armazenagem */
require_once 'conexDB_be.php';
try{
/*Realiza direto a exclus�o em cima do id passado pela url*/
       $stmte = $conecta->getConectar()->exec("DELETE FROM usuarios WHERE id =".$_GET['codweb']);
       $excl = "Excluido";
	   echo $CodWeb_a . ";" . $excl;
   }catch(PDOException $e){
       echo 'Erro', PHP_EOL;
}
}else{
/*Chave N�o Autorizada*/
$RetornoChaveInexiste = "CNA";
echo $RetornoChaveInexiste . ";" . $RetornoChaveInexiste;
}