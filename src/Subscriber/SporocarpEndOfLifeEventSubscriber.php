<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Event\Sporocarp\SporocarpEndOfLifeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SporocarpEndOfLifeEventSubscriber implements EventSubscriberInterface
{
    /**
     * @param SporocarpEndOfLifeEvent $event
     *
     * @return void
     */
    public function onSporocarpEndOfLife(SporocarpEndOfLifeEvent $event)
    {
        $user = $event->getSporocarp()->getZone()->getUser();

        if ($event->getSporocarp()->isEaten()) {
                $user->incrementResourceFauna();
        }

        if ($event->getSporocarp()->isWormy()) {
            $user->incrementResourceEntomofauna();
        }

        $user->incrementResourceFlora();
    }

    /**
     * @return array[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            SporocarpEndOfLifeEvent::class => ['onSporocarpEndOfLife', 0],
        ];
    }
}
