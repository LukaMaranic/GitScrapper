<?php

namespace App\Service\Interface;

interface SearchInterface
{
    /**
     * @param string|null $issue
     * @return mixed
     */
    public function searchIssues(string $issue = null);

    /**
     * @param string|null $user
     * @return mixed
     */
    public function searchUser(string $user = null);

    /**
     * @param string|null $repository
     * @return mixed
     */
    public function searchRepositories(string $repository = null);
}