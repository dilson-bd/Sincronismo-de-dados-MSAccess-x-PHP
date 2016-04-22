<?php
if(isset($_GET['form_access'])){
                                   $Estacao           = filter_var($_GET['estacao']);
                                   $CodWeb_a          = filter_var($_GET['codweb_a_p']);
                                   $CTLrelacaoA_p     = filter_var($_GET['ctl_relacao_a_p']);
                                   $CodigoDoPaciente  = filter_var($_GET['codpac']);
                                   $RG                = filter_var($_GET['rg']);
                                   $Paciente          = filter_var($_GET['pac']);
                                   $OrgEmissor        = filter_var($_GET['orgemissor']);
                                   $CPF               = filter_var($_GET['cpf']);
                                   $CNS               = filter_var($_GET['cns']);
                                   $Sexo              = filter_var($_GET['sexo']);
                                   $DataDeNasc        = filter_var($_GET['nasc']);
                                   $NomeDoPai         = filter_var($_GET['pai']);
                                   $NomeDaMae         = filter_var($_GET['mae']);
                                   $NomeDoResponsavel = filter_var($_GET['resp']);
                                   $Naturalidade      = filter_var($_GET['naturalidade']);
                                   $EstadoCivil       = filter_var($_GET['estadocivil']);
                                   $Endereco          = filter_var($_GET['endereco']);
                                   $Nr                = filter_var($_GET['nr']);
                                   $Cep               = filter_var($_GET['cep']);
                                   $TelPrinc          = filter_var($_GET['telprinc']);
                                   $TelAlt            = filter_var($_GET['telalt']);
								   $Bairro            = filter_var($_GET['bairro']);
								   $MunicipioDeReside = filter_var($_GET['municipio']);
                                   $DataDoCad         = filter_var($_GET['datacad']);
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
/*Se CodWeb_a é maior que zero, é porque já existe no banco de dados*/
if ($CodWeb_a > 0){
$total = 1;
}else{
/*Se CodWeb_a não é maior que zero, verifico se retorna algum registro online que coincide com CTLrelacaoA_p guardado na tabela offline*/
/*Se encontrar valor em CTLrelacaoA_p, então capturo valor de CodWeb_a para promover update no registro */
try{
	   $stmte = $conecta->getConectar()->prepare("SELECT * FROM paciente WHERE CTLrelacaoA_p = :bu LIMIT 1");
       $stmte->bindParam(':bu', $CTLrelacaoA_p);
	   $stmte->execute();
       $total = $stmte->rowCount();
	   $sexecuta = $stmte->execute();
       if($sexecuta){
           while($qregi = $stmte->fetch(PDO::FETCH_ASSOC)){
                $CodWeb_a      = $qregi['CodWeb_a'];				
           }
       }
   }catch(PDOException $e){
      echo 'Erro', PHP_EOL;
}
}
/*Se o total é maior que zero, atualiza o registro no banco web*/
if ($total > 0){
try{
	$sentenca = $conecta->getConectar()->prepare("UPDATE paciente SET IDEstacao         = :place,  
	                                                                  CTLrelacaoA_p     = :place0,
                                                                      CodigoDoPaciente  = :place1,
                                                                      RG                = :place2,
                                                                      Paciente          = :place3,
                                                                      OrgEmissor        = :place4,
                                                                      CPF               = :place5,
                                                                      CNS               = :place6,
                                                                      Sexo              = :place7,
                                                                      DataDeNasc        = :place8,
                                                                      NomeDoPai         = :place9,
                                                                      NomeDaMae         = :place10,
                                                                      NomeDoResponsavel = :place11,
                                                                      Naturalidade      = :place12,
                                                                      EstadoCivil       = :place13,
                                                                      Endereco          = :place14,
                                                                      Nr                = :place15,
                                                                      Cep               = :place16,
                                                                      TelPrinc          = :place17,
                                                                      TelAlt            = :place18,
								                                      Bairro            = :place19,
							                                          MunicipioDeReside = :place20,
                                                                      DataDoCad         = :place21
								                                  WHERE CodWeb_a = '$CodWeb_a'");  
	                               $sentenca->bindParam(':place', $Estacao);
								   $sentenca->bindParam(':place0', $CTLrelacaoA_p);
                                   $sentenca->bindParam(':place1', $CodigoDoPaciente);
                                   $sentenca->bindParam(':place2', $RG);
                                   $sentenca->bindParam(':place3', $Paciente);
                                   $sentenca->bindParam(':place4', $OrgEmissor);
                                   $sentenca->bindParam(':place5', $CPF);
                                   $sentenca->bindParam(':place6', $CNS);
                                   $sentenca->bindParam(':place7', $Sexo);
                                   $sentenca->bindParam(':place8', $DataDeNasc);
                                   $sentenca->bindParam(':place9', $NomeDoPai);
                                   $sentenca->bindParam(':place10', $NomeDaMae);
                                   $sentenca->bindParam(':place11', $NomeDoResponsavel);
                                   $sentenca->bindParam(':place12', $Naturalidade);
                                   $sentenca->bindParam(':place13', $EstadoCivil);
                                   $sentenca->bindParam(':place14', $Endereco);
                                   $sentenca->bindParam(':place15', $Nr);
                                   $sentenca->bindParam(':place16', $Cep);
                                   $sentenca->bindParam(':place17', $TelPrinc);
                                   $sentenca->bindParam(':place18', $TelAlt);
								   $sentenca->bindParam(':place19', $Bairro);
								   $sentenca->bindParam(':place20', $MunicipioDeReside);
                                   $sentenca->bindParam(':place21', $DataDoCad);
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
	$sentenca = $conecta->getConectar()->prepare('INSERT INTO paciente(IDEstacao,
	                                                                   CTLrelacaoA_p,
                                                                       CodigoDoPaciente,
                                                                       RG,
                                                                       Paciente,
                                                                       OrgEmissor,
                                                                       CPF,
                                                                       CNS,
                                                                       Sexo,
                                                                       DataDeNasc,
                                                                       NomeDoPai,
                                                                       NomeDaMae,
                                                                       NomeDoResponsavel,
                                                                       Naturalidade,
                                                                       EstadoCivil,
                                                                       Endereco,
                                                                       Nr,
                                                                       Cep,
                                                                       TelPrinc,
                                                                       TelAlt,
								                                       Bairro,
							                                           MunicipioDeReside,
                                                                       DataDoCad) 
                                                               VALUES (:place,
															           :place0,
                                                                       :place1,
                                                                       :place2,
                                                                       :place3,
                                                                       :place4,
                                                                       :place5,
                                                                       :place6,
                                                                       :place7,
                                                                       :place8,
                                                                       :place9,
                                                                       :place10,
                                                                       :place11,
                                                                       :place12,
                                                                       :place13,
                                                                       :place14,
                                                                       :place15,
                                                                       :place16,
                                                                       :place17,
                                                                       :place18,
								                                       :place19,
							                                           :place20,
                                                                       :place21)');											
	                               $sentenca->bindParam(':place', $Estacao);
								   $sentenca->bindParam(':place0', $CTLrelacaoA_p);
                                   $sentenca->bindParam(':place1', $CodigoDoPaciente);
                                   $sentenca->bindParam(':place2', $RG);
                                   $sentenca->bindParam(':place3', $Paciente);
                                   $sentenca->bindParam(':place4', $OrgEmissor);
                                   $sentenca->bindParam(':place5', $CPF);
                                   $sentenca->bindParam(':place6', $CNS);
                                   $sentenca->bindParam(':place7', $Sexo);
                                   $sentenca->bindParam(':place8', $DataDeNasc);
                                   $sentenca->bindParam(':place9', $NomeDoPai);
                                   $sentenca->bindParam(':place10', $NomeDaMae);
                                   $sentenca->bindParam(':place11', $NomeDoResponsavel);
                                   $sentenca->bindParam(':place12', $Naturalidade);
                                   $sentenca->bindParam(':place13', $EstadoCivil);
                                   $sentenca->bindParam(':place14', $Endereco);
                                   $sentenca->bindParam(':place15', $Nr);
                                   $sentenca->bindParam(':place16', $Cep);
                                   $sentenca->bindParam(':place17', $TelPrinc);
                                   $sentenca->bindParam(':place18', $TelAlt);
								   $sentenca->bindParam(':place19', $Bairro);
								   $sentenca->bindParam(':place20', $MunicipioDeReside);
                                   $sentenca->bindParam(':place21', $DataDoCad);
                                   $execut = $sentenca->execute();
if ($execut){
/* Se inseriu correto, agora iremos capturar o id para guardar no banco off-line */
try{
	   $novoid = $conecta->getConectar()->prepare("SELECT * FROM paciente ORDER BY CodWeb_a Desc LIMIT 1");
       $buscaid = $novoid->execute();
       if($buscaid){
           while($reg = $novoid->fetch(PDO::FETCH_ASSOC)){
                $novo_id      = $reg['CodWeb_a'];		
                $residual     = $reg['CodWeb_a'];				
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