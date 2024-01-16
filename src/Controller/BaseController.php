<?php

namespace App\Controller;

use App\Service\Implementation\CommitService;
use App\Service\Implementation\GenericConversionService;
use App\Service\Implementation\IssuesService;
use App\Service\Implementation\RepositoryService;
use App\Service\Implementation\StringManipulationService;
use App\Service\Implementation\TokenService;
use PHPUnit\Util\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private IssuesService $gitIssuesService;
    private TokenService $gitHubTokenService;
    private RepositoryService $gitHubRepositoriesService;

    public function __construct(
        IssuesService     $gitIssuesService,
        TokenService      $gitHubTokenService,
        RepositoryService $gitHubRepositoriesService,
    )
    {
        $this->gitIssuesService = $gitIssuesService;
        $this->gitHubTokenService = $gitHubTokenService;
        $this->gitHubRepositoriesService = $gitHubRepositoriesService;
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
    public function issue(Request $request, GenericConversionService $genericConversionService): \Symfony\Component\HttpFoundation\Response
    {
        $issuesArray = [];
        $mixedValue = $request->get('search');

        try {
            $issue = $genericConversionService->handleMixedToString($mixedValue);
        } catch (\InvalidArgumentException $exception){
//            throw new Exception($exception->getMessage());
            $issue = false;
        }

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

    #[Route('/user/repositories', name: 'user_repositories_controller', methods: ['GET'])]
    public function userRepository(Request $request): \Symfony\Component\HttpFoundation\Response
    {
        $repositoriesArray = $this->gitIssuesService->getAuthenticatedUserRepos();

        return $this->render('userRepositories.html.twig', ['repositories' => $repositoriesArray]);
    }

    #[Route('/user/repositories}', name: 'user_single_repositories_controller', methods: ['GET'])]
    public function userRepositories(
        Request                   $request,
        StringManipulationService $stringManipulationService,
        CommitService             $gitHubCommitService,
    ): \Symfony\Component\HttpFoundation\Response
    {
        $fullName = $request->query->get('full_name');
        $parts = explode('/', $fullName);
        $fullName = end($parts);

        $ownerUrl = $request->query->get('owner_url');

        $partsToRemove = ['https://github.com/'];

        $fullName = $stringManipulationService->removePartsFromString($fullName, $partsToRemove);
        $ownerUrl = $stringManipulationService->removePartsFromString($ownerUrl, $partsToRemove);

        $branchesArray = $this->gitHubRepositoriesService->getBranches($ownerUrl, $fullName);
        $commitsArray = $gitHubCommitService->getCommits($ownerUrl, $fullName);
        $dataArray = ['repositoryTitle' => $fullName, 'branches' => $branchesArray];

        return $this->render('singleRepository.html.twig', ['data' => $dataArray, 'commits' => $commitsArray, 'branches' => $branchesArray]);
    }

}
