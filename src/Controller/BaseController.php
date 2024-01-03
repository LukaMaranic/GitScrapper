<?php

namespace App\Controller;

use App\Repository\RatingRepository;
use App\Service\GitHubTokenService;
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
    private GitHubTokenService $gitHubTokenService;

    public function __construct(
        HttpClientInterface $client,
        RatingRepository $ratingRepository,
        GitIssuesService $gitIssuesService,
        SerializerInterface $serializer,
        GitHubTokenService $gitHubTokenService,
    )
    {
        $this->httpClient = $client;
        $this->ratingRepository = $ratingRepository;
        $this->gitIssuesService = $gitIssuesService;
        $this->serializer = $serializer;
        $this->gitHubTokenService = $gitHubTokenService;
    }
    #[Route('/', name: 'token_controller')]
    public function homePage(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        list($responseMessage, $isProcessed)  = $this->gitHubTokenService->processToken($request);

        return $this->render('homePage.html.twig', [
            'title' => 'GitHub API',
            'responseMessage' => $responseMessage,
            'isProcessed' => $isProcessed,
        ]);
    }


    #[Route('/search', name: 'search_controller')]
    public function searchPage(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('searchPage.html.twig', ['title' => 'GitHub API']);
    }

    #[Route('/search/issues', name: 'issues_controller', methods: ['GET', 'POST'])]
    public function issue(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $issuesArray = [];
        $issue = $request->get('search') ?? [];

        if ($issue) {
            $issuesArray = $this->gitIssuesService->searchIssues($issue);
        }

        return $this->render('issues.html.twig', ['issues' => $issuesArray]);
    }

    #[Route('/search/user', name: 'users_controller', methods: ['GET', 'POST'])]
    public function commit(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $userArray = [];
        $user = $_POST['search'] ?? [];

        if ($user) {
            $userArray['user'] = $this->gitIssuesService->searchUser($user);
        }

        return $this->render('user.html.twig', ['users' => $userArray]);
    }

    #[Route('/search/repositories', name: 'repositories_controller', methods: ['GET', 'POST'])]
    public function repository(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $repositoriesArray= [];
        $repository = $_POST['search'] ?? [];

        if ($repository) {
            $repositoriesArray = $this->gitIssuesService->searchRepositories($repository);
        }

        return $this->render('repositories.html.twig', ['repositories' => $repositoriesArray]);
    }

    #[Route('/repositories', name: 'user_repositories_controller', methods: ['GET'])]
    public function userRepository(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $repositoriesArray = $this->gitIssuesService->getAuthenticatedUserRepos();

        return $this->render('userRepositories.html.twig', ['repositories' => $repositoriesArray]);
    }

    #[Route('/userRepositories/{id}', name: 'user_single_repositories_controller', methods: ['GET'])]
    public function userSingleRepository(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $repositoriesArray = $this->gitIssuesService->getAuthenticatedUserRepos();

        return $this->render('userRepositories.html.twig', ['repositories' => $repositoriesArray]);
    }


}
