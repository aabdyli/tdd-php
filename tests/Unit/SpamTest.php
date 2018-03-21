<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{
    protected $spam;

    public function setUp()
    {
        parent::setUp();

        $this->spam = new Spam();
    }

    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $this->assertFalse($this->spam->detect('Innocent reply here'));
    }

    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $this->expectException('Exception');

        $this->assertFalse($this->spam->detect('aaaaaaaamerica'));
    }
}