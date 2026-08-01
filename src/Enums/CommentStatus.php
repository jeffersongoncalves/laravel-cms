<?php

namespace JeffersonGoncalves\Cms\Enums;

enum CommentStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Spam = 'spam';
}
