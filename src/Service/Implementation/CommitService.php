<?php

namespace App\Service\Implementation;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CommitService
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    public function getCommits(string $repo, string $user): array
    {
        $url = 'https://api.github.com/repos/' . $repo . '/' . $user . '/commits';

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