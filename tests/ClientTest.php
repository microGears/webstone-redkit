<?php

declare(strict_types=1);

use PHPUnit\Framework\MockObject\MockBuilder;
use PHPUnit\Framework\TestCase;
use WebStone\Redkit\Client;

class ClientTest extends TestCase
{
    public function testInitialDbValue()
    {
        $client = new Client();
        $this->assertSame(0, $client->getDb());
    }

    public function testGetDb()
    {
        $client = new Client();
        $client->setDb(5);
        $this->assertSame(5, $client->getDb());
    }

    public function testSetDb()
    {
        $client = $this->getMockBuilder(Client::class)
            ->onlyMethods(['select'])
            ->getMock();

        $client->expects($this->once())
            ->method('select')
            ->with($this->equalTo(5));

        /** @var Client $client */
        $client->setDb(5);
        $this->assertSame(5, $client->getDb());
    }

    public function testSetAndGetValue()
    {
        $client = new Client();
        $client->setDb(0);
        $key = time();
        
        $client->set("$key:var1", 'value1');
        $client->set("$key:var2", 'value2');

        $this->assertSame('value1', $client->get("$key:var1"));
        $this->assertSame('value2', $client->get("$key:var2"));

        $client->del("$key:var1");
        $client->del("$key:var2");
    }

    public function testSetAndGetValueTemporary()
    {
        $client = new Client();
        $client->setDb(0);
        $key = time();
        
        $client->set("$key:var1", 'value1',1);
        $client->set("$key:var2", 'value2',1);

        $this->assertSame('value1', $client->get("$key:var1"));
        $this->assertSame('value2', $client->get("$key:var2"));
        
        sleep(2);

        $this->assertNull($client->get("$key:var1"));
        $this->assertNull($client->get("$key:var2"));
    }    
}
