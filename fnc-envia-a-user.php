<?php
if(isset($_GET['form_access'])){
                                   $Estacao           = filter_var($_GET['estacao']);
                                   $CTLrelacaoA_p     = filter_var($_GET['ctl_relacao_a_p']);
                                   $IdUsuario         = filter_var($_GET['idusuario']);
                                   $nome              = filter_var($_GET['nome']);
                                   $email             = filter_var($_GET['email']);
                                   $senha             = $_GET['senha'];
								   $Alias             = filter_var($_GET['alias']);
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
   existe banco de dados para alimentar*/
if ($total_banco > 0){
/* Conexão no banco de armazenagem */
require_once 'conexDB_be.php';
/* verificar se retorna algum registro online que coincide com CTLrelacaoA_p guardado na tabela offline*/
/*Se encontrar valor em CTLrelacaoA_p, então capturo valor de CodWeb_a para promover update no registro */
try{
	   $stmte = $conecta->getConectar()->prepare("SELECT * FROM usuarios WHERE CTLrelacaoA_p = :bu LIMIT 1");
       $stmte->bindParam(':bu', $CTLrelacaoA_p);
	   $stmte->execute();
       $total = $stmte->rowCount();
	   $sexecuta = $stmte->execute();
       if($sexecuta){
           while($qregi = $stmte->fetch(PDO::FETCH_ASSOC)){
                $CodWeb_a      = $qregi['id'];				
           }
       }
   }catch(PDOException $e){
      echo 'Erro', PHP_EOL;
}
/*Se o total é maior que zero, atualiza o registro no banco web*/
if ($total > 0){
try{
	$sentenca = $conecta->getConectar()->prepare("UPDATE usuarios SET IDEstacao         = :place,  
	                                                                  CTLrelacaoA_p     = :place0,
                                                                      IdUsuario         = :place1,
                                                                      nome              = :place2,
                                                                      email             = :place3,
                                                                      senha             = :place4
								                                  WHERE id = '$CodWeb_a'");  
	                               $sentenca->bindParam(':place', $Estacao);
								   $sentenca->bindParam(':place0', $CTLrelacaoA_p);
                                   $sentenca->bindParam(':place1', $IdUsuario);
                                   $sentenca->bindParam(':place2', $nome);
                                   $sentenca->bindParam(':place3', $email);
                                   $sentenca->bindParam(':place4', md5($senha));
                                   $execut = $sentenca->execute();
if ($execut){
$retorno = "atualizado";
echo $CodWeb_a . ";" . $retorno . ";" . $CodWeb_a;
}
    }catch ( PDOException $e ) {
		var_dump( $e->getMessage() );
		echo 'Erro', PHP_EOL;
}
}else{ 
/*Se o total não é maior que zero, insere-se o registro no banco web*/
try{
	$sentenca = $conecta->getConectar()->prepare('INSERT INTO usuarios(IDEstacao,
	                                                                   CTLrelacaoA_p,
                                                                       IdUsuario,
                                                                       nome,
                                                                       email,
                                                                       senha) 
                                                               VALUES (:place,
															           :place0,
                                                                       :place1,
                                                                       :place2,
                                                                       :place3,
                                                                       :place4)');											
	                               $sentenca->bindParam(':place', $Estacao);
								   $sentenca->bindParam(':place0', $CTLrelacaoA_p);
                                   $sentenca->bindParam(':place1', $IdUsuario);
                                   $sentenca->bindParam(':place2', $nome);
                                   $sentenca->bindParam(':place3', $email);
                                   $sentenca->bindParam(':place4', md5($senha));
                                   $execut = $sentenca->execute();
if ($execut){
/* Se inseriu correto, agora iremos capturar o id para guardar no banco off-line */
try{
	   $novoid = $conecta->getConectar()->prepare("SELECT * FROM usuarios ORDER BY id Desc LIMIT 1");
       $buscaid = $novoid->execute();
       if($buscaid){
           while($reg = $novoid->fetch(PDO::FETCH_ASSOC)){
                $novo_id      = $reg['id'];		
                $residual     = $reg['id'];				
           }
		   echo $residual . ";" . $novo_id . ";" . $novo_id;
       }
   }catch(PDOException $e){
      echo 'Erro', PHP_EOL;
}
}
     }catch ( PDOException $e ) {
		var_dump( $e->getMessage() );
		echo 'Erro', PHP_EOL;
}
}
}else{
/*Chave Não Autorizada*/
$RetornoChaveInexiste = "CNA";
echo $RetornoChaveInexiste . ";" . $RetornoChaveInexiste . ";" . $RetornoChaveInexiste;
}