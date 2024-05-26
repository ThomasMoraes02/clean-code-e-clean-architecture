<?php 
namespace Auth\Infra\Repository;

use Auth\Application\Repository\UserRepository;
use Auth\Domain\Entities\Email;
use Auth\Domain\Entities\User;

class UserRepositoryMemory implements UserRepository
{
    public function __construct(private array $users = []) {}

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function getByEmail(string $email): ?User
    {
        foreach($this->users as $user) {
            if($user->email() == $email) return $user;
        }
        return null;
    }
}