<?php

namespace JeffersonGoncalves\Cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Enums\CommentStatus;
use JeffersonGoncalves\Cms\Models\Contracts\CommentContract;

/**
 * @property int $id
 * @property string $commentable_type
 * @property int $commentable_id
 * @property int|null $parent_id
 * @property int|null $user_id
 * @property string|null $author_name
 * @property string|null $author_email
 * @property string $body
 * @property CommentStatus $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Comment extends Model implements CommentContract
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'user_id',
        'author_name',
        'author_email',
        'body',
        'status',
    ];

    protected $casts = [
        'status' => CommentStatus::class,
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'comments';
    }

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }
}
