<?php 
namespace Auth\Infra\Repository;

use Auth\Application\Repository\UserRepository;
use Auth\Domain\Entities\User;
use PDO;

class UserRepositorySqlite implements UserRepository
{
    public function __construct(private readonly PDO $pdo) {}
    
    public function getByEmail(string $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('email',$email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$user) return null;
        return User::restore($user['uuid'],$user['name'],$user['email'],$user['password']);
    }

    public function save(User $user): void
    {
        $query = "INSERT INTO users (uuid, name, email, password) VALUES (:uuid, :name, :email, :password)";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue('uuid',$user->uuid());
        $stmt->bindValue('name',$user->name());
        $stmt->bindValue('email',$user->email());
        $stmt->bindValue('password',$user->password());
        $stmt->execute();
    }
}