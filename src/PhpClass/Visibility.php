<?php

namespace Zerotoprod\DataModelBuilder\PhpClass;

enum Visibility: string
{
    case public = 'public';
    case protected = 'protected';
    case private = 'private';
}