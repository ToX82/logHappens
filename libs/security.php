<?php

/**
 * Parse a GET variable returning a clean string
 *
 * @param string $key GET Variable's index
 * @return string
 */
function filterString($key)
{
    $params = splitQueryParams();
    return filter_var($params[$key], FILTER_SANITIZE_STRING);
}

/**
 * Parse a GET variable returning a clean int value
 *
 * @param string $key GET Variable's index
 * @return string
 */
function filterInt($key)
{
    $params = splitQueryParams();
    return (int)filter_var($params[$key], FILTER_SANITIZE_NUMBER_INT);
}
