<?php

declare(strict_types=1);

namespace App\Tests\Generator\Zone;

use App\Entity\Mycelium;
use App\Entity\Sporocarp;
use App\Entity\Weather;
use App\Entity\Zone;
use App\Generator\Handler\GenerateZoneHandler;
use App\Generator\Message\GenerateZoneMessage;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZoneGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new ZoneGeneratorFixtures());
    }

    public function testItGenerateAZone(): void
    {
        self::bootKernel();
        /** @var GenerateZoneHandler $generator */
        $generator = self::getContainer()->get(GenerateZoneHandler::class);
        $zone = $this->fixturesRepository->getReference(ZoneGeneratorFixtures::ZONE_REFERENCE, Zone::class);
        $mycelium = $this->fixturesRepository->getReference(ZoneGeneratorFixtures::OTHER_MYCELIUM_REFERENCE, Mycelium::class);

        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $weatherRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Weather::class);
        $sporocarpRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Sporocarp::class);

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        $weathers = $weatherRepository->findByZone($zone->getId());
        $otherSporocarps = $sporocarpRepository->findByMycelium($mycelium->getId());
        self::assertCount(1, $myceliums, 'It should add one mycelium at first exec');
        self::assertCount(1, $weathers, 'It should add a weather at each exec');
        self::assertCount(1, $otherSporocarps, 'it must not delete or add sporocarps to a capped mycelium');

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        $weathers = $weatherRepository->findByZone($zone->getId());
        $otherSporocarps = $sporocarpRepository->findByMycelium($mycelium->getId());
        self::assertCount(2, $myceliums, 'It should add one mycelium at second exec');
        self::assertCount(2, $weathers, 'It should add a weather at each exec');
        self::assertCount(1, $otherSporocarps, 'it must not delete or add sporocarps to a capped mycelium');

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        $weathers = $weatherRepository->findByZone($zone->getId());
        $otherSporocarps = $sporocarpRepository->findByMycelium($mycelium->getId());
        self::assertCount(3, $myceliums, 'It should add one mycelium at third exec');
        self::assertCount(3, $weathers, 'It should add a weather at each exec');
        self::assertCount(1, $otherSporocarps, 'it must not delete or add sporocarps to a capped mycelium');

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        $weathers = $weatherRepository->findByZone($zone->getId());
        $otherSporocarps = $sporocarpRepository->findByMycelium($mycelium->getId());
        self::assertCount(3, $myceliums, 'it should not add a last mycelium at fourth exec');
        self::assertCount(4, $weathers, 'It should add a weather at each exec');
        self::assertCount(1, $otherSporocarps, 'it must not delete or add sporocarps to a capped mycelium');
    }
}
