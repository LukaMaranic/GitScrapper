<?php

namespace App\Service\Implementation;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class PullRequestService implements \App\Service\Interface\PullRequestServiceInterface
{

    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }


    /**
     * @param string $owner
     * @param string $repo
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
       public function getPullRequests(string $owner, string $repo): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/repos/' . $owner . '/' . $repo . '/pulls',
            [
                'auth_basic' => 'Bearer ' . getenv("GIT_TOKEN")
            ]
        );

        return $response->toArray();
    }
}