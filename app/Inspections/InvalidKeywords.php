<?php

namespace App\Inspections;


use Exception;

class InvalidKeywords
{
    protected $keywords = [
        'yahoo customer support',
    ];

    /**
     * @param $body
     * @throws \Exception
     */
    public function detect($body)
    {
        foreach ($this->keywords as $keyord) {
            if (stripos($body, $keyord) !== false)
                throw  new  Exception('Your reply contains spam');
        }
    }
}