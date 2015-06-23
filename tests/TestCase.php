<?php

/*
 * This file is part of the ByCedric\Delegator package.
 *
 * (c) Cedric van Putten <me@bycedric.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ByCedric\Delegator\Tests;

use Mockery;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * When a test ends, make sure we remove all mocks.
     *
     * @return void
     */
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * Assert if the provided value is a string.
     *
     * @param  mixed  $value
     * @param  string $message (default: '')
     * @return void
     */
    public function assertString($value, $message = '')
    {
        $this->assertInternalType('string', $value, $message);
    }

    /**
     * Assert if the provided value is an array.
     *
     * @param  mixed  $value
     * @param  string $message (default: '')
     * @return void
     */
    public function assertArray($value, $message = '')
    {
        $this->assertInternalType('array', $value, $message);
    }

    /**
     * Assert if the array has all provided keys.
     *
     * @param  array  $keys
     * @param  mixed  $array
     * @param  string $message (default: '')
     * @return void
     */
    public function assertArrayHasKeys(array $keys, $array, $message = '')
    {
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $array, $message);
        }
    }

    /**
     * Assert if the array has none of the provided keys.
     *
     * @param  array  $keys
     * @param  mixed  $array
     * @param  string $message (default: '')
     * @return void
     */
    public function assertArrayNotHasKeys(array $keys, $array, $message = '')
    {
        foreach ($keys as $key) {
            $this->assertArrayNotHasKey($key, $array, $message);
        }
    }
}
