<?php 

use Auth\Domain\Entities\Email;

test("Deve criar um email válido", function() {
    $email = new Email("thomas@gmail.com");
    expect($email->__toString())->toBe("thomas@gmail.com");
});

test("Deve lançar uma exceção ao criar um email inválido", function() {
    expect(fn() => new Email("thomas@.com"))->toThrow(Exception::class);
});