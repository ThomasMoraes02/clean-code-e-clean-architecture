<?php 
namespace Auth\Application\Repository;

use Auth\Domain\Entities\User;

interface UserRepository
{
    public function getByEmail(string $email): ?User;

    public function save(User $user): void;
}