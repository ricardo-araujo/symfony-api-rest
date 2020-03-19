<?php

namespace App\Helper;

interface EntityFactoryInterface
{
    public function create(string $content);

    public function update($entity, string $content);

    public function checkProperties(object $json);
}
