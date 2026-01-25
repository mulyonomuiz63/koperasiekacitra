<?php

use Ramsey\Uuid\Uuid;

if (! function_exists('uuid')) {

    function uuid(): string
    {
        return Uuid::uuid4()->toString();
    }
}
