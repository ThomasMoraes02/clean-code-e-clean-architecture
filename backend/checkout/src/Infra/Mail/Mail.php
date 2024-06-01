<?php 
namespace Checkout\Infra\Mail;

interface Mail
{
    public function to(string $email, ?string $name = null): self;

    public function subject(string $subject): self;

    public function body(string $body): self;

    public function send(): void;
}