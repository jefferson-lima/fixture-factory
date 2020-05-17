<?php

namespace Jefferson\Lima\Reflection;

use ReflectionType as CoreReflectionType;

class DocType extends CoreReflectionType
{
    public const STRING = 'string';
    public const INT = 'int';
    public const BOOL = 'bool';
    public const ARRAY = 'array';
    public const FLOAT = 'float';
    public const OBJECT = 'object';
    public const CALLABLE = 'callable';
    public const ITERABLE = 'iterable';
}
