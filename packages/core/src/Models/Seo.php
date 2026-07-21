<?php

namespace JeffersonGoncalves\Cms\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Core\Models\Contracts\SeoContract;
use Spatie\Translatable\HasTranslations;

/**
 * @property int $id
 * @property string $seoable_type
 * @property int $seoable_id
 * @property array|null $meta_title
 * @property array|null $meta_description
 * @property string|null $meta_image
 * @property string|null $canonical_url
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Seo extends Model implements SeoContract
{
    use HasTranslations;

    public array $translatable = [
        'meta_title',
        'meta_description',
    ];

    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_image',
        'canonical_url',
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'seo_metas';
    }

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
