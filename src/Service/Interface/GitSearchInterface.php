<?php

namespace App\Service\Interface;

interface GitSearchInterface
{
    public function searchIssues(string $issue = null);

    public function searchUser(string $user = null);

    public function searchRepositories(string $repository = null);
}