<?php

declare(strict_types=1);

uses(\Lines\Support\Tests\TestCase::class, \Illuminate\Foundation\Testing\RefreshDatabase::class);

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Lines\Support\Core\SharedKernel\ValueObjects\AsUserId;
use Lines\Support\Core\SharedKernel\ValueObjects\UserId;

final class AsUserIdTestRecord extends Model
{
    protected $table = 'as_user_id_test_records';

    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return ['user_id' => AsUserId::class];
    }
}

beforeEach(function () {
    Schema::create('as_user_id_test_records', function (Blueprint $table) {
        $table->id();
        $table->uuid('user_id')->nullable();
    });
});

describe('AsUserId', function () {
    it('reads a stored user_id back as the UserId it was given', function () {
        $userId = new UserId('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');

        $record = AsUserIdTestRecord::create(['user_id' => $userId]);
        $fresh = AsUserIdTestRecord::find($record->id);

        expect($fresh->user_id)
            ->toBeInstanceOf(UserId::class)
            ->and($fresh->user_id->equals($userId))->toBeTrue()
            ->and($fresh->getRawOriginal('user_id'))->toBe('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');
    });

    it('serializes the UserId as its UUID string', function () {
        $record = AsUserIdTestRecord::create(['user_id' => new UserId('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f')]);

        expect(AsUserIdTestRecord::find($record->id)->toArray()['user_id'])
            ->toBe('9b2f6d1e-3c4a-4f5b-8e7d-1a2b3c4d5e6f');
    });

    it('passes null through', function () {
        $record = AsUserIdTestRecord::create(['user_id' => null]);
        $fresh = AsUserIdTestRecord::find($record->id);

        expect($fresh->user_id)->toBeNull();
    });
});
