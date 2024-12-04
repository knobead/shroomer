<?php

declare(strict_types=1);

namespace App\Tests\Command;

use App\Entity\Weather;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class GenerateIterationCommandTest extends KernelTestCase
{
    public function testItExecutesCommand(): void
    {
        self::bootKernel();
        $application = new Application(self::$kernel);
        $doctrine = self::$kernel->getContainer()->get('doctrine');
        $weatherRepository = $doctrine->getManager()->getRepository(Weather::class);

        $command = $application->find('app:generate:iteration');
        $commandTester = new CommandTester($command);
        $commandTester->execute([]);

        $commandTester->assertCommandIsSuccessful();

        $weathers = $weatherRepository->findAll();
        self::assertCount(1, $weathers);
    }
}
