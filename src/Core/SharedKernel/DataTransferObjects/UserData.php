<?php

declare(strict_types=1);

namespace Lines\Support\Core\SharedKernel\DataTransferObjects;

use Lines\Support\Core\SharedKernel\ValueObjects\UserId;

final readonly class UserData
{
    public function __construct(
        public UserId $id,
        public string $name,
        public string $email,
        public string $locale,
    ) {}
}
