<?php
/*Classe de Conexуo*/
require_once 'conexDB_class.php';
/*Argumentos e instanciaчуo para conexуo no banco que vai 
  armazenar os dados vindos do Software RegSaude*/
$pdo = new PDO('mysql:host=seuservidor;dbname='.$nome_banco.'', $nome_banco, 'suasenha');
$conecta = new conexDB_class($pdo);