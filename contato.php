<?php

// Verifica se existe a variável txtnome
if (isset($_GET["txtnome"])) {
    $nome = $_GET["txtnome"];

    // Conexao com o banco de dados
    $server = "localhost";
    $user = "root";
    $senha = "password";
    $base = "agenda2";

    try{
        $pdo=new PDO("mysql:host=$server;dbname=$base","$user","$senha");
        //$conexao = mysql_connect($server, $user, $senha) or die("Erro na conexão!");
        //mysql_select_db($base);
    }catch(PDOException $e){
        echo "<script> console('$e->getMessage()')</script>";
    }

    // Verifica se a variável está vazia
    if (empty($nome)) {
        $sql = $pdo->prepare("SELECT * FROM contato");
        //$sql = "SELECT * FROM contato";
    } else {
        $nome .= "%";
        $sql = $pdo->prepare("SELECT * FROM contato WHERE nome like '$nome'");
        //$sql = "SELECT * FROM contato WHERE nome like '$nome'";
    }

    sleep(1);
    $sql->execute();
    $resultado = $sql->fetchAll();
    //$result = mysql_query($sql);
    //$cont = mysql_affected_rows($conexao);

    // Verifica se a consulta retornou linhas 
    if (!empty($resultado)) {
        // Atribui o código HTML para montar uma tabela
        $tabela = "<table border='1'>
                    <thead>
                        <tr>
                            <th>NOME</th>
                            <th>TELEFONE</th>
                            <th>CELULAR</th>
                            <th>EMAIL</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>";
        $return = "$tabela";
        // Captura os dados da consulta e inseri na tabela HTML

        foreach ($resultado as $linha) {
            $return.= "<td>" . utf8_encode($linha["NOME"]) . "</td>";
            $return.= "<td>" . utf8_encode($linha["FONE"]) . "</td>";
            $return.= "<td>" . utf8_encode($linha["CELULAR"]) . "</td>";
            $return.= "<td>" . utf8_encode($linha["EMAIL"]) . "</td>";
            $return.= "</tr>";
        }
        echo $return.="</tbody></table>";
    } else {
        // Se a consulta não retornar nenhum valor, exibi mensagem para o usuário
        echo "Não foram encontrados registros!";
    }
}
?>