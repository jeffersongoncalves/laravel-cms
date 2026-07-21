<?php

namespace JeffersonGoncalves\Cms\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphToMany;
use JeffersonGoncalves\Cms\Core\Models\Category;

trait Categorizable
{
    public function categories(): MorphToMany
    {
        $prefix = config('cms-core.table_prefix') ?? '';

        return $this->morphToMany($this->categoryModelClass(), 'categorizable', $prefix.'categorizables')
            ->withTimestamps();
    }

    protected function categoryModelClass(): string
    {
        return config('cms-core.models.category', Category::class);
    }
}
