<?php

namespace App\Inspections;


use Exception;

class KeyHeldDown
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
        if(preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply is malformated. Please Checl');
        }
    }
}