<?php

namespace JeffersonGoncalves\Cms\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use JeffersonGoncalves\Cms\Core\Models\Tag;

trait Taggable
{
    public function tags(): MorphToMany
    {
        $prefix = config('cms-core.table_prefix') ?? '';

        return $this->morphToMany($this->tagModelClass(), 'taggable', $prefix.'taggables')
            ->withTimestamps();
    }

    protected function tagModelClass(): string
    {
        return config('cms-core.models.tag', Tag::class);
    }
}
