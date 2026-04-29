<?php

/**
 * Safely returns an iterable value (array, object, or empty array) for use in loops.
 * Prevents "Invalid argument supplied for foreach()" errors.
 *
 * @param mixed $data The data to iterate over
 * @param array $default Default return value if data is not iterable
 * @return array|iterable
 */
function safe_iterate($data, $default = [])
{
    if (is_iterable($data)) {
        return $data;
    }
    return $default;
}

/**
 * Safely outputs a value with esc(), handling null and non-string values.
 *
 * @param mixed $value
 * @return string
 */
function safe_esc($value)
{
    return esc((string)($value ?? ''));
}