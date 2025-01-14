<?php
declare(strict_types=1);

namespace App\Tests\Generator\Tree;

use App\Entity\Tree;
use App\Generator\Handler\GenerateTreeHandler;
use App\Generator\Message\GenerateTreeMessage;
use App\Repository\MyceliumRepository;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TreeGeneratorTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new TreeGeneratorFixtures());
    }

    public function testItGeneratesATree(): void
    {
        /** @var Tree $tree */
        $tree = $this->fixturesRepository->getReference(TreeGeneratorFixtures::FIRST_TREE_REFERENCE);
        $myceliumRepository = $this->client->getContainer()->get(MyceliumRepository::class);

        $generator = self::getContainer()->get(GenerateTreeHandler::class);
        $generator->__invoke(new GenerateTreeMessage($tree->getId()));

        $myceliums = $myceliumRepository->findByTree($tree);

        self::assertSame(56, $tree->getAge());
        self::assertCount(1, $myceliums);
    }
}
