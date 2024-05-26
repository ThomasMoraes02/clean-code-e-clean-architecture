<?php 
namespace Auth\Infra\Http\Controller;

use Auth\Application\UseCases\Login\Input as LoginInput;
use Auth\Application\UseCases\Login\Login;
use Auth\Application\UseCases\SignUp\Input as SignUpInput;
use Auth\Application\UseCases\SignUp\SignUp;
use Auth\Application\UseCases\VerifyToken\VerifyToken;
use Auth\Infra\Http\Server\HttpServer;

class AuthController
{
    public function __construct(
        private readonly HttpServer $server,
        private readonly SignUp $signUp,
        private readonly Login $login,
        private readonly VerifyToken $verifyToken
    ) {
        $this->server->on("POST", "/signup", function($params, $body, $args) {
            $input = new SignUpInput($body->name, $body->email, $body->password);
            $output = $this->signUp->execute($input);
            return ["data" => $output, "statusCode" => 201];
        });

        $this->server->on("POST", "/login", function($params, $body, $args) {
            $input = new LoginInput($body->email, $body->password);
            $output = $this->login->execute($input);
            return ["data" => $output, "statusCode" => 201];
        });

        $this->server->on("POST", "/verify", function($params, $body, $args) {
            $output = $this->verifyToken->execute($body->token);
            return ["data" => $output, "statusCode" => 200];
        });
    }
}