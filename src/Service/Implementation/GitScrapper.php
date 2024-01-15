<?php

namespace App\Service\Implementation;

use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GitScrapper extends AbstractWebScraper
{
    private int $score = 0;
    private string $label;

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
    function scrape(): void
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/search/issues?q=' . $this->label . '&per_page=100',
            [
                'auth_basic' => 'Bearer ' . getenv("GIT_TOKEN")
            ]
        );

        $responseArray = $response->toArray();
        $items = $responseArray['items'];
        foreach ($items as $item) {
            $this->score += $item['score'];
        }

        $this->score = $this->score / 100;

    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }



}