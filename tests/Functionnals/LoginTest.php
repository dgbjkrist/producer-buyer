<?php

declare(strict_types=1);

namespace App\Tests\Functionnals;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoginTest extends WebTestCase
{
    /**
     * @dataProvider provideEmail
     */
    public function testSuccessfullLogin(string $email): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(Request::METHOD_GET, $router->generate("security_login"));

        $form = $crawler->filter("form[name=login]")->form([
            "email" => $email,
            "password" => "password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function provideEmail(): \Generator
    {
        yield['producer@gmail.com'];
        yield['customer@gmail.com'];
    }
}
