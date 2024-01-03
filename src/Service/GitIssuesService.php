<?php

namespace App\Service;

use App\Service\Interface\GitSearchInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitIssuesService implements GitSearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    public function searchIssues(string $label = null)
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/search/issues?q=' . $label . '&per_page=10',
            [
                'auth_basic' => 'Bearer ' . getenv("GIT_TOKEN")
            ]
        );

        return $response->toArray()['items'];
    }

    public function searchUser(string $user = null)
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/users/' . $user,
            [
                'auth_basic' => 'Bearer ' . getenv("GIT_TOKEN")
            ]
        );

        return $response->toArray();
    }

    public function searchRepositories(string $repository = null)
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/search/repositories?q=' . $repository . '&per_page=10',
            [
                'auth_basic' => 'Bearer ' . getenv("GIT_TOKEN")
            ]
        );

        return $response->toArray()['items'];
    }

    public function getAuthenticatedUserRepos(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/user/repos',
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