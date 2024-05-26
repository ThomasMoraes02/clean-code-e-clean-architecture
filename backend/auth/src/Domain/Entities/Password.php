<?php 
namespace Auth\Domain\Entities;

class Password
{
    const ALGORITHM = PASSWORD_ARGON2ID;

    public function __construct(private readonly string $password, private readonly string $salt = SELF::ALGORITHM) {}

    public static function create(string $password, ?string $salt = null): Password
    {
        $salt ??= SELF::ALGORITHM;
        $password = password_hash($password, $salt);
        return new self($password, $salt);
    }

    public function validate(string $password): bool
    {
        return password_verify($password,$this->password);
    }

    public function hash(): string
    {
        return $this->password;   
    }
}