<?php

declare(strict_types=1);

namespace App\Tests\Functionnals;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ForgottenPasswordTest extends WebTestCase
{
    /**
     * @dataProvider provideEmail
     */
    public function testSuccessfullForgottenPassword(string $email): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(Request::METHOD_GET, $router->generate("security_forgotten_password"));

        $form = $crawler->filter("form[name=forgotten_password]")->form([
            "forgotten_password[email]" => $email
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
