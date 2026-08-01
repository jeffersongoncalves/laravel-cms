<?php

namespace JeffersonGoncalves\Cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Models\Contracts\TagContract;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Tag extends Model implements TagContract
{
    use HasFactory;
    use HasTranslations;

    public array $translatable = [
        'name',
        'slug',
    ];

    protected $fillable = [
        'name',
        'slug',
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'tags';
    }
}
