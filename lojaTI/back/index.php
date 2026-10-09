<?php

header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");

require "config.php";

$rota = $_GET["rota"] ?? "teste";

function teste() {
    echo json_encode([
        "mensagem" => "Back-end respondendo"
    ]);
}
function listarClientes($con) {
    $stmt = $con->query("SELECT * FROM Clientes");
    echo json_encode(
        $stmt->fetchAll(PDO::FETCH_ASSOC),
        JSON_UNESCAPED_UNICODE
    );
}
function cadastrarCliente($con) {
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $telefone = $_POST["telefone"];
    $endereco = $_POST["endereco"];

    $stmt = $con->prepare("INSERT INTO Clientes (nome, email, telefone, endereco) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $email, $telefone, $endereco]);

    echo json_encode(
        ["mensagem" => "Cliente cadastrado com sucesso!"],
        JSON_UNESCAPED_UNICODE
    );
}
    switch ($rota) {
    case "clientes":
        listarClientes($con);
        break;
    case "clientes/create":
        cadastrarCliente($con);
        break;
    default:
        teste();
        break;
}   