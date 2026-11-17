<?php

class Category
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Returns all categories, sorted by name.
    public function getAll(): array
    {
        $stmt = $this->pdo->query('SELECT id, name FROM categories ORDER BY name');
        return $stmt->fetchAll();
    }

    // Returns one category, or null if it does not exist.
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, name FROM categories WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();
        return $category === false ? null : $category;
    }

    // Returns true if this category id exists (used to validate forms).
    public function exists(int $id): bool
    {
        return $this->findById($id) !== null;
    }
}