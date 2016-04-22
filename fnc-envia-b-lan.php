<?php
if(isset($_GET['form_access'])){
                                   $Estacao                 = filter_var($_GET['estacao']);
                                   $CodWeb_b                = filter_var($_GET['codweb_b_p']);
                                   $CTLrelacaoA_e           = filter_var($_GET['ctl_relacao_a_e']);
                                   $CTLrelacaoB_p           = filter_var($_GET['ctl_relacao_b_p']);
                                   $CódigoDoLançamento      = filter_var($_GET['codlanc']);
                                   $DataDaTransação         = filter_var($_GET['dataproc']);
                                   $CódigoDoPaciente        = filter_var($_GET['codpac']);
                                   $Paciente                = filter_var($_GET['pac']);
                                   $TipoDeProcedimento      = filter_var($_GET['tipoproc']);
                                   $Procedimento            = filter_var($_GET['proc']);
                                   $Andamento               = filter_var($_GET['andamento']);
                                   $DataDaEntrada           = filter_var($_GET['dataentrada']);
                                   $LocalDoProcedimento     = filter_var($_GET['localproc']);
                                   $Setor                   = filter_var($_GET['setor']);
                                   $ProfissionalSolicitante = filter_var($_GET['profsolic']);
                                   $DataDaSolic             = filter_var($_GET['datasolic']);
                                   $Prioridade              = filter_var($_GET['prioridade']);
								   $Mes                     = filter_var($_GET['mes']);
								   $Ano                     = filter_var($_GET['ano']);
                                   $CodigoDoProced          = filter_var($_GET['codproced']);
								   $DescrCodProced          = filter_var($_GET['descproced']);
								   $TipoLeito               = filter_var($_GET['tipoleito']);
                                   $DescrLeito              = filter_var($_GET['descleito']);
								   $Detalhe                 = filter_var($_GET['detalhe']);
								   $Retorno_SN              = filter_var($_GET['retornosn']);
                                   $DataSolicRet            = filter_var($_GET['datasolicret']);
								   $PeriodoRetorno          = filter_var($_GET['periodoret']);
								   $DataMarcarRet           = filter_var($_GET['datamarcaret']);
                                   $MesRetorno              = filter_var($_GET['mesret']);
								   $Cid10                   = filter_var($_GET['cid']);
								   $DescricaoCID10          = filter_var($_GET['descid']);
                                   $LocalArq                = filter_var($_GET['localarq']);
								   $Anotações               = filter_var($_GET['anotacoes']);
                                   $ProtSMSEnvioAg          = filter_var($_GET['protsms']);
								   $DataFechamento          = filter_var($_GET['fechamento']); 
								   $Alias                   = filter_var($_GET['alias']);
}
$total_banco = 0;
$total = 0;
$etotal = 0;
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
if ($CodWeb_b > 0){
$total = 1;
}else{
/*Se CodWeb_a não é maior que zero, verifico se retorna algum registro online que coincide com CTLrelacaoB_p guardado na tabela offline*/
/*Se encontrar valor em CTLrelacaoB_p, então capturo valor de CodWeb_b para promover update no registro */
try{
	   $stmte = $conecta->getConectar()->prepare("SELECT * FROM lancamentos WHERE CTLrelacaoB_p = :bu LIMIT 1");
       $stmte->bindParam(':bu', $CTLrelacaoB_p);
	   $stmte->execute();
       $total = $stmte->rowCount();
	   $sexecuta = $stmte->execute();
       if($sexecuta){
           while($qregi = $stmte->fetch(PDO::FETCH_ASSOC)){
                $CodWeb_b      = $qregi['CodWeb_b'];				
           }
       }
   }catch(PDOException $e){
      echo 'Erro', PHP_EOL;
     }
   }
}else{
/*Chave Não Autorizada*/
$retorno = "CNA";
echo $retorno . ";" . $retorno . ";" . $retorno;
}
/*Se o total é maior que zero, atualiza o registro no banco web*/
if ($total > 0){
try{
	$sentenca = $conecta->getConectar()->prepare("UPDATE lancamentos SET IDEstacao               = :place, 
	                                                                     CTLrelacaoA_e           = :place0,
                                                                         CTLrelacaoB_p           = :place1,
                                                                         CódigoDoLançamento      = :place2,
                                                                         DataDaTransação         = :place3,
                                                                         CódigoDoPaciente        = :place4,
                                                                         Redund_Paciente         = :place5,
                                                                         TipoDeProcedimento      = :place6,
                                                                         Procedimento            = :place7,
                                                                         Andamento               = :place8,
                                                                         DataDaEntrada           = :place9,
                                                                         LocalDoProcedimento     = :place10,
                                                                         Setor                   = :place11,
                                                                         ProfissionalSolicitante = :place12,
                                                                         DataDaSolic             = :place13,
                                                                         Prioridade              = :place14,
								                                         Mes                     = :place15,
							                                             Ano                     = :place16,
                                                                         CodigoDoProced          = :place17,
								                                         DescrCodProced          = :place18,
								                                         TipoLeito               = :place19,
                                                                         DescrLeito              = :place20,
								                                         Detalhe                 = :place21,
								                                         Retorno_SN              = :place22,
                                                                         DataSolicRet            = :place23,
								                                         PeriodoRetorno          = :place24,
								                                         DataMarcarRet           = :place25,
                                                                         MesRetorno              = :place26,
								                                         Cid10                   = :place27,
								                                         DescricaoCID10          = :place28,
                                                                         Redund_Local            = :place29,
								                                         Anotações               = :place30,
																		 ProtSMSEnvioAg          = :place31,
								                                         DataFechamento          = :place32 
	                                             WHERE CodWeb_b = '$CodWeb_b'");  
	                               $sentenca->bindParam(':place', $Estacao);
								   $sentenca->bindParam(':place0', $CTLrelacaoA_e);
                                   $sentenca->bindParam(':place1', $CTLrelacaoB_p);
                                   $sentenca->bindParam(':place2', $CódigoDoLançamento);
                                   $sentenca->bindParam(':place3', $DataDaTransação); 
                                   $sentenca->bindParam(':place4', $CódigoDoPaciente);
                                   $sentenca->bindParam(':place5', $Paciente);
                                   $sentenca->bindParam(':place6', $TipoDeProcedimento);
                                   $sentenca->bindParam(':place7', $Procedimento);
                                   $sentenca->bindParam(':place8', $Andamento);
                                   $sentenca->bindParam(':place9', $DataDaEntrada);
                                   $sentenca->bindParam(':place10', $LocalDoProcedimento);
                                   $sentenca->bindParam(':place11', $Setor);
                                   $sentenca->bindParam(':place12', $ProfissionalSolicitante);
                                   $sentenca->bindParam(':place13', $DataDaSolic);
                                   $sentenca->bindParam(':place14', $Prioridade);
								   $sentenca->bindParam(':place15', $Mes);
								   $sentenca->bindParam(':place16', $Ano);
                                   $sentenca->bindParam(':place17', $CodigoDoProced);
								   $sentenca->bindParam(':place18', $DescrCodProced);
								   $sentenca->bindParam(':place19', $TipoLeito);
                                   $sentenca->bindParam(':place20', $DescrLeito);
								   $sentenca->bindParam(':place21', $Detalhe);
								   $sentenca->bindParam(':place22', $Retorno_SN);
                                   $sentenca->bindParam(':place23', $DataSolicRet);
								   $sentenca->bindParam(':place24', $PeriodoRetorno);
								   $sentenca->bindParam(':place25', $DataMarcarRet);
                                   $sentenca->bindParam(':place26', $MesRetorno);
								   $sentenca->bindParam(':place27', $Cid10);
								   $sentenca->bindParam(':place28', $DescricaoCID10);
                                   $sentenca->bindParam(':place29', $LocalArq);
								   $sentenca->bindParam(':place30', $Anotações);
                                   $sentenca->bindParam(':place31', $ProtSMSEnvioAg);
								   $sentenca->bindParam(':place32', $DataFechamento); 
                                   $execut = $sentenca->execute();
if ($execut){
$retorno = "atualizado";
echo $CodWeb_b . ";" . $retorno . ";" . $CodWeb_b;
}
    }catch ( PDOException $e ) {
		var_dump( $e->getMessage() );
		echo 'Erro', PHP_EOL;
}
}else{   
try{
/*Verificar se retorna algum registro online que coincide com o n° guardado na tabela offline*/
	   $estmte = $conecta->getConectar()->prepare("SELECT * FROM paciente WHERE CTLrelacaoA_p = :bu LIMIT 1");
       $estmte->bindParam(':bu', $CTLrelacaoA_e);
	   $estmte->execute();
       $etotal = $estmte->rowCount();
	   $eexecuta = $estmte->execute();
       if($eexecuta){
           while($ereg = $estmte->fetch(PDO::FETCH_ASSOC)){
                $CodWeb_a      = $ereg['CodWeb_a'];				
           }
       }
   }catch(PDOException $e){
      echo 'Erro', PHP_EOL;
}
/*Se o total é maior que zero, insere-se o registro no banco web*/
if ($etotal > 0){
try{
	$sentenca = $conecta->getConectar()->prepare('INSERT INTO lancamentos(IDEstacao,
	                                                                      CTLrelacaoA_e,
                                                                          CTLrelacaoB_p,
                                                                          CódigoDoLançamento,
                                                                          DataDaTransação,
                                                                          CódigoDoPaciente,
                                                                          Redund_Paciente,
                                                                          TipoDeProcedimento,
                                                                          Procedimento,
                                                                          Andamento,
                                                                          DataDaEntrada,
                                                                          LocalDoProcedimento,
                                                                          Setor,
                                                                          ProfissionalSolicitante,
                                                                          DataDaSolic,
                                                                          Prioridade,
								                                          Mes,
							                                              Ano,
                                                                          CodigoDoProced,
								                                          DescrCodProced,
								                                          TipoLeito,
                                                                          DescrLeito,
								                                          Detalhe,
								                                          Retorno_SN,
                                                                          DataSolicRet,
								                                          PeriodoRetorno,
								                                          DataMarcarRet,
                                                                          MesRetorno,
								                                          Cid10,
								                                          DescricaoCID10,
                                                                          Redund_Local,
								                                          Anotações,
																	      ProtSMSEnvioAg,
								                                          DataFechamento,
																		  CodWeb_a) 
                                                    VALUES(:place,
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
								                           :place21,
								                           :place22,
                                                           :place23,
								                           :place24,
								                           :place25,
                                                           :place26,
								                           :place27,
								                           :place28,
                                                           :place29,
								                           :place30,
														   :place31,
								                           :place32,
														   :place33)');											
	                               $sentenca->bindParam(':place', $Estacao);
								   $sentenca->bindParam(':place0', $CTLrelacaoA_e);
                                   $sentenca->bindParam(':place1', $CTLrelacaoB_p);
                                   $sentenca->bindParam(':place2', $CódigoDoLançamento);
                                   $sentenca->bindParam(':place3', $DataDaTransação); 
                                   $sentenca->bindParam(':place4', $CódigoDoPaciente);
                                   $sentenca->bindParam(':place5', $Paciente);
                                   $sentenca->bindParam(':place6', $TipoDeProcedimento);
                                   $sentenca->bindParam(':place7', $Procedimento);
                                   $sentenca->bindParam(':place8', $Andamento);
                                   $sentenca->bindParam(':place9', $DataDaEntrada);
                                   $sentenca->bindParam(':place10', $LocalDoProcedimento);
                                   $sentenca->bindParam(':place11', $Setor);
                                   $sentenca->bindParam(':place12', $ProfissionalSolicitante);
                                   $sentenca->bindParam(':place13', $DataDaSolic);
                                   $sentenca->bindParam(':place14', $Prioridade);
								   $sentenca->bindParam(':place15', $Mes);
								   $sentenca->bindParam(':place16', $Ano);
                                   $sentenca->bindParam(':place17', $CodigoDoProced);
								   $sentenca->bindParam(':place18', $DescrCodProced);
								   $sentenca->bindParam(':place19', $TipoLeito);
                                   $sentenca->bindParam(':place20', $DescrLeito);
								   $sentenca->bindParam(':place21', $Detalhe);
								   $sentenca->bindParam(':place22', $Retorno_SN);
                                   $sentenca->bindParam(':place23', $DataSolicRet);
								   $sentenca->bindParam(':place24', $PeriodoRetorno);
								   $sentenca->bindParam(':place25', $DataMarcarRet);
                                   $sentenca->bindParam(':place26', $MesRetorno);
								   $sentenca->bindParam(':place27', $Cid10);
								   $sentenca->bindParam(':place28', $DescricaoCID10);
                                   $sentenca->bindParam(':place29', $LocalArq);
								   $sentenca->bindParam(':place30', $Anotações);
                                   $sentenca->bindParam(':place31', $ProtSMSEnvioAg);
								   $sentenca->bindParam(':place32', $DataFechamento); 
								   $sentenca->bindParam(':place33', $CodWeb_a);
                                   $execut = $sentenca->execute();
if ($execut){
/* Se inseriu correto, agora iremos capturar o id para guardar no banco off-line */
               try{
	               $novoid = $conecta->getConectar()->prepare("SELECT * FROM lancamentos ORDER BY CodWeb_b DESC LIMIT 1");
                   $buscaid = $novoid->execute();
                   if($buscaid){
                      while($reg = $novoid->fetch(PDO::FETCH_ASSOC)){
                            $novo_id      = $reg['CodWeb_b'];		
                            $residual     = $reg['CodWeb_b'];				
                         }
		              echo $residual . ";" . $novo_id . ";" . $novo_id;
                    }
                  }catch(PDOException $e){
                     echo 'Erro', PHP_EOL;
                  }
            }
      }catch(PDOException $e){
          echo 'Erro', PHP_EOL;
 }
}else{
/*[Registro pai] na tbl paciente ainda não existe. Assim que subir, esse registro estará apto*/
$retorno = "RPNE";
echo $retorno . ";" . $retorno . ";" . $retorno;
}
}