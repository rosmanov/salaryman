<?php
declare(strict_types=1);

namespace App\Producer;

use App\Dto\Message\MessageInterface;

interface EventProducerInterface
{
    /**
     * Sends message to message queue.
     * @param MessageInterface $message
     */
    public function send(MessageInterface $message);
}

