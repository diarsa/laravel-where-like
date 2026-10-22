<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

beforeEach(function () {
    Schema::create('where_like_users', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->boolean('active');
    });

    Schema::create('where_like_posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id');
        $table->string('title');
    });

    WhereLikeUser::create(['name' => 'Alice', 'email' => 'alice@example.com', 'active' => true]);
    WhereLikeUser::create(['name' => 'Bob', 'email' => 'search@example.com', 'active' => true]);
    WhereLikeUser::create(['name' => 'Inactive', 'email' => 'search@example.com', 'active' => false]);
    WhereLikePost::create(['user_id' => 1, 'title' => 'Laravel compatibility']);
});

it('searches a single attribute', function () {
    expect(WhereLikeUser::whereLike('name', 'lic')->pluck('name')->all())
        ->toBe(['Alice']);
});

it('groups multiple attributes with existing conditions', function () {
    expect(WhereLikeUser::where('active', true)->whereLike(['name', 'email'], 'search')->pluck('name')->all())
        ->toBe(['Bob']);
});

it('searches related and nested related attributes', function (string $attribute, string $term) {
    expect(WhereLikeUser::whereLike($attribute, $term)->pluck('name')->all())
        ->toBe(['Alice']);
})->with([
    'related model' => ['posts.title', 'compatibility'],
    'nested relation' => ['posts.user.name', 'Alice'],
]);

it('combines local and related attributes', function () {
    expect(WhereLikeUser::whereLike(['email', 'posts.title'], 'Laravel')->pluck('name')->all())
        ->toBe(['Alice']);
});

it('returns no results when the term does not match', function () {
    expect(WhereLikeUser::whereLike(['name', 'email'], 'missing')->count())->toBe(0);
});

it('masks sensitive data', function () {
    expect(collect()->maskSensitiveData('1234567890'))->toBe('12******90')
        ->and(collect()->maskSensitiveData('1234567890', 3, 1))->toBe('123******0')
        ->and(collect()->maskSensitiveData('1234'))->toBe('1234');
});

class WhereLikeUser extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function posts(): HasMany
    {
        return $this->hasMany(WhereLikePost::class, 'user_id');
    }
}

class WhereLikePost extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(WhereLikeUser::class, 'user_id');
    }
}
