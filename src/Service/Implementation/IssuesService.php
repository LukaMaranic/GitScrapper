<?php

namespace App\Service\Implementation;

use App\Service\Interface\SearchInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IssuesService implements SearchInterface
{
    public function __construct(
        private readonly HttpClientInterface $client,
    )
    {
    }

    /**
     * @param string|null $label
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
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

    /**
     * @param string|null $user
     * @return array<mixed>
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function searchUser(string $user = null): array
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

    /**
     * @param string|null $repository
     * @return mixed
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
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

    /**
     * @return array<mixed>
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
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