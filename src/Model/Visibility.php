<?php

namespace Zerotoprod\DataModelGenerator\Model;

enum Visibility: string
{
    case public = 'public';
    case protected = 'protected';
    case private = 'private';
}