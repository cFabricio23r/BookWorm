<?php

namespace App\Models;

use App\Builders\SummaryQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Supports\Traits\UUIDTrait;

/**
 * @mixin IdeHelperSummary
 */
class Summary extends Model
{
    use HasFactory, SoftDeletes, UUIDTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'author',
        'year',
        'summary',
        'key_aspects',
        'created_by',
        'updated_by',
        'context',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'key_aspects' => 'json',
        'context' => 'json',
    ];

    public function newEloquentBuilder($query): SummaryQueryBuilder
    {
        return new SummaryQueryBuilder($query);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
