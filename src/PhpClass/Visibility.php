<?php

namespace Zerotoprod\DataModelGenerator\PhpClass;

enum Visibility: string
{
    case public = 'public';
    case protected = 'protected';
    case private = 'private';
}