<?php

use Auth\Application\UseCases\Login\Login;
use Auth\Application\UseCases\SignUp\SignUp;
use Auth\Infra\Repository\UserRepositoryMemory;
use Auth\Application\UseCases\Login\Input as LoginInput;
use Auth\Application\UseCases\SignUp\Input as SignUpInput;

test("Deve criar uma conta para o usuário e logar no sistema", function() {
    $userRepository = new UserRepositoryMemory();
    $signUp = new SignUp($userRepository);

    $input = new SignUpInput("Thomas Moraes", "thomas@gmail.com", "abc123");
    $signUpOutput = $signUp->execute($input);
    
    $login = new Login(
        $userRepository,
        3600, 
        "key", 
        new DateTime('2024-05-26 09:00:00',new DateTimeZone('America/Sao_Paulo'))
    );
    $input = new LoginInput('thomas@gmail.com', 'abc123');
    $output = $login->execute($input);

    expect($signUpOutput->uuid)->toBeString();
    expect($output->token)->toBeString();
});