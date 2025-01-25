<?php

declare(strict_types=1);

namespace App\Tests\Generator\Mycelium;

use App\Entity\Mycelium;
use App\Entity\Tree;
use App\Generator\Handler\GenerateMyceliumHandler;
use App\Generator\Message\GenerateMyceliumMessage;
use App\Repository\SporocarpRepository;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MyceliumGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new MyceliumGeneratorFixtures());
    }


    public function testItPopsSporocarpWhenMyceliumIsEmpty(): void
    {
        /** @var Tree $mycelium */
        $mycelium = $this->fixturesRepository->getReference(MyceliumGeneratorFixtures::MYCELIUM_EMPTY_REFERENCE, Mycelium::class);
        $sporocarpRepository = self::getContainer()->get(SporocarpRepository::class);

        $generator = self::getContainer()->get(GenerateMyceliumHandler::class);
        $generator->__invoke(new GenerateMyceliumMessage($mycelium->getId()));

        $sporocarps = $sporocarpRepository->findAll();
        self::assertCount(2, $sporocarps, 'it must add one pleurotus!');
    }

    public function testItDoesNotPopSporocarpWhenMyceliumIsFull(): void
    {
        /** @var Tree $mycelium */
        $mycelium = $this->fixturesRepository->getReference(MyceliumGeneratorFixtures::MYCELIUM_FULL_REFERENCE, Mycelium::class);
        $sporocarpRepository = self::getContainer()->get(SporocarpRepository::class);

        $generator = self::getContainer()->get(GenerateMyceliumHandler::class);
        $generator->__invoke(new GenerateMyceliumMessage($mycelium->getId()));

        $sporocarps = $sporocarpRepository->findAll();
        self::assertCount(1, $sporocarps, 'it must not add a pleurotus!');
    }

    public function testItDoesNotPopSporocarpWhenMyceliumConditionsFails(): void
    {
        /** @var Tree $mycelium */
        $mycelium = $this->fixturesRepository->getReference(MyceliumGeneratorFixtures::MYCELIUM_FAILED_REFERENCE, Mycelium::class);
        $sporocarpRepository = self::getContainer()->get(SporocarpRepository::class);

        $generator = self::getContainer()->get(GenerateMyceliumHandler::class);
        $generator->__invoke(new GenerateMyceliumMessage($mycelium->getId()));

        $sporocarps = $sporocarpRepository->findAll();
        self::assertCount(1, $sporocarps, 'it must add one boletus!');
    }
}
