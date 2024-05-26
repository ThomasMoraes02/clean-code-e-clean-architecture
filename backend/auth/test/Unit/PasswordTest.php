<?php 

use Auth\Domain\Entities\Password;

test("Deve criar um senha", function() {
    $password = Password::create("abc123");
    expect($password->hash())->toBeString();
});

test("Deve validar uma senha", function() {
    $password = new Password('$argon2id$v=19$m=65536,t=4,p=1$UElCZ2NSdXpWVUFmaURtOA$0xru+nIT/8BFi6Aw9W+fstIS8FOgkP+1s5vFq+UgV/A', PASSWORD_ARGON2ID);
    $isValid = $password->validate('abc123');
    expect($isValid)->toBeTrue();
});