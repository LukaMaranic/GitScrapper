<?php

namespace App\Service\Interface;

interface RepositoryServiceInterface
{
    /**
     * Get information about branches from a GitHub repository.
     *
     * @param string $user The GitHub username or organization name.
     * @param string $repo The GitHub repository name.
     *
     * @return array An array containing information about branches.
     */
    public function getBranches(string $user, string $repo): array;
}