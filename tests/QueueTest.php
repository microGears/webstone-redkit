<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use WebStone\Redkit\Queue;
use WebStone\Redkit\QueueMessage;

class QueueTest extends TestCase
{
    public function testInitialNodeValue()
    {
        $queue = new Queue();
        $this->assertSame('queue', $queue->getNode());
    }

    public function testSetAndGetNode()
    {
        $queue = new Queue();
        $queue->setNode('testNode');
        $this->assertSame('testNode', $queue->getNode());
    }

    public function testSetAndGetMessage()
    {
        $queue = new Queue();
        $message = new QueueMessage(['message' => 'testMessage']);
        $key = $queue->setMessage($message);

        $retrievedMessage = $queue->getMessage($key);
        $this->assertEquals($message, $retrievedMessage);
        $queue->deleteMessage($key);
    }

    public function testSetAndGetCustomObject()
    {
        $queue = new Queue();
        $message1 = new QueueMessageCustom(['data' => 'Simple data 1']);
        $message2 = new QueueMessageCustom(['data' => 'Simple data 1']);
        $key1 = $queue->setMessage($message1);
        $key2 = $queue->setMessage($message2);

        $this->assertNotEquals($f_msg1 = $queue->getMessage($key1),$f_msg_2 = $queue->getMessage($key2));
        $this->assertEquals($f_msg1->getData(),$message1->getData());
        $queue->deleteAll();
    }

    public function testFetchMessages()
    {
        $queue = new Queue();
        $message_limit = 100;
        for ($i = 0; $i < $message_limit; $i++) {
            $message = new QueueMessage(['message' => "message-$i"]);
            $queue->setMessage($message);
        }

        while (($message = $queue->fetch()) && $message_limit--) {
            if ($message instanceof QueueMessage){
                /** some work ... */
                $queue->deleteMessage($message->getId());
            }
        }
        $this->assertNull($queue->fetch());
    }

    public function testDeleteMessage()
    {
        $queue = new Queue();
        $message = new QueueMessage(['message' => 'testMessage']);
        $key = $queue->setMessage($message);

        $this->assertTrue($queue->deleteMessage($key));
        $this->assertNull($queue->getMessage($key));
    }

    public function testDeleteAllMessages()
    {
        $queue = new Queue();
        $message1 = new QueueMessage(['message' => 'testMessage1']);
        $message2 = new QueueMessage(['message' => 'testMessage2']);
        $queue->setMessage($message1);
        $queue->setMessage($message2);
        $queue->deleteAll();  
        $this->assertNull($queue->fetch());
    }
}


class QueueMessageCustom extends QueueMessage{
    public function getData():string{
        return $this->getAttribute('data');
    }
    public function setData(string $data):self{
        $this->setAttribute('data',$data);
        return $this;
    }
}
