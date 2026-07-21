<?php

use JeffersonGoncalves\Cms\Core\Models\Post;

it('snapshots the previous state before an update and restores it', function () {
    $post = Post::factory()->create(['title' => ['en' => 'Original title']]);

    $post->update(['title' => ['en' => 'Updated title']]);

    expect($post->revisions()->count())->toBe(1);

    $revision = $post->revisions()->first();
    expect($revision->data['title']['en'])->toBe('Original title');

    $post->restoreRevision($revision->id);

    expect($post->fresh()->title)->toBe('Original title');
});

it('does not create a revision when tracked fields are unchanged', function () {
    $post = Post::factory()->create();

    $post->update(['title' => $post->getTranslations('title')]);

    expect($post->revisions()->count())->toBe(0);
});
