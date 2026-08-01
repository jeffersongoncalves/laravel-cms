<?php

namespace JeffersonGoncalves\Cms\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use JeffersonGoncalves\Cms\Concerns\HasCmsMedia;
use Spatie\MediaLibrary\HasMedia;

class Article extends Model implements HasMedia
{
    use HasCmsMedia;

    protected $table = 'cms_media_test_articles';

    protected $guarded = [];

    public static function createTable(): void
    {
        if (! Schema::hasTable('cms_media_test_articles')) {
            Schema::create('cms_media_test_articles', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->timestamps();
            });
        }
    }
}
