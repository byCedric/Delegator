<?php

/*
 * This file is part of the ByCedric\Delegator package.
 *
 * (c) Cedric van Putten <me@bycedric.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ByCedric\Delegator\Contract;

interface Resource
{
    /**
     * Convert the resource to a plain array.
     *
     * @return array
     */
    public function toArray();
}
