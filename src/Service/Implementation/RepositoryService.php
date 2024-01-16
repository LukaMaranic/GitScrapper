<?php

namespace App\Service\Implementation;

use App\Service\Interface\RepositoryServiceInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RepositoryService implements RepositoryServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    public function getBranches(string $repo, string $user): array
    {
        $url = 'https://api.github.com/repos/' . $repo . '/' . $user . '/branches';

        $response = $this->client->request(
            'GET',
            $url,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $_ENV['GIT_TOKEN'],
                    'Accept' => 'application/json',
                ],
            ]
        );

        return $response->toArray();
    }
}