<?php

namespace JeffersonGoncalves\Cms\Core\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Scheduled = 'scheduled';
}
