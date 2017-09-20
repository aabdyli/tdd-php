<?php

function create($class, $attributes = [], $times = null)
{
    return factory('App\\' . $class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory('App\\' . $class, $times)->make($attributes);
}
