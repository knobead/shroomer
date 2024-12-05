<?php

declare(strict_types=1);

namespace App\Tests\Generator\Mycelium;

use App\Entity\Mycelium;
use App\Generator\Handler\GenerateMyceliumHandler;
use App\Generator\Message\GenerateMyceliumMessage;
use App\Repository\SporocarpRepository;
use App\Tests\DummiesFactory;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AmanitaGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new AmanitaGeneratorFixtures());
    }

    /**
     * @return void
     */
    public function testItGeneratesAmanitaIfConditionsAreValid(): void
    {
        self::bootKernel();
        $em = self::getContainer()->get('doctrine.orm.entity_manager');

        $validWeather = DummiesFactory::newWeather();
        $validWeather->setMaxTemperature(25);
        $validWeather->setMinTemperature(10);
        $em->persist($validWeather);
        $em->flush();

        $mycelium = $this
            ->fixturesRepository
            ->getReference(AmanitaGeneratorFixtures::AMANITA_MYCELIUM_REFERENCE, Mycelium::class);

        $generator = self::getContainer()->get(GenerateMyceliumHandler::class);
        $generator->__invoke(new GenerateMyceliumMessage($mycelium->getId()));

        $sporocarpRepository = self::getContainer()->get(SporocarpRepository::class);
        $sporocarps = $sporocarpRepository->findALl();

        self::assertGreaterThanOrEqual(2, count($sporocarps));
    }

    /**
     * @dataProvider provideItDoesNotGeneratesAmanitaIfConditionsAreInvalid
     *
     * @param int $min
     * @param int $max
     *
     * @return void
     */
    public function testItDoesNotGeneratesAmanitaIfConditionsAreInvalid(int $min, int $max): void
    {
        self::bootKernel();
        $em = self::getContainer()->get('doctrine.orm.entity_manager');

        $validWeather = DummiesFactory::newWeather();
        $validWeather->setMaxTemperature($max);
        $validWeather->setMinTemperature($min);
        $em->persist($validWeather);
        $em->flush();

        $mycelium = $this
            ->fixturesRepository
            ->getReference(AmanitaGeneratorFixtures::AMANITA_MYCELIUM_REFERENCE, Mycelium::class);

        $generator = self::getContainer()->get(GenerateMyceliumHandler::class);
        $generator->__invoke(new GenerateMyceliumMessage($mycelium->getId()));

        $sporocarpRepository = self::getContainer()->get(SporocarpRepository::class);
        $sporocarps = $sporocarpRepository->findALl();

        self::assertSame(0, count($sporocarps));
    }

    private function provideItDoesNotGeneratesAmanitaIfConditionsAreInvalid(): array
    {
        return [
            [9, 15],
            [15, 28],
            [9, 28],
        ];
    }
}
