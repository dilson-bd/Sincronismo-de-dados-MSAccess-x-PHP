'Acionar pelo form funçoes que enviarão dados por loop
'///////////////////////////////////////////////////////////////////////////////////////
If strEnviarServidorONLINE = "Sim" Then
Call WebLoopQuantOff("Paciente", "fnc-update-quantoff_pac.php")
Call WebLoopQuantOff("Lançamentos", "fnc-update-quantoff_lan.php")
Call qAlias
'Sincronizar dados do cadastro do Paciente
Call remarcarSubirDepois("Paciente", "CodWeb_a", "SubirDepois_a")
Call WebLoopDelete("Log_PacExcluidos", "CodWeb_a", "fnc-delete-a-pac.php", Nz(qualAlias))
Call WebLoopEnviarPac
'Sincronizar dados do cadastro de Procedimentos
Call remarcarSubirDepois("Lançamentos", "CodWeb_b", "SubirDepois_b")
Call WebLoopDelete("Log_LancExcluidos", "CodWeb_b", "fnc-delete-b-lan.php", Nz(qualAlias))
Call WebLoopEnviarLanc
End If