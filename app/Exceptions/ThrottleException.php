<?php

namespace App\Exceptions;

use Exception;

class ThrottleException extends Exception
{
    public function render()
    {
        return response($this->getMessage(), 422);
    }
}
