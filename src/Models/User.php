<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class User {

    private PDO $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function getAllUsers(): array {
        $result = $this->db->query("SELECT * FROM users");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getUserById(int $id): ?array {
        $result = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $result->execute(['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function createUser(array $data): int {
        $result = $this->db->prepare("INSERT INTO users (first_name, last_name, email, password_hash, role) VALUES (:first_name, :last_name, :email, :password_hash, :role)");
        $result->execute($data);
        return $this->db->lastInsertId();
    }

    public function updateUser(int $id, array $data): bool {
        $result = $this->db->prepare("UPDATE users SET first_name=:first_name, last_name=:last_name, email=:email, password_hash=:password_hash, role=:role WHERE id=:id");
        return $result->execute(array_merge($data, ['id' => $id]));
    }

    public function deleteUser(int $id): bool {
        $result = $this->db->prepare("DELETE FROM users WHERE id=:id");
        $result->execute(['id' => $id]);
        return $result->rowCount() > 0;
    }

    public function findByEmail(string $email): ?array {
        $result = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $result->execute(['email' => $email]);
        return $result->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
