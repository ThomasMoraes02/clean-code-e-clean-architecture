<?php 

use Auth\Domain\Entities\User;

test('Deve criar um usuário', function() {
    $user = User::create("Thomas Moraes", "thomas@gmail.com", "abc123");
    $isValidPassword = $user->validatePassword("abc123");
    expect($isValidPassword)->toBeTrue();
});

test("Deve criar um usuário persistido do banco de dados", function() {
    $user = User::restore("abc123123123", "Thomas Moraes", "thomas@gmail.com", '$argon2id$v=19$m=65536,t=4,p=1$UElCZ2NSdXpWVUFmaURtOA$0xru+nIT/8BFi6Aw9W+fstIS8FOgkP+1s5vFq+UgV/A',PASSWORD_ARGON2ID);
    $isValidPassword = $user->validatePassword("abc123");
    expect($isValidPassword)->toBeTrue();
});