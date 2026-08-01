<?php

namespace JeffersonGoncalves\Cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Models\Contracts\CategoryContract;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property array $name
 * @property array $slug
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Category extends Model implements CategoryContract
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'name',
        'slug',
    ];

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'categories';
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }
}
