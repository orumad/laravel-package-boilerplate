<?php

namespace Me\MyPackage;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Me\MyPackage\MyPackage
 */
class MyPackageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'my-package';
    }
}
