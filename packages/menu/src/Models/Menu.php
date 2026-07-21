<?php

namespace JeffersonGoncalves\Cms\Menu\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Menu\Models\Contracts\MenuContract;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Menu extends Model implements MenuContract
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'location',
    ];

    public function getTable(): string
    {
        return (config('cms-menu.table_prefix') ?? '').'menus';
    }

    public function items(): HasMany
    {
        return $this->hasMany($this->menuItemModelClass(), 'menu_id')->orderBy('order');
    }

    public function rootItems(): HasMany
    {
        return $this->items()->whereNull('parent_id');
    }

    protected function menuItemModelClass(): string
    {
        return config('cms-menu.models.menu_item', MenuItem::class);
    }
}
