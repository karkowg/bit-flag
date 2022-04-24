<?php

if (! function_exists('__is_power_of_two')) {
    function __is_power_of_two(int $value): bool
    {
        return $value && ! ($value & ($value - 1));
    }
}
