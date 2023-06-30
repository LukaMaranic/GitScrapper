<?php

namespace Service;

use App\Service\GitScrapper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\Response\JsonMockResponse;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GitScrapperTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testScrape()
    {

        $responseArray = array(
            "items" => array(
                array(
                    "score" => 123
                )
            )
        );

        $mockHttpClient = $this->createMock(HttpClientInterface::class);

        $mockResponse = $this->createMock(ResponseInterface::class);

        $mockHttpClient->expects($this->once())->method('request')->willReturn($mockResponse);

        $mockResponse->expects($this->once())->method('toArray')->willReturn($responseArray);

        $gitScrapper = new GitScrapper($mockHttpClient);

        $gitScrapper->setLabel('Foo');

        $gitScrapper->scrape();

        $this->assertTrue(true);
    }
}
