<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ScrapeController extends AbstractController
{
//    private $httpClient;
//    private $ratingRepository;
//
//    public function __construct(private HttpClientInterface $client, RatingRepository $ratingRepository)
//    {
//        $this->httpClient = $client;
//        $this->ratingRepository = $ratingRepository;
//    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
//    #[Route('/{label}', name: 'scrape_controller')]
//    public function gitSearch($label)
//    {
//
//        $rating = $this->ratingRepository->findByLabelField($label);
//        if (empty($rating)){
//            $gitScrapper = new GitScrapper($this->client);
//            $gitScrapper->setLabel($label);
//            $gitScrapper->scrape();
//            $score = $gitScrapper->getScore();
//            $rating = new Rating();
//            $rating->setLabel($label)->setScore($score);
//            $this->ratingRepository->save($rating, true);
//        } else {
//            $score = $rating[0]->getScore();
//        }
//
//        $data = [
//            'label' => $label,
//            'score' => $score,
//        ];
//
//        return $this->render('search.html.twig', [
//            'json_data' => $data,
//        ]);
//    }

}