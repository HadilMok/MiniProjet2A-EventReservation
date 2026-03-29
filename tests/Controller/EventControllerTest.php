<?php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testIndexPage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/events');

        $this->assertResponseIsSuccessful();
    }
}
