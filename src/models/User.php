<?php
// src/models/User.php

class User {
    private $pdo;
    private $table_name = "users"; // Nome da sua tabela de usuários

    public function __construct($db) {
        $this->pdo = $db;
    }

    // Método para criar um novo usuário (usado no cadastro)
    public function create($apelido, $nome, $email, $password, $foto = 'default_profile.png', $regiao = null) {
        // SEMPRE faça hash da senha antes de salvar no banco!
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table_name . " (apelido, nome, email, password, foto, regiao) VALUES (:apelido, :nome, :email, :password, :foto, :regiao)";
        $stmt = $this->pdo->prepare($query);

        // Limpeza e binding de parâmetros para segurança
        $stmt->bindParam(':apelido', $apelido);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':regiao', $regiao);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para encontrar um usuário por email (usado no login)
    public function findByEmail($email) {
        $query = "SELECT id, apelido, nome, email, password, foto, regiao FROM " . $this->table_name . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(); // Retorna um objeto User ou false
    }

    // Método para encontrar um usuário por ID
    public function findById($id) {
        $query = "SELECT id, apelido, nome, email, foto, regiao FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Método para atualizar informações de um usuário
    public function update($id, $nome, $email, $foto = null, $regiao = null) {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, email = :email, foto = :foto, regiao = :regiao WHERE id = :id";
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':foto', $foto);
        $stmt->bindParam(':regiao', $regiao);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para deletar um usuário (geralmente para admin)
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Método para verificar a senha (para login)
    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);
        if ($user && password_verify($password, $user->password)) {
            return $user; // Retorna o objeto User se a senha estiver correta
        }
        return false;
    }
}
?>