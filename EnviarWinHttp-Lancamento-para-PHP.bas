'||||||* INICIO MÓDULO ENVIAR E SICRONIZAR DADOS PARA SERVIDOR ONLINE *||||||'
'Para ver no txt indentado, desmarque a opção quebra de linha do seu editor txt
'Esse código é colocado no formulário que chamará a função WebEnviarLancamento(argumentos)
If strEnviarServidorONLINE = "Sim" Then
     On Error Resume Next
     If VerificaInternet = 1 Then
     Call qAlias
          If Nz(Len(Me.txtEstacao)) > 0 Then
            'Envia ao servidor web
             Call WebEnviarLancamento(Nz(Me.txtEstacao), Nz(Me.txt_CodWeb_b), Nz(Me.txt_CTLrelacaoA_e), Nz(Me.txt_CTLrelacaoB_p), _
                       Nz(Me.txtCódigoDoLançamento), Nz(Format(Me.DataDaTransação, "yyyy/mm/dd")), Nz(Me.CódigoDoPaciente), _
                       Nz(txtRedund_Paciente), Nz(Me.TipoDeProcedimento), Nz(Me.Procedimento), Nz(Me.Andamento), _
                       Nz(Format(Me.DataDaEntrada, "yyyy/mm/dd")), Nz(Me.LocalDoProcedimento), _
                       Nz(Me.cboSetor), Nz(Me.ProfissionalSolicitante), Nz(Format(Me.DataDaSolic, "yyyy/mm/dd")), Nz(Me.opPrioridade), Nz(Me.Mês), Nz(Me.Ano), _
                       Nz(Me.cboCodigoDoProced), Nz(Me.txtDescrCodProced), Nz(Me.cboTipoLeito), Nz(Me.txtDescrLeito), _
                       Nz(Me.txtDetalhe), Nz(Me.cboRetorno), Nz(Format(Me.txtSolicRet, "yyyy/mm/dd")), Nz(Me.cboPeriodo), _
                       Nz(Format(Me.txtDataRetorno, "yyyy/mm/dd")), Nz(Me.MesRetorno), Nz(Me.cboCID), Nz(Me.txtDesCID), _
                       Nz(Me.txtRedund_Local), Nz(Me.Anotações), Nz(Me.ProtSMSEnvioAg), Nz(Format(Me.DataFechamento, "yyyy/mm/dd")), Nz(qualAlias))
          End If
     Else
          'Se não tem internet marca para subir depois por loop
          CurrentDb.Execute "UPDATE Lançamentos SET SubirDepois_b=-1 WHERE CódigoDoLançamento=" & Me.txtCódigoDoLançamento
     End If
Else
     'Se não tem autorização para enviar dados para web, marca para subir depois por loop
      CurrentDb.Execute "UPDATE Lançamentos SET SubirDepois_b=-1 WHERE CódigoDoLançamento=" & Me.txtCódigoDoLançamento

End If