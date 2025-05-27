<?php

// modelo para gerenciar os itens
class Item {

    // buscar todos os itens
    public static function buscarTodos() {
        $conn = conectarBD();
        $query = "SELECT * FROM vagas ORDER BY id ASC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    // busca um item pelo ID
    public static function buscarPorId($id) {
        $conn = conectarBD();
        $query = "SELECT * FROM itens WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }


    // adiciona um novo item
    public static function adicionar($nome, $pagamento, $descricao, $duracao, $dia) {
        $conn = conectarBD();
        $query = "INSERT INTO vagas (nome, pagamento, descricao, duração, dia) VALUES (:nome, :pagamento, :descricao, :duracao, :dia)";
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'nome' => $nome,
            'pagamento' => $pagamento,
            'descricao' => $descricao,
            'duracao' => $duracao,
            'dia' => $dia
        ]);
    }

    // atualiza um item
    public static function atualizar($id, $nome, $pagamento, $descricao, $duracao, $dia) {
        $conn = conectarBD();
        $query = "UPDATE vagas SET nome = :nome, pagamento = :pagamento, descricao = :descricao, duração = :duracao, dia = :dia WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute([
            'id' => $id,
            'nome' => $nome,
            'pagamento' => $pagamento,
            'descricao' => $descricao,
            'duracao' => $duracao,
            'dia' => $dia
        ]);
    }

    public static function excluir($id) {
        $conn = conectarBD();
        $query = "DELETE FROM vagas WHERE id = :id";
        $stmt = $conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}



?>
