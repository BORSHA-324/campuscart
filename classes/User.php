<?php

class User
{
    private PDO $pdo;

    // The database connection is given to the class from outside.
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Returns true if this email is already registered.
    public function emailExists(string $email): bool
    {
        $stmt = $this->pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => strtolower(trim($email))]);
        return $stmt->fetch() !== false;
    }

    // Creates a new user and returns the new user's id.
    public function register(string $name, string $email, string $password): int
    {
        $name  = trim($name);
        $email = strtolower(trim($email));

        // Server-side validation (never trust the browser alone).
        if ($name === '' || strlen($name) > 100) {
            throw new InvalidArgumentException('Please enter your name (maximum 100 characters).');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) {
            throw new InvalidArgumentException('Please enter a valid email address.');
        }
        if (strlen($password) < 8) {
            throw new InvalidArgumentException('Password must be at least 8 characters long.');
        }
        if ($this->emailExists($email)) {
            throw new InvalidArgumentException('This email is already registered.');
        }

        // Never store the real password, only its hash.
        $hash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $this->pdo->prepare(
                'INSERT INTO users (name, email, password_hash) VALUES (:name, :email, :hash)'
            );
            $stmt->execute(['name' => $name, 'email' => $email, 'hash' => $hash]);
        } catch (PDOException $e) {
            // 23000 = duplicate entry, in case two people register at the same moment.
            if ($e->getCode() === '23000') {
                throw new InvalidArgumentException('This email is already registered.');
            }
            error_log('User register failed: ' . $e->getMessage());
            throw new Exception('Sorry, we could not create your account right now.');
        }

        return (int) $this->pdo->lastInsertId();
    }

    // Finds a user by email, including the password hash (used later for login).
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => strtolower(trim($email))]);
        $user = $stmt->fetch();
        return $user === false ? null : $user;
    }

    // Finds a user by id, without the password hash.
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, name, email, role, created_at FROM users WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user === false ? null : $user;
    }
}