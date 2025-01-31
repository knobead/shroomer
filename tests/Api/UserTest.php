<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Repository\UserRepository;
use App\Tests\FixtureLoaderCapableTrait;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends ApiTestCase
{
    use FixtureLoaderCapableTrait;
    use PerformAuthenticateRequestTrait;

    private Client $client;
    private Container $container;

    public function setUp():void
    {
        $this->client = self::createClient();
        $this->container = self::getContainer();
        $this->token = '';
        $this->loadFixtureWithContainer(new UserFixtures(), $this->container);
    }

    public function testItCouldAddAUser(): void
    {
        $userJson = [
            'email' => 'new@email.com',
            'plainPassword' => 'pwd',
        ];

        $response = $this->client->request(
            Request::METHOD_POST,
            'api/register',
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'json' => $userJson
            ],
        );

        self::assertSame(Response::HTTP_CREATED, $response->getStatusCode());
        $users = $this->container->get(UserRepository::class)->findAll();

        self::assertCount(2, $users);
        $addedUser = $users[1];

        self::assertSame('new@email.com', $addedUser->getEmail());
    }

    public function testItCouldNotAddAnExistingEmail(): void
    {
        $userJson = [
            'email' => 'existing@user.com',
            'plainPassword' => 'pwd',
        ];

        $response = $this->client->request(
            Request::METHOD_POST,
            'api/register',
            [
                'headers' => ['content-type' => 'application/ld+json'],
                'json' => $userJson
            ],
        );

        self::assertSame(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());

        $content = $response->toArray(false);
        self::assertArrayHasKey('violations', $content);
        self::assertCount(1, $content['violations']);
        self::assertSame('email', $content['violations'][0]['propertyPath']);
        self::assertSame('This value is already used.', $content['violations'][0]['message']);

        $users = $this->container->get(UserRepository::class)->findAll();
        self::assertCount(1, $users);
    }
}
