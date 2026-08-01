<?php

use JeffersonGoncalves\Cms\Enums\CommentStatus;
use JeffersonGoncalves\Cms\Models\Post;

it('threads replies and scopes approved comments', function () {
    $post = Post::factory()->create();

    $comment = $post->comments()->create([
        'author_name' => 'Jane',
        'author_email' => 'jane@example.com',
        'body' => 'Great post!',
        'status' => CommentStatus::Approved,
    ]);

    $post->comments()->create([
        'author_name' => 'Spammer',
        'author_email' => 'spam@example.com',
        'body' => 'buy now',
        'status' => CommentStatus::Spam,
    ]);

    $post->comments()->create([
        'parent_id' => $comment->id,
        'author_name' => 'Reply Guy',
        'author_email' => 'reply@example.com',
        'body' => 'I agree',
        'status' => CommentStatus::Approved,
    ]);

    expect($post->comments()->count())->toBe(3)
        ->and($post->approvedComments()->count())->toBe(2)
        ->and($comment->replies)->toHaveCount(1);
});
