'||||||* INICIO MÓDULO ENVIAR E SICRONIZAR DADOS PARA SERVIDOR ONLINE *||||||'
If strEnviarServidorONLINE = "Sim" Then
     On Error Resume Next
     If VerificaInternet = 1 Then
     Call qAlias
          If Nz(Len(Me.txtEstacao)) > 0 Then
             'Envia ao servidor web
              Call WebEnviarPaciente(Nz(Me.txtEstacao), Nz(Me.txt_CodWeb_a), Nz(Me.txt_CTLrelacaoA_p), Nz(Me.CódigoDoPaciente), _
                       Nz(Me.RG), Nz(Me.Paciente), Nz(Me.OrgEmissor), Nz(Me.CPF), Nz(Me.CNS), _
                       Nz(Me.Sexo), Nz(Format(Me.DataDeNasc, "yyyy/mm/dd")), Nz(Me.NomeDoPai), Nz(Me.NomeDaMae), _
                       Nz(Me.NomeDoResponsável), Nz(Me.Naturalidade), Nz(Me.EstadoCivil), Nz(Me.Endereço), _
                       Nz(Me.[N°]), Nz(Me.Cep), Nz(Me.TelPrinc), Nz(Me.TelAlt), _
                       Nz(Me.Bairro), Nz(Me.MunicípioDeReside), Nz(Format(Me.DataDoCad, "yyyy/mm/dd")), Nz(qualAlias))
          End If
     End If
End If