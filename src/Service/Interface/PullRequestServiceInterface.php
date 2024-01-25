<?php

namespace App\Service\Interface;

interface PullRequestServiceInterface
{
    /**
     * @param string $owner
     * @param string $repo
     * @return array
     */
    public function getPullRequests(string $owner, string $repo): array;
}