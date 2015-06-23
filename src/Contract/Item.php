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

/**
 * The item contract is an abstract implementation of the JSON-API's Resource Object.
 * A Resource Object defines a unique entity within the API, by both ID and Type values.
 *
 * @link http://jsonapi.org/format/#document-resource-objects
 */
interface Item extends Resource
{
    /**
     * Get the unique identifier of this resource.
     *
     * @return string
     */
    public function getId();

    /**
     * Set the unique identifier of this resource.
     *
     * @param  string|integer $id
     * @return void
     */
    public function setId($id);

    /**
     * Get the human readable type for this resource.
     *
     * @return string
     */
    public function getType();

    /**
     * Set the human readable type for this resource.
     *
     * @param  string $type
     * @return void
     */
    public function setType($type);

    /**
     * Get the attributes, set for this resource.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Set a single attribute.
     * This will be added to the existing attribute list.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setAttribute($key, $value);

    /**
     * Set multiple attributes at once.
     * These will be added to the existing attribute list.
     *
     * @param  array $attributes
     * @return void
     */
    public function setAttributeArray(array $attributes);

    /**
     * Get the meta data, set for this resource.
     *
     * @return array
     */
    public function getMeta();

    /**
     * Set a single meta attribute.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return void
     */
    public function setMeta($key, $value);

    /**
     * Set multiple meta values at once.
     * This will be added to the existing attribute list.
     *
     * @param  array $meta
     * @return void
     */
    public function setMetaArray(array $meta);
}
