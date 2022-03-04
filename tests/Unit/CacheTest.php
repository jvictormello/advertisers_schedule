<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class CacheTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void 
     */
    public function test_cache()
    {
        Cache::store('redis')->put('test',true);
        $this->assertTrue(Cache::store('redis')->get('test'));
    }
}
