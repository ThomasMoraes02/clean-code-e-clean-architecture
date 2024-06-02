<?php
namespace Whishlist\Infra\Http\Middleware;

use Throwable;
use Slim\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Exception\HttpNotFoundException;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable | RequestException $e) {
            $message = $e->getMessage();
            $stack = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
            ];
            $errors = [];

            if ($e instanceof HttpNotFoundException) $message = "Resource Not Found";
            if ($e instanceof RequestException) {
                $response = $e->getResponse();
                $errors = json_decode($response->getBody()->getContents(),true);
                if(isset($errors['error']['message'])) {
                    $message = $errors['error']['message'];
                }
            }

            $stack = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'code' => $e->getCode(),
            ];

            $error = [
                'errors' => $errors,
                'stack' => $stack
            ];

            $response = new Response();
            $statusCode = ($e->getCode() == 0) ? 404 : $e->getCode();
            $response->getBody()->write(json_encode(['errors' => ['message' => $message, 'data' => $error]]));
            return $response->withStatus($statusCode);
        }
    }
}