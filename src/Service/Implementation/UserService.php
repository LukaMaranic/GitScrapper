<?php

namespace App\Service\Implementation;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserService implements \App\Service\Interface\UserServiceInterface
{

    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getUser(string $user): array|null
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/users/' . $user ,
            [
                'auth_basic' => 'Bearer ' . getenv("GIT_TOKEN")
            ]
        );

        return $response->toArray();
    }
}