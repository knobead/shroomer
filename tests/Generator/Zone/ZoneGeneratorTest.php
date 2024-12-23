<?php

declare(strict_types=1);

namespace App\Tests\Generator\Zone;

use App\Entity\Mycelium;
use App\Entity\Zone;
use App\Generator\Handler\GenerateZoneHandler;
use App\Generator\Message\GenerateZoneMessage;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ZoneGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

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
        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference(ZoneGeneratorFixtures::ZONE_REFERENCE, Zone::class);
        /** @var Zone $otherZone */
        $otherZone = $this->fixturesRepository->getReference(ZoneGeneratorFixtures::OTHER_ZONE_REFERENCE, Zone::class);

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));

        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findBy(['zone' => $zone->getId()]);
        self::assertCount(1, $myceliums);

        $otherMyceliums = $myceliumRepository->findBy(['zone' => $otherZone->getId()]);
        self::assertCount(0, $otherMyceliums);
    }

    public function testItDoesNotGenerateUpToTenMyceliums(): void
    {
        self::bootKernel();
        /** @var GenerateZoneHandler $generator */
        $generator = self::getContainer()->get(GenerateZoneHandler::class);
        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference(ZoneGeneratorFixtures::ZONE_MANY_MYCELIUM_REFERENCE, Zone::class);
        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $generator->__invoke(new GenerateZoneMessage($zone->getId()));

        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findBy(['zone' => $zone->getId()]);
        self::assertCount(10, $myceliums);
    }
}
