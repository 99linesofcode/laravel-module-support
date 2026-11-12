<?php

declare(strict_types=1);

namespace Lines\Support\Core\SharedKernel\ValueObjects;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Stringable;

final readonly class UserId implements Stringable
{
    public function __construct(public string $value)
    {
        // _ide_helper.php redeclares Str with Filament's macros alone, hiding isUuid from PHPStan.
        if (! Str::isUuid($value)) { // @phpstan-ignore staticMethod.notFound
            throw new InvalidArgumentException("A UserId must be a UUID, got [{$value}].");
        }
    }

    public function equals(UserId $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
