<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Command\GenerateIterationCommand;
use App\Entity\Mycelium;
use App\Entity\Sporocarp;
use App\Entity\Weather;
use App\Entity\Zone;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateIterationCommandTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new GenerateIterationCommandFixtures());
    }

    public function testItExecutesCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $doctrine = self::$kernel->getContainer()->get('doctrine');

        $weatherRepository = $doctrine->getManager()->getRepository(Weather::class);
        $weathers = $weatherRepository->findAll();
        self::assertCount(0, $weathers);

        $command = $application->find('app:generate:iteration');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['--'.GenerateIterationCommand::COUNT_OPTION => 20]);

        $commandTester->assertCommandIsSuccessful();

        $weatherRepository = $doctrine->getManager()->getRepository(Weather::class);
        $weathers = $weatherRepository->findAll();
        self::assertCount(20, $weathers);

        $zoneRepository = $doctrine->getManager()->getRepository(Zone::class);
        $zones = $zoneRepository->findAll();
        self::assertCount(1, $zones);

        $myceliumRepository = $doctrine->getManager()->getRepository(Mycelium::class);
        $myceliums = $myceliumRepository->findAll();
        self::assertCount(2, $myceliums);

        $sporocarpRepository = $doctrine->getManager()->getRepository(Sporocarp::class);
        $sporocarps = $sporocarpRepository->findAll();
        $count = count($sporocarps);
        self::assertGreaterThanOrEqual(2, $count);
        self::assertLessThanOrEqual(4, $count);
    }
}
