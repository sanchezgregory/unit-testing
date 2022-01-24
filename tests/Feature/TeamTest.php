<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    protected $team;

    public function setUp(): void
    {
        parent::setUp();
        $this->team = Team::factory()->create(['name'=>'Acme', 'size'=> 3]);
    }

    /** @test */
    public function a_team_has_a_name()
    {
        $this->assertEquals('Acme', $this->team->name);
    }

    /** @test */
    public function a_team_can_add_members()
    {
        $this->addMembersToTheTeam(2);
        $this->assertEquals(2, $this->team->count());
    }

    /** @test */
    public function it_has_maximum_size()
    {
        $this->addMembersToTheTeam(2);

        $this->assertEquals('2', $this->team->count());

        $this->expectException('Exception');
        $user3 = User::factory()->create();
        $this->team->add($user3);
    }

    /** @test */
    public function it_can_add_multiple_members_at_once()
    {
        $this->addMembersToTheTeam(1);

        $users = User::factory(2)->create();

        $this->team->add($users);

        $this->assertEquals(3, $this->team->count());
    }

    /** @test */
    public function it_can_remove_a_member()
    {
        $this->addMembersToTheTeam(3);

        $this->team->remove($this->team->members()->first());

        $this->assertEquals(2, $this->team->count());
    }

    /** @test */
    public function it_can_remove_all_members_at_once()
    {
        $this->addMembersToTheTeam(3);

        $this->team->restart();

        $this->assertEquals(3, $this->team->count());
    }

    /** @test */
    public function it_can_remove_more_than_one_member()
    {
        $users = $this->addMembersToTheTeam(3);

        $this->team->removeMany($users->slice(0, 2));

        $this->assertEquals(1, $this->team->count());

    }

    /** @test */
    private function addMembersToTheTeam($members)
    {
        for ($i=0; $i < $members; $i++) {
            $user = User::factory()->create();
            $this->team->add($user);
        }

        return $this->team->members()->get();
    }
}
