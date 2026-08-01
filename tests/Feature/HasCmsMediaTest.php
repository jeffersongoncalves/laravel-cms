<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use JeffersonGoncalves\Cms\Tests\Fixtures\Article;

beforeEach(function () {
    Storage::fake('media');
});

it('registers collections from config and keeps a single featured image', function () {
    $article = Article::create(['title' => 'Hello']);

    $article->addMedia(UploadedFile::fake()->image('first.jpg'))->toMediaCollection('featured_image');
    $article->addMedia(UploadedFile::fake()->image('second.jpg'))->toMediaCollection('featured_image');

    expect($article->getMedia('featured_image'))->toHaveCount(1)
        ->and($article->getFirstMedia('featured_image')->file_name)->toBe('second.jpg');
});

it('allows multiple files in a non-single collection', function () {
    $article = Article::create(['title' => 'Gallery']);

    $article->addMedia(UploadedFile::fake()->image('one.jpg'))->toMediaCollection('gallery');
    $article->addMedia(UploadedFile::fake()->image('two.jpg'))->toMediaCollection('gallery');

    expect($article->getMedia('gallery'))->toHaveCount(2);
});
