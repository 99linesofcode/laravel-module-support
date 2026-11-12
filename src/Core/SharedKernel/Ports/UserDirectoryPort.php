<?php

declare(strict_types=1);

namespace Lines\Support\Core\SharedKernel\Ports;

use Lines\Support\Core\SharedKernel\DataTransferObjects\UserData;
use Lines\Support\Core\SharedKernel\ValueObjects\UserId;

/**
 * Looks up a user's details when only their id is held. laravel-module-user
 * implements it; every other module reads users through it, never directly.
 */
interface UserDirectoryPort
{
    public function find(UserId $id): ?UserData;
}
