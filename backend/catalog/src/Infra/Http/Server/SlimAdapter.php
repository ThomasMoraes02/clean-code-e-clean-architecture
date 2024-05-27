<?php 
namespace Catalog\Infra\Http\Server;

use Psr\Http\Server\MiddlewareInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Throwable;

class SlimAdapter implements HttpServer
{
    private readonly App $app;

    public function __construct() 
    {
        $this->app = AppFactory::create();
    }
    
    public function on(string $method, string $url, callable $callback): void
    {
        $this->app->$method($url, function(Request $request, Response $response, array $args) use ($callback) {
            // try {
            //     $body = json_decode($request->getBody());
            //     $params = $request->getQueryParams();
            
            //     $output = $callback($params, $body, $args);
                
            //     $response->getBody()->write(json_encode($output['data']));
            //     return $response->withStatus($output['statusCode']);
            // } catch(Throwable $e) {
            //     $response->getBody()->write(json_encode([
            //         "errors" => [
            //             "message" => $e->getMessage(),
            //         ]
            //     ]));
            //     return $response->withStatus(400);
            // }

            $body = json_decode($request->getBody());
            $params = $request->getQueryParams();
        
            $output = $callback($params, $body, $args);
            
            $response->getBody()->write(json_encode($output['data']));
            return $response->withStatus($output['statusCode']);
        });
    }

    public function addMiddleware(MiddlewareInterface $middleware): self
    {
        $this->app->add($middleware);
        return $this;
    }

    public function listen(): void
    {
        $this->app->run();
    }
}