<?php

namespace App\Exception\Config;

use App\Exception\BusinessLogicException;

class FeeConfigException extends BusinessLogicException
{
    public function __construct(string $feeName)
    {
        $message = sprintf('Invalid fee config for %s', $feeName);
        parent::__construct($message, 400);
    }
}
