<?php

namespace JeffersonGoncalves\Cms\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Menu\Models\Contracts\MenuItemContract;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property int $menu_id
 * @property int|null $parent_id
 * @property array $label
 * @property string|null $url
 * @property string|null $linkable_type
 * @property int|null $linkable_id
 * @property string $target
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class MenuItem extends Model implements MenuItemContract
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'label',
    ];

    protected $fillable = [
        'menu_id',
        'parent_id',
        'label',
        'url',
        'linkable_type',
        'linkable_id',
        'target',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function getTable(): string
    {
        return (config('cms-menu.table_prefix') ?? '').'menu_items';
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('order');
    }

    public function linkable(): MorphTo
    {
        return $this->morphTo();
    }
}
