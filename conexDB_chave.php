<?php
/*Classe de Conex�o*/
require_once 'conexDB_class.php';
/*Argumentos e instancia��o para conex�o no banco que vai 
  informar se a esta��o est� autorizada a enviar dados*/
require_once 'conexDB_class.php';
$pdo = new PDO('mysql:host=seuservidor;dbname=seubanco', 'seuusuario', 'suasenha');
$conecta = new conexDB_class($pdo);