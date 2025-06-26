<?php
// src/models/Post.php

class Post {
    private $pdo;
    private $table_name = "posts"; // Nome da sua tabela de posts

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Método para criar um novo post
    public function create($user_id, $titulo, $corpo) {
        $query = "INSERT INTO " . $this->table_name . " (user_id, titulo, corpo) VALUES (:user_id, :titulo, :corpo)";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':corpo', $corpo);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para ler todos os posts, opcionalmente com informações do autor
    public function getAll() {
        $query = "SELECT p.*, u.apelido FROM " . $this->table_name . " p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Método para encontrar um post por ID, com informações do autor
    public function findById($id) {
        $query = "SELECT p.*, u.apelido FROM " . $this->table_name . " p JOIN users u ON p.user_id = u.id WHERE p.id = :id LIMIT 0,1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Método para atualizar um post
    public function update($id, $titulo, $corpo) {
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, corpo = :corpo WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':corpo', $corpo);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para deletar um post
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