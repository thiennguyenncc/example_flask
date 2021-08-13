<?php

namespace Bachelor\Domain\Base;

use Carbon\Carbon;
use Illuminate\Support\Str;

abstract class BaseDomainModel
{
    /**
     * @var int|null
     */
    protected ?int $id = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function __call(string $method, array $parameters)
    {
        $property = $this->parseMethod($method);

        if (str_starts_with($method, 'get')) {

            return $this->$property;
        } elseif (str_starts_with($method, 'set') && isset($parameters[0])) {
            $this->$property = $parameters[0];

            return $this;
        }
        throw new \Exception(__("Method $method not found!"));
    }

    /**
     * Parse magic method to corresponding property. E.g. getUserInfo -> userInfo
     *
     * @param string $method
     * @return string|string[]|null
     */
    private function parseMethod(string $method): string
    {
        return Str::camel(preg_replace('/^(get_|set_)/', '', preg_replace_callback('/([A-Z])/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $method), 1));
    }
}
