<?php
namespace App\Tests\Entity;

use App\Entity\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{
    public function testEventCreation(): void
    {
        $event = new Event();
        $event->setTitle('Conférence IA');
        $event->setSeats(100);

        $this->assertEquals('Conférence IA', $event->getTitle());
        $this->assertEquals(100, $event->getSeats());
    }
}
