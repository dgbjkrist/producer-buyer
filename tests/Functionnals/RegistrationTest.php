<?php

namespace App\Tests\Functionnals;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class RegistrationTest extends WebTestCase
{
    /**
     * @dataProvider provideRoles
     */
    public function testSuccessfullRegistration(string $role): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = $client->getContainer()->get("router");

        $crawler = $client->request(Request::METHOD_GET, $router->generate("security_registration", [
            "role" => $role
        ]));

        $form = $crawler->filter("form[name=registration_form]")->form([
            "registration_form[email]" => "email@gmail.com",
            "registration_form[firstName]" => "limbo",
            "registration_form[lastName]" => "kiriku",
            "registration_form[plainPassword]" => "password"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function provideRoles(): Generator
    {
        yield['producer'];
        yield['customer'];
    }
}
