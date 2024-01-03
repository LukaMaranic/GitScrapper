<?php

namespace App\Service;

use App\Enum\TokenMessages;
use Symfony\Component\HttpFoundation\Request;

class GitHubTokenService
{
    private string $response;
    private string $token;

    public function __construct()
    {
        $this->setToken($_ENV["GIT_TOKEN"] ?? "");
    }

    public function processToken(Request $request): array
    {

        if ($this->getToken() !== null) {
            return ['', true];
        }

        $githubToken = $request->request->get('github_token');

        if (empty($githubToken)) {
            return [TokenMessages::TOKEN_EMPTY, false];
        }

        // Additional logic for processing the GitHub token if needed

        return [TokenMessages::TOKEN_SUCCESS, true];
    }

    /**
     * @return string
     */
    public function getResponse(): string
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse(string $response): void
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

}
