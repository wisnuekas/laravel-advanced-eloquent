<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Skill;
use App\Mitra;

class SkillTest extends TestCase
{
    use RefreshDatabase;
    
    public function testUserCanCreateSkill()
    {
        $payload = ['name' => 'Membersihkan Kebun'];

        $response = $this->json('POST', '/api/v1/skills', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'name'
            ]); 
    }

    public function testUserCanSearchSkill()
    {
        factory(Skill::class)->create([
            'name' => 'Membersihkan Kebun'
        ]);

        factory(Skill::class)->create([
            'name' => 'Membersihkan Kamar'
        ]);

        $payload = ['q' => 'memb'];

        $response = $this->json('GET', '/api/v1/skills', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'name']
            ])
            ->assertJsonFragment([
                'name' => 'Membersihkan Kebun',
                'name' => 'Membersihkan Kamar'
            ]);
    }
}
