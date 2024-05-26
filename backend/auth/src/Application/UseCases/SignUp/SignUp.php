<?php 
namespace Auth\Application\UseCases\SignUp;

use Exception;
use Auth\Domain\Entities\User;
use Auth\Application\UseCases\SignUp\Input;
use Auth\Application\UseCases\SignUp\Output;
use Auth\Application\Repository\UserRepository;

class SignUp
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function execute(Input $input): Output
    {
        if($this->userRepository->getByEmail($input->email)) throw new Exception("Email already in use",400);
        $user = User::create($input->name,$input->email,$input->password);
        $this->userRepository->save($user);
        return new Output($user->uuid());
    }
}