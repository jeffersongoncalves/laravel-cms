<?php

namespace JeffersonGoncalves\Cms\Core\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use JeffersonGoncalves\Cms\Core\Models\Seo;

trait HasSeo
{
    public function seo(): MorphOne
    {
        return $this->morphOne($this->seoModelClass(), 'seoable');
    }

    public function fillSeo(array $attributes): Model
    {
        return $this->seo()->updateOrCreate([], $attributes);
    }

    protected function seoModelClass(): string
    {
        return config('cms-core.models.seo', Seo::class);
    }
}
