<?php 
namespace Auth\Domain\Entities;

use Ramsey\Uuid\Uuid;

class User
{
    public function __construct(
        private readonly string $uuid,
        private readonly string $name, 
        private readonly Email $email, 
        private readonly Password $password
    ) {}

    public static function create(string $name, string $email, string $password): User
    {
        $uuid = Uuid::uuid4()->toString();
        return new User($uuid,$name, new Email($email),Password::create($password));
    }

    public static function restore(string $uuid, string $name, string $email, string $password): User
    {
        return new User($uuid, $name,new Email($email),new Password($password));
    }

    public function validatePassword(string $password): bool
    {
        return $this->password->validate($password);
    }

    public function uuid(): string
    {
        return $this->uuid;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password->hash();
    }
}