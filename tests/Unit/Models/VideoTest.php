<?php

namespace Tests\Unit\Models;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    public function testCreate()
    {
        $inputs = Video::factory()->make()->toArray();

        Video::create($inputs);

        $this->assertDatabaseCount('videos', 1);
        $this->assertDatabaseHas('videos', $inputs);
    }
}

