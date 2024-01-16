<?php

namespace App\Service\Implementation;

use App\Enum\TokenMessages;
use Symfony\Component\HttpFoundation\Request;

class TokenService
{
    private string $response;
    private string $token;

    public function __construct()
    {
        $token = "";

        if (isset($_ENV["GIT_TOKEN"])){
            $token = (string)$_ENV["GIT_TOKEN"];
        }

//        if (is_scalar($token) OR is_bool($token)) {
//            $token = (string)$token;
//        }

        $this->setToken("");
    }

    /**
     * @param Request $request
     * @return array<mixed>
     */
    public function processToken(Request $request): array
    {

        if ($this->getToken() !== '') {
            return ['', true];
        }

        empty($request->request->get('github_token')) ? $this->setToken('') : $this->setToken((string)$request->request->get('github_token'));

        if (empty($this->getToken())) {
            return [TokenMessages::TOKEN_EMPTY->value, false];
        }

        // Additional logic for processing the GitHub token if needed

        return [TokenMessages::TOKEN_SUCCESS->value, true];
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
