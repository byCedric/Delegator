<?php

/*
 * This file is part of the ByCedric\Delegator package.
 *
 * (c) Cedric van Putten <me@bycedric.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ByCedric\Delegator\Resource;

class Item implements \ByCedric\Delegator\Contract\Item
{
    /**
     * The unique identifier of this resource.
     *
     * @var string
     */
    protected $id;

    /**
     * The human readable type of this resource.
     *
     * @var string
     */
    protected $type;

    /**
     * The attributes of this resource.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The meta data of this resource.
     *
     * @var array
     */
    protected $meta = [];

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = (string) $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = (string) $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeArray(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * {@inheritdoc}
     */
    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetaArray(array $meta)
    {
        foreach ($meta as $key => $value) {
            $this->setMeta($key, $value);
        }
    }

    /**
     * Convert the item to a plain array.
     * By default the whole resource is being transformed,
     * including attributes and meta data.
     *
     * @param  boolean $baseOnly (default: false)
     * @return array
     */
    public function toArray($baseOnly = false)
    {
        $array = [
            'id' => $this->getId(),
            'type' => $this->getType(),
        ];

        if ($baseOnly) {
            return $array;
        }

        $attributes = $this->getAttributes();
        $meta = $this->getMeta();

        if ($attributes) {
            $array['attributes'] = $attributes;
        }

        if ($meta) {
            $array['meta'] = $meta;
        }

        return $array;
    }
}
