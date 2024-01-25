<?php

namespace App\Service\Interface;

interface UserServiceInterface
{

    public function getUser(string $user): array|null;

}