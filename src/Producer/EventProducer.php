<?php
declare(strict_types=1);

namespace App\Producer;

use App\Dto\Message\MessageInterface;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use PhpAmqpLib\Connection\AbstractConnection;

class EventProducer implements EventProducerInterface
{
    /**
     * @var AbstractConnection
     */
    protected $connection;

    /**
     * @var string
     */
    protected $destinationExchange;

    /**
     * @var string
     */
    protected $queue;

    /**
     * @throws \UnexpectedValueException
     */
    public function __construct(
        AbstractConnection $connection,
        string $destinationExchange,
        string $queue
    ) {
        $this->connection = $connection;
        $this->destinationExchange = $destinationExchange;

        if (strlen($queue) > 60) {
            throw new \UnexpectedValueException('Queue name should be a string of length <= 60.');
        }

        $this->queue = $queue;
    }

    /**
     * {@inheritDoc}
     */
    public function send(MessageInterface $message)
    {
        $producer = new Producer($this->connection);
        $producer->setExchangeOptions([
            'name' => $this->destinationExchange,
            'type' => 'direct',
        ]);
        $producer->setQueueOptions([
            'name' => $this->queue,
            'routing_keys' => [$this->queue],
        ]);

        $producer->setupFabric();
        $producer->publish(serialize($message), $this->queue, []);
    }
}
