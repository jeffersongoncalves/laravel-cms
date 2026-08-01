<?php

namespace JeffersonGoncalves\Cms\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Concerns\Categorizable;
use JeffersonGoncalves\Cms\Concerns\HasComments;
use JeffersonGoncalves\Cms\Concerns\HasRevisions;
use JeffersonGoncalves\Cms\Concerns\HasSeo;
use JeffersonGoncalves\Cms\Concerns\Taggable;
use JeffersonGoncalves\Cms\Enums\PageStatus;
use JeffersonGoncalves\Cms\Models\Contracts\PageContract;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property array $title
 * @property array $slug
 * @property array $body
 * @property PageStatus $status
 * @property int $order
 * @property Carbon|null $published_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Page extends Model implements PageContract
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
        'body',
    ];

    protected $fillable = [
        'parent_id',
        'title',
        'slug',
        'body',
        'status',
        'order',
        'published_at',
    ];

    protected $casts = [
        'status' => PageStatus::class,
        'order' => 'integer',
        'published_at' => 'datetime',
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'pages';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PageStatus::Published)
            ->where(function (Builder $query): void {
                $query->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }
}
