<?php

declare(strict_types=1);

namespace App\Tests\Generator\Zone;

use App\Entity\Mycelium;
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
        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference(ZoneGeneratorFixtures::ZONE_REFERENCE, Zone::class);

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        self::assertCount(1, $myceliums, 'It should add one mycelium at first exec');

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        self::assertCount(2, $myceliums, 'It should add one mycelium at second exec');

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        self::assertCount(3, $myceliums, 'It should add one mycelium at third exec');

        $generator->__invoke(new GenerateZoneMessage($zone->getId()));
        $myceliumRepository = self::getContainer()->get('doctrine')->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findByZoneId($zone->getId());
        self::assertCount(3, $myceliums, 'it should not add a last mycelium at fourth exec');
    }
}
