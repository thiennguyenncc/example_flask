<?php

namespace Bachelor\Application\Admin\Factories;

use Illuminate\Support\Str;

abstract class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{
    /**
     * The default namespace where factories reside.
     *
     * @var string
     */
    protected static $namespace = 'Bachelor\\Application\\Admin\\Factories\\';

    /**
     * Get the factory name for the given model name.
     *
     * @param  string  $modelName
     * @return string
     */
    public static function resolveFactoryName(string $modelName)
    {
        $resolver = static::$factoryNameResolver ?: function (string $modelName) {

            $modelName = Str::after(substr($modelName, strrpos($modelName, '\\')), '\\');

            return static::$namespace.$modelName.'Factory';
        };

        return $resolver($modelName);
    }
}
