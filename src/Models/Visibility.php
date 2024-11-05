<?php

namespace Zerotoprod\DataModelGenerator\Models;

enum Visibility: string
{
    case public = 'public';
    case protected = 'protected';
    case private = 'private';
}