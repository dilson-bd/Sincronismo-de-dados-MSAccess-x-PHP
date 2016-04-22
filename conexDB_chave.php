<?php
/*Classe de Conexуo*/
require_once 'conexDB_class.php';
/*Argumentos e instanciaчуo para conexуo no banco que vai 
  informar se a estaчуo estс autorizada a enviar dados*/
require_once 'conexDB_class.php';
$pdo = new PDO('mysql:host=seuservidor;dbname=seubanco', 'seuusuario', 'suasenha');
$conecta = new conexDB_class($pdo);