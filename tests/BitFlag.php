<?php

use Karkow\BitFlag\BitFlag;
use Karkow\BitFlag\Exceptions\NotAPowerOfTwoException;

test('default value is zero', function () {
    expect(BitFlag::make()->getValue())->toBe(0);
});

it('creates instance with flag value', function () {
    $flag = BitFlag::make($x = 1 << 0);

    expect($flag->getValue())->toBe($x);
});

it('sets flag', function () {
    $flag = BitFlag::make()
        ->set($x = 1 << 0);

    expect($flag->getValue())->toBe($x);
    expect($flag->has($x))->toBeTrue();
});

it('sets multiple flags', function () {
    $flag = BitFlag::make()
        ->set($x = 1 << 0)
        ->set($y = 1 << 1)
        ->set($z = 1 << 2);

    expect($flag->getValue())->toBe($x | $y | $z);
    expect($flag->has($x))->toBeTrue();
    expect($flag->has($y))->toBeTrue();
    expect($flag->has($z))->toBeTrue();
});

it('toggles flag', function () {
    $flag = BitFlag::make()->toggle($x = 1 << 0);

    expect($flag->has($x))->toBeTrue();

    $flag->toggle($x);

    expect($flag->has($x))->toBeFalse();
});

it('has flag', function () {
    $flag = BitFlag::make($x = 1 << 0);

    expect($flag->has($x))->toBeTrue();
    expect($flag->doesntHave($x))->toBeFalse();
});

it('doesnt have flag', function () {
    $flag = BitFlag::make($x = 1 << 0);

    expect($flag->has($x))->toBeTrue();
    expect($flag->doesntHave($x))->toBeFalse();
    expect($flag->has(1 << 1))->toBeFalse();
    expect($flag->doesntHave(1 << 1))->toBeTrue();
});

test('same value instances match', function () {
    expect(BitFlag::make()->matches(new BitFlag()))->toBeTrue();
    expect(BitFlag::make()->matches(BitFlag::make()))->toBeTrue();

    $flag1 = BitFlag::make(1 << 0);
    $flag2 = BitFlag::make(1 << 0);

    expect($flag1->matches($flag2))->toBeTrue();
    expect($flag2->matches($flag1))->toBeTrue();

    $flag1 = BitFlag::make()
        ->set($x = 1 << 0)
        ->set($y = 1 << 1)
        ->set($z = 1 << 2);

    $flag2 = BitFlag::make()
        ->set($x)
        ->set($y)
        ->set($z);

    expect($flag1->matches($flag2))->toBeTrue();
    expect($flag2->matches($flag1))->toBeTrue();
});

test('different instances dont match', function () {
    expect(BitFlag::make()->matches(BitFlag::make(1 << 0)))->toBeFalse();

    $flag1 = BitFlag::make(1 << 0);
    $flag2 = BitFlag::make(1 << 1);

    expect($flag1->matches($flag2))->toBeFalse();
    expect($flag2->matches($flag1))->toBeFalse();

    $flag1 = BitFlag::make()
        ->set($x = 1 << 0)
        ->set($y = 1 << 1)
        ->set($z = 1 << 2);

    $flag2 = BitFlag::make()
        ->set($x)
        ->set($z);

    expect($flag1->matches($flag2))->toBeFalse();
    expect($flag2->matches($flag1))->toBeFalse();
});

it('throws if setting flag which is not a power of 2', function () {
    BitFlag::make()->set(3);
})->throws(NotAPowerOfTwoException::class);

it('throws if unsetting flag which is not a power of 2', function () {
    BitFlag::make()->unset(3);
})->throws(NotAPowerOfTwoException::class);

it('throws if toggling flag which is not a power of 2', function () {
    BitFlag::make()->toggle(3);
})->throws(NotAPowerOfTwoException::class);

it('throws if checking flag which is not a power of 2', function () {
    BitFlag::make()->has(3);
})->throws(NotAPowerOfTwoException::class);

it('throws if checking missing flag which is not a power of 2', function () {
    BitFlag::make()->doesntHave(3);
})->throws(NotAPowerOfTwoException::class);
