<?php

namespace App\Exception\Config;

use App\Exception\BusinessLogicException;

class FeeConfigException extends BusinessLogicException
{
    public function __construct(string $message)
    {
        parent::__construct($message, 400);
    }
}
