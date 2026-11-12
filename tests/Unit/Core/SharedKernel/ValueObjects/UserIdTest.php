<?php

declare(strict_types=1);

uses(\Lines\Support\Tests\TestCase::class);

use Lines\Support\Core\SharedKernel\ValueObjects\UserId;

describe('UserId', function () {
    it('holds a UUID', function () {
        $id = new UserId('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');

        expect((string) $id)->toBe('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');
    });

    it('rejects a value that is not a UUID', function (string $value) {
        new UserId($value);
    })->with(['', '42', 'not-a-uuid'])->throws(InvalidArgumentException::class);

    it('equals another UserId with the same value', function () {
        $a = new UserId('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');
        $b = new UserId('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');

        expect($a->equals($b))->toBeTrue();
    });

    it('does not equal a UserId with another value', function () {
        $a = new UserId('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');
        $b = new UserId('0c1d2e3f-4a5b-4c6d-9e7f-8a9b0c1d2e3f');

        expect($a->equals($b))->toBeFalse();
    });
});
