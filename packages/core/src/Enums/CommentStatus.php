<?php

namespace JeffersonGoncalves\Cms\Core\Enums;

enum CommentStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Spam = 'spam';
}
