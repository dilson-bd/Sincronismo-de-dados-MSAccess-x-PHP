<?php
if(isset($_GET['form_access'])){
$Estacao     = $_GET['estacao'];
$CodWeb_a    = $_GET['codweb'];
$Alias       = filter_var($_GET['alias']);
}
/* Conexão no banco para consultar chave da estação de trabalho*/
require_once 'conexDB_chave.php';
try{
/*Objetivo é capturar o nome do banco de dados que está relacionado com a estação de trabalho*/
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
/*Se total_banco é maior que zero, é porque a estação está autorizada e 
   existe banco de dados para manter*/
if ($total_banco > 0){
/* Conexão no banco de armazenagem */
require_once 'conexDB_be.php';
try{
/*Realiza direto a exclusão em cima do id passado pela url*/
       $stmte = $conecta->getConectar()->exec("DELETE FROM usuarios WHERE id =".$_GET['codweb']);
       $excl = "Excluido";
	   echo $CodWeb_a . ";" . $excl;
   }catch(PDOException $e){
       echo 'Erro', PHP_EOL;
}
}else{
/*Chave Não Autorizada*/
$RetornoChaveInexiste = "CNA";
echo $RetornoChaveInexiste . ";" . $RetornoChaveInexiste;
}