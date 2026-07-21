<?php

namespace JeffersonGoncalves\Cms\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use JeffersonGoncalves\Cms\Core\Models\Revision;
use RuntimeException;

trait HasRevisions
{
    public static function bootHasRevisions(): void
    {
        static::updating(function (self $model): void {
            $tracked = array_intersect_key($model->getDirty(), array_flip($model->revisionable()));

            if ($tracked === []) {
                return;
            }

            $previous = array_intersect_key($model->getOriginal(), array_flip($model->revisionable()));

            $model->revisions()->create([
                'user_id' => auth()->id(),
                'data' => $previous,
            ]);
        });
    }

    public function revisions(): MorphMany
    {
        return $this->morphMany($this->revisionModelClass(), 'revisionable')->latest();
    }

    public function revisionable(): array
    {
        return $this->fillable;
    }

    public function restoreRevision(Revision|int $revision): static
    {
        $revision = $revision instanceof Revision ? $revision : $this->revisions()->findOrFail($revision);

        if (! $revision instanceof Revision) {
            throw new RuntimeException('Configured revision model must extend '.Revision::class);
        }

        $this->forceFill($revision->data)->save();

        return $this;
    }

    protected function revisionModelClass(): string
    {
        return config('cms-core.models.revision', Revision::class);
    }
}
