<?php

declare(strict_types=1);

namespace Karkow\BitFlag;

use function __is_power_of_two;
use Karkow\BitFlag\Exceptions\NotAPowerOfTwoException;

class BitFlag
{
    private int $value = 0;

    public function __construct(int $flag = 0)
    {
        $this->set($flag);
    }

    public static function make(int $flag = 0): self
    {
        return new self($flag);
    }

    public function set(int $flag): self
    {
        if (! $flag) {
            return $this;
        }

        if (! __is_power_of_two($flag)) {
            throw new NotAPowerOfTwoException();
        }

        $this->value |= $flag;

        return $this;
    }

    public function unset(int $flag): self
    {
        if (! $flag) {
            return $this;
        }

        if (! __is_power_of_two($flag)) {
            throw new NotAPowerOfTwoException();
        }

        $this->value &= (~$flag);

        return $this;
    }

    public function toggle(int $flag): self
    {
        if (! $flag) {
            return $this;
        }

        if (! __is_power_of_two($flag)) {
            throw new NotAPowerOfTwoException();
        }

        $this->value ^= $flag;

        return $this;
    }

    public function has(int $flag): bool
    {
        if (! __is_power_of_two($flag)) {
            throw new NotAPowerOfTwoException();
        }

        return ($this->value & $flag) === $flag;
    }

    public function doesntHave(int $flag): bool
    {
        return ! $this->has($flag);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function matches(self $bitFlag): bool
    {
        return $this->value === $bitFlag->getValue();
    }
}
