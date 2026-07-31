<?php
include(__DIR__ . '/../vendor/autoload.php');

Use App\model\Aluno;
Use App\model\Pessoa;

$pess = new Pessoa();
$pess->nome = "Allan Turing";
$pess->idade = 55;
echo $pess->nome . "<br>";
$aluno1 = new Aluno();

var_dump($aluno1);
var_dump($pess);