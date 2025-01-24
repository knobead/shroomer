<?php

declare(strict_types=1);

namespace App\Tests\Generator\Tree;

use App\Entity\MyceliumGenusEnum;
use App\Entity\Tree;
use App\Generator\Handler\GenerateTreeHandler;
use App\Generator\Message\GenerateTreeMessage;
use App\Repository\MyceliumRepository;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TreeGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new TreeGeneratorFixtures());
    }

    public function testItAgesATree(): void
    {
        /** @var Tree $tree */
        $tree = $this->fixturesRepository->getReference(TreeGeneratorFixtures::FIRST_TREE_REFERENCE);

        $generator = self::getContainer()->get(GenerateTreeHandler::class);
        $generator->__invoke(new GenerateTreeMessage($tree->getId()));

        self::assertSame(11, $tree->getAge());
    }

    /**
     * @dataProvider providesItAddMyceliums
     *
     * @param string $reference
     * @param int    $count
     *
     * @return void
     */
    public function testItAddMyceliums(string $reference, int $count): void
    {
        /** @var Tree $tree */
        $tree = $this->fixturesRepository->getReference($reference);
        $myceliumRepository = $this->client->getContainer()->get(MyceliumRepository::class);

        $generator = self::getContainer()->get(GenerateTreeHandler::class);

        for ($i = 0; $i < 5; $i++) {
            $generator->__invoke(new GenerateTreeMessage($tree->getId()));
        }

        $myceliums = $myceliumRepository->findByTree($tree);
        self::assertCount($count, $myceliums);
    }

    /**
     * @return array
     */
    public function providesItAddMyceliums(): array
    {
        return [
            [TreeGeneratorFixtures::FIRST_TREE_REFERENCE, 0],
            [TreeGeneratorFixtures::SECOND_TREE_REFERENCE, 1],
            [TreeGeneratorFixtures::THIRD_TREE_REFERENCE, 2],
            [TreeGeneratorFixtures::FOURTH_TREE_REFERENCE, 2],
            [TreeGeneratorFixtures::FIFTH_TREE_REFERENCE, 3],
        ];
    }
}
