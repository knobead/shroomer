<?php

declare(strict_types=1);

namespace App\Tests\Generator\Sporocarp;

use App\Entity\Sporocarp;
use App\Entity\User;
use App\Generator\Handler\GenerateSporocarpHandler;
use App\Generator\Message\GenerateSporocarpMessage;
use App\Repository\SporocarpRepository;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SporocarpGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new SporocarpGeneratorFixtures());
    }

    public function testItGeneratesASporocarp(): void
    {
        /** @var Sporocarp $sporocarp */
        $sporocarp = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::SPOROCARP_REFERENCE, Sporocarp::class);

        $generator = self::getContainer()->get(GenerateSporocarpHandler::class);
        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));

        self::assertSame(16, $sporocarp->getAge());
        self::assertGreaterThanOrEqual(10, $sporocarp->getSize());
        self::assertLessThanOrEqual(12, $sporocarp->getSize());
    }

    public function testItDoesNotAlterAYoungSporocarp(): void
    {
        /** @var Sporocarp $sporocarp */
        $sporocarp = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::SECOND_SPOROCARP_REFERENCE, Sporocarp::class);

        $generator = self::getContainer()->get(GenerateSporocarpHandler::class);
        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));

        self::assertSame(3, $sporocarp->getAge());
        self::assertGreaterThanOrEqual(10, $sporocarp->getSize());
        self::assertLessThanOrEqual(12, $sporocarp->getSize());
        self::assertFalse($sporocarp->isEaten());
        self::assertFalse($sporocarp->isRotten());
        self::assertFalse($sporocarp->isWormy());
    }

    public function testItTurnsEatenSporocarpToRotten(): void
    {
        /** @var Sporocarp $sporocarp */
        $sporocarp = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::THIRD_SPOROCARP_REFERENCE, Sporocarp::class);

        $generator = self::getContainer()->get(GenerateSporocarpHandler::class);
        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));

        self::assertSame(10, $sporocarp->getAge());
        self::assertTrue($sporocarp->isRotten());
        self::assertTrue($sporocarp->isEaten());

        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));
        $user = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::USER_REFERENCE, User::class);
        self::assertSame(1, $user->getResourceFauna());
        self::assertSame(0, $user->getResourceEntomofauna());
        self::assertSame(1, $user->getResourceFlora());
    }

    public function testItTurnsWormySporocarpToRotten(): void
    {
        /** @var Sporocarp $sporocarp */
        $sporocarp = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::FIFTH_SPOROCARP_REFERENCE, Sporocarp::class);

        $generator = self::getContainer()->get(GenerateSporocarpHandler::class);
        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));

        self::assertSame(10, $sporocarp->getAge());
        self::assertTrue($sporocarp->isRotten());
        self::assertTrue($sporocarp->isWormy());

        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));
        $user = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::USER_REFERENCE, User::class);
        self::assertSame(0, $user->getResourceFauna());
        self::assertSame(1, $user->getResourceEntomofauna());
        self::assertSame(1, $user->getResourceFlora());
    }

    public function testItDeletesARottenSporocarp(): void
    {
        /** @var Sporocarp $sporocarp */
        $sporocarp = $this->fixturesRepository->getReference(SporocarpGeneratorFixtures::FOURTH_SPOROCARP_REFERENCE, Sporocarp::class);

        $generator = self::getContainer()->get(GenerateSporocarpHandler::class);
        $generator->__invoke(new GenerateSporocarpMessage($sporocarp->getId()));

        /** @var SporocarpRepository $repository */
        $repository = self::getContainer()->get(SporocarpRepository::class);
        $sporocarpFromDb = $repository->findBy(['id' => $sporocarp->getId()]);

        self::assertCount(0, $sporocarpFromDb);
    }
}
