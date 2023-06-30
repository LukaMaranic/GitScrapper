<?php

namespace App\Controller;

use App\Entity\Rating;
use App\Repository\RatingRepository;
use App\Service\GitScrapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ScrapeController extends AbstractController
{
    private $httpClient;
    private $ratingRepository;

    public function __construct(private HttpClientInterface $client, RatingRepository $ratingRepository)
    {
        $this->httpClient = $client;
        $this->ratingRepository = $ratingRepository;
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/{label}', name: 'scrape_controller')]
    public function gitSearch($label): JsonResponse
    {

        $rating = $this->ratingRepository->findByLabelField($label);
        if (empty($rating)){
            $gitScrapper = new GitScrapper($this->client);
            $gitScrapper->setLabel($label);
            $gitScrapper->scrape();
            $score = $gitScrapper->getScore();
            $rating = new Rating();
            $rating->setLabel($label)->setScore($score);
            $this->ratingRepository->save($rating, true);
        } else {
            $score = $rating[0]->getScore();
        }

        return new JsonResponse($label . " :" . $score);
    }

}