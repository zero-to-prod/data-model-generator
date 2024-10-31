<?php

namespace Zerotoprod\DataModelGenerator\Generator\Model;

enum Visibility: string
{
    case public = 'public';
    case protected = 'protected';
    case private = 'private';
}