<?php 
namespace Auth\Application\UseCases\Login;

use Exception;
use DateTimeInterface;
use Auth\Domain\Entities\TokenGenerator;
use Auth\Application\UseCases\Login\Input;
use Auth\Application\UseCases\Login\Output;
use Auth\Application\Repository\UserRepository;

class Login
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly int $tokenExpiresIn,
        private readonly string $tokenKey,
        private readonly DateTimeInterface $date
    ) {}

    public function execute(Input $input): Output
    {
        $user = $this->userRepository->getByEmail($input->email);
        if(!$user) throw new Exception("User not found", 404);
        $isPasswordValid = $user->validatePassword($input->password);
        if(!$isPasswordValid) throw new Exception("Invalid password",400);
        $tokenGenerator = new TokenGenerator($this->tokenKey);
        $token = $tokenGenerator->generate($user, $this->tokenExpiresIn,$this->date);
        return new Output($token);
    }
}