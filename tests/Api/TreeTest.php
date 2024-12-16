<?php

declare(strict_types=1);

namespace App\Tests\Api;

use App\Entity\Tree;
use App\Entity\TreeGenusesEnum;
use App\Entity\Zone;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class TreeTest extends WebTestCase
{
    use FixtureLoaderCapableTrait;

    private KernelBrowser $client;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->loadFixture(new TreeFixtures());
    }

    public function testItCouldAddATree(): void
    {
        /** @var RouterInterface $router */
        $router = self::getContainer()->get('router');
        /** @var Zone $zone */
        $zone = $this->fixturesRepository->getReference( TreeFixtures::ZONE_REFERENCE, Zone::class);
        $zoneUri = $router->generate('api_zone_get', ['id' => $zone->getId()]);
        $jsonTree = [
            'size' => 0,
            'age' => 0,
            'genus' => TreeGenusesEnum::GENUS_QUERCUS,
            'zone' => $zoneUri
        ];

        $this->client->xmlHttpRequest(
            method:Request::METHOD_POST,
            uri: 'api/tree',
            server: ['CONTENT_TYPE'=> 'application/ld+json'],
            content: json_encode($jsonTree)
        );

        $response = $this->client->getResponse();
        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());

        $treeRepository = self::getContainer()->get('doctrine')->getRepository(Tree::class);
        $trees = $treeRepository->findAll();
        self::assertCount(2, $trees, 'no tree were added');
        $tree = $trees[1];
        self::assertSame(TreeGenusesEnum::GENUS_QUERCUS, $tree->getGenus());
        self::assertSame(0, $tree->getSize());
        self::assertSame(0, $tree->getAge());
    }
}
