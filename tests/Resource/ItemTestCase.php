<?php

/*
 * This file is part of the ByCedric\Delegator package.
 *
 * (c) Cedric van Putten <me@bycedric.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ByCedric\Delegator\Tests\Resource;

use Mockery;
use ByCedric\Delegator\Resource\Item;

class ItemTestCase extends \ByCedric\Delegator\Tests\TestCase
{
    /** @test */
    public function id_is_set_as_string()
    {
        $item = new Item;
        $item->setId(5);

        $this->assertString($item->getId(), 'Item "id" is not a string.');
        $this->assertEquals(5, $item->getId(), 'Item "id" is not equal to "5".');
    }

    /** @test */
    public function type_is_set_as_string()
    {
        $item = new Item;
        $item->setType('item');

        $this->assertString($item->getType(), 'Item "type" is not a string.');
        $this->assertEquals('item', $item->getType(), 'Item "type" is not equal to "item".');
    }

    /** @test */
    public function attributes_is_set_as_array()
    {
        $item = new Item;
        $item->setAttribute('attribute', 'value');

        $this->assertArray($item->getAttributes(), 'Item "attributes" array, is not an array.');
        $this->assertArrayHasKey('attribute', $item->getAttributes(), 'Item "attributes" array is missing keys.');
    }

    /** @test */
    public function attributes_bulk_is_calling_set_for_individual_items()
    {
        $item = Mockery::mock(Item::class)->makePartial();
        $item->shouldReceive('setAttribute')->times(3);
        $item->setAttributeArray([
            'attribute1' => 'value1',
            'attribute2' => 'value2',
            'attribute3' => 'value3',
        ]);
    }

    /** @test */
    public function meta_is_set_as_array()
    {
        $item = new Item;
        $item->setMeta('test', true);

        $this->assertArray($item->getMeta(), 'Item "meta" array, is not an array.');
        $this->assertArrayHasKey('test', $item->getMeta(), 'Item "meta" array is missing keys.');
    }

    /** @test */
    public function meta_bulk_is_calling_set_for_individual_items()
    {
        $item = Mockery::mock(Item::class)->makePartial();
        $item->shouldReceive('setMeta')->times(2);
        $item->setMetaArray([
            'meta1' => 'value1',
            'meta2' => 'value2',
        ]);
    }

    /** @test */
    public function to_array_returns_whole_resource()
    {
        $item = Mockery::mock(Item::class)->makePartial();
        $item->shouldReceive('getId')->once()->andReturn('5');
        $item->shouldReceive('getType')->once()->andReturn('item');
        $item->shouldReceive('getMeta')->once()->andReturn(['test' => true]);
        $item->shouldReceive('getAttributes')->once()->andReturn(['attribute' => 'value']);

        $array = $item->toArray();

        $this->assertArray($array, 'Item to array doesn\'t return an array.');
        $this->assertArrayHasKeys(['id', 'type', 'meta', 'attributes'], $array, 'Item array is missing keys.');
    }

    /** @test */
    public function to_array_omits_optional_keys_if_empty()
    {
        $item = Mockery::mock(Item::class)->makePartial();
        $item->shouldReceive('getId')->once()->andReturn('5');
        $item->shouldReceive('getType')->once()->andReturn('item');
        $item->shouldReceive('getMeta')->once()->andReturn([]);
        $item->shouldReceive('getAttributes')->once()->andReturn([]);

        $array = $item->toArray();

        $this->assertArrayHasKeys(['id', 'type'], $array, 'Item array is missing keys.');
        $this->assertArrayNotHasKeys(['meta', 'attributes'], $array, 'Item array has excessive keys.');
    }

    /** @test */
    public function to_array_returns_base_only_if_requested()
    {
        $item = Mockery::mock(Item::class)->makePartial();
        $item->shouldReceive('getId')->once()->andReturn('5');
        $item->shouldReceive('getType')->once()->andReturn('item');
        $item->shouldReceive('getMeta')->never();
        $item->shouldReceive('getAttributes')->never();

        $array = $item->toArray(true);

        $this->assertArray($array, 'Item to array doesn\'t return an array.');
        $this->assertArrayHasKeys(['id', 'type'], $array, 'Item array is missing keys.');
        $this->assertArrayNotHasKeys(['meta', 'attributes'], $array, 'Item array has excessive keys.');
    }
}
