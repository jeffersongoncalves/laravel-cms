<?php

namespace JeffersonGoncalves\Cms\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Cms\Concerns\HasCmsMedia;
use Spatie\MediaLibrary\HasMedia;

class Article extends Model implements HasMedia
{
    use HasCmsMedia;

    protected $table = 'cms_media_test_articles';

    protected $guarded = [];
}
