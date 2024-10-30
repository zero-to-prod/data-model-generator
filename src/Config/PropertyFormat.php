<?php

namespace Zerotoprod\DataModelGenerator\Config;

enum PropertyFormat: string
{
    case number	 = 'number';
    case float = 'float';
    case double = 'double';
    case integer = 'integer';
    case int32 = 'int32';
    case int64 = 'int64';
    case date = 'date';
    case date_time = 'date-time';
    case password = 'password';
    case byte = 'byte';
    case binary = 'binary';
}