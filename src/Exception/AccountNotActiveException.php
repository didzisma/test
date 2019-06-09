<?php

declare(strict_types=1);

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\AccountStatusException;

/**
 * Class AccountNotActiveException
 * @package App\Exception
 */
class AccountNotActiveException extends AccountStatusException
{
    public function getMessageKey(): string
    {
        return 'Account is not active';
    }
}
