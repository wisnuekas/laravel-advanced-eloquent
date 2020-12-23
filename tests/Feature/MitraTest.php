<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Mitra;

class MitraTest extends TestCase
{
    use RefreshDatabase;

    public function testMitra()
    {
        $mitra1 = factory(Mitra::class)->create();

        $this->assertDatabaseCount('mitras',1);
    }
}
