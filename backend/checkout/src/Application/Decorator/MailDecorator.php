<?php 
namespace Checkout\Application\Decorator;

use Checkout\Application\UseCases\UseCase;
use Checkout\Infra\Mail\Mail;
use Exception;

class MailDecorator implements UseCase
{
    public function __construct(private readonly UseCase $useCase, private readonly Mail $mail) {}

    public function execute(mixed $input): mixed
    {
        $payload = $this->useCase->execute($input);
        if($payload->email) {
            try {
                $total = number_format($payload->total, 2, '.', ',');

                $this->mail->to($payload->email)
                ->subject("Your order is ready!")
                ->body("<div>
                    <h1>Thank you for your order!</h1>
                    <p>You will receive an email with your order details.</p>
                    <p>Order ID: {$payload->uuid}</p>
                    <p>Total: US {$total}</p>
                    <p>Thank you for shopping with us!</p>
                    <p>Best regards,</p>
                    <p>The Checkout Team</p>
                </div>")
                ->send();
            }catch(Exception $e) {
                echo "Message could not be sent. Mailer Error: {$e->getMessage()}";
            }
        }
        return $payload;
    }
}