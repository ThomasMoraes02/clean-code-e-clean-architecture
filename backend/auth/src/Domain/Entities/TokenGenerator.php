<?php 
namespace Auth\Domain\Entities;

use stdClass;
use Exception;
use Throwable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTimeInterface;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

class TokenGenerator
{
    const ALGORITHM = 'HS256';

    public function __construct(private readonly string $secretKey) {}

    public function generate(User $user, int $expiresIn, DateTimeInterface $date): string
    {
        $payload = [
            'iss' => 'auth',
            'iat' => $date->getTimestamp(),
            'exp' => ($date->getTimestamp() + $expiresIn),
            'email' => $user->email(),
        ];

        $jwt = JWT::encode($payload, $this->secretKey, self::ALGORITHM);
        return $jwt;
    }

    public function verify(string $token): stdClass 
    {
        $decoded = new stdClass();
        try {
            $decoded = JWT::decode($token,new Key($this->secretKey,self::ALGORITHM));
        } catch(ExpiredException) {
            $decoded->error = "Expired token";
        } catch(SignatureInvalidException) {
            $decoded->error = "Invalid signature";
        } catch(Throwable) {
            $decoded->error ??= "Invalid token";
        }

        if(isset($decoded->error)) throw new Exception($decoded->error,401);
        
        return $decoded;
    }
}