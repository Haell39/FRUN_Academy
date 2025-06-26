<?php
// src/models/Comentario.php

class Comentario {
    private $pdo;
    private $table_name = "comentarios"; // Nome da sua tabela de comentários

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Método para criar um novo comentário
    public function create($user_id, $post_id, $texto) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, post_id, texto) VALUES (:user_id, :post_id, :texto)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->bindParam(':texto', $texto);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para obter todos os comentários de um post específico
    public function getByPostId($post_id) {
        $query = "SELECT c.*, u.apelido FROM " . $this->table_name . " c JOIN users u ON c.user_id = u.id WHERE c.post_id = :post_id ORDER BY c.created_at ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':post_id', $post_id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Método para encontrar um comentário por ID
    public function findById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Método para atualizar um comentário
    public function update($id, $texto) {
        $query = "UPDATE " . $this->table_name . " SET texto = :texto WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':texto', $texto);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para deletar um comentário
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>