<?php

declare(strict_types=1);

namespace App\Generator;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Receiver\ReceiverInterface;

class GeneratorReceiver implements ReceiverInterface
{
    private bool $shouldReceived = true;

    public function __construct()
    {
    }

    public function get(): iterable
    {
        if ($this->shouldReceived) {
            $this->buildInitialsEnvelopes();
        }
    }

    public function ack(Envelope $envelope): void
    {
        // TODO: Implement ack() method.
    }

    public function reject(Envelope $envelope): void
    {
        // TODO: Implement reject() method.
    }

    private function buildInitialsEnvelopes(): void
    {

    }
}
