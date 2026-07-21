<?php

namespace JeffersonGoncalves\Cms\Core\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use JeffersonGoncalves\Cms\Core\Enums\CommentStatus;
use JeffersonGoncalves\Cms\Core\Models\Comment;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany($this->commentModelClass(), 'commentable');
    }

    public function approvedComments(): MorphMany
    {
        return $this->comments()->where('status', CommentStatus::Approved);
    }

    protected function commentModelClass(): string
    {
        return config('cms-core.models.comment', Comment::class);
    }
}
