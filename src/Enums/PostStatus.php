<?php

namespace JeffersonGoncalves\Cms\Enums;

enum PostStatus: string
{
    case Draft = 'draft';
    case Published = 'published';
    case Scheduled = 'scheduled';
}
