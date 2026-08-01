<?php

namespace JeffersonGoncalves\Cms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\Cms\Models\Contracts\RevisionContract;

/**
 * @property int $id
 * @property string $revisionable_type
 * @property int $revisionable_id
 * @property int|null $user_id
 * @property array $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Revision extends Model implements RevisionContract
{
    protected $fillable = [
        'user_id',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function getTable(): string
    {
        return (config('cms-core.table_prefix') ?? '').'revisions';
    }

    public function revisionable(): MorphTo
    {
        return $this->morphTo();
    }
}
