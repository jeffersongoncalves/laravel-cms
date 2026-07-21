<?php

namespace JeffersonGoncalves\Cms\Core\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Core\Concerns\Categorizable;
use JeffersonGoncalves\Cms\Core\Concerns\HasComments;
use JeffersonGoncalves\Cms\Core\Concerns\HasRevisions;
use JeffersonGoncalves\Cms\Core\Concerns\HasSeo;
use JeffersonGoncalves\Cms\Core\Concerns\Taggable;
use JeffersonGoncalves\Cms\Core\Enums\PostStatus;
use JeffersonGoncalves\Cms\Core\Models\Contracts\PostContract;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int|null $author_id
 * @property array $title
 * @property array $slug
 * @property array|null $excerpt
 * @property array $body
 * @property PostStatus $status
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Post extends Model implements PostContract
{
    use Categorizable;
    use HasComments;
    use HasFactory;
    use HasRevisions;
    use HasSeo;
    use HasTranslations;
    use Taggable;

    public array $translatable = [
        'title',
        'slug',
        'excerpt',
        'body',
    ];

    protected $fillable = [
        'author_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'status',
        'published_at',
    ];

    protected $casts = [
        'status' => PostStatus::class,
        'published_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'posts';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }
}
