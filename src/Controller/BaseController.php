<?php

namespace App\Controller;

use App\Repository\RatingRepository;
use App\Service\GitIssuesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BaseController extends AbstractController
{
    private $httpClient;
    private $ratingRepository;
    private $gitIssuesService;
    private $serializer;

    public function __construct(private HttpClientInterface $client, RatingRepository $ratingRepository, GitIssuesService $gitIssuesService, SerializerInterface $serializer)
    {
        $this->httpClient = $client;
        $this->ratingRepository = $ratingRepository;
        $this->gitIssuesService = $gitIssuesService;
        $this->serializer = $serializer;
    }
    #[Route('/', name: 'homepage_controller')]
    public function homePage(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('homepage.html.twig', ['title' => 'GitHub API']);
    }

    #[Route('/issues', name: 'issues_controller', methods: ['GET', 'POST'])]
    public function issue(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $issuesArray = [];
        $issue = $_POST['search'] ?? [];

        if ($issue) {
            $issuesArray = $this->gitIssuesService->searchIssues($issue);
        }

        return $this->render('issues.html.twig', ['issues' => $issuesArray]);
    }

    #[Route('/user', name: 'users_controller', methods: ['GET', 'POST'])]
    public function commit(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $userArray = [];
        $user = $_POST['search'] ?? [];

        if ($user) {
            $userArray['user'] = $this->gitIssuesService->searchUser($user);
        }

        return $this->render('user.html.twig', ['users' => $userArray]);
    }

    #[Route('/repositories', name: 'repositories_controller', methods: ['GET', 'POST'])]
    public function repository(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $repositoriesArray= [];
        $repository = $_POST['search'] ?? [];

        if ($repository) {
            $repositoriesArray = $this->gitIssuesService->searchRepositories($repository);
        }

        return $this->render('repositories.html.twig', ['repositories' => $repositoriesArray]);
    }


}
