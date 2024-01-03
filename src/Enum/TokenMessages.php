<?php

namespace App\Enum;

enum TokenMessages: string {
    case TOKEN_EMPTY = 'Token field is empty. Please enter a GitHub token.';
    case TOKEN_SUCCESS = 'Token submitted successfully.';
    case TOKEN_ALREADY_SUBMITTED = 'Token already submitted.';
}
