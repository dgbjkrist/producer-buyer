<?php

declare(strict_types=1);

namespace App\Tests\Functionnals;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class ResetPasswordTest extends WebTestCase
{
    public function testSuccessfullResetPasswordTest(): void
    {
        $client = static::createClient();

        /** @var RouterInterface $router */
        $router = $client->getContainer()->get("router");

        /** @var EntityManagerInterface $em */
        $em = $client->getContainer()->get("doctrine.orm.entity_manager");

        /** @var User $user */
        $user = $em->getRepository(User::class)->find(1);
        $user->hasForgotHisPassword();

        $em->persist($user);
        $em->flush();

        $crawler = $client->request(Request::METHOD_GET, $router->generate("security_reset_password", [
            "token" => (string) $user->getForgottenPassword()->getToken()
        ]));

        $form = $crawler->filter("form[name=reset_password]")->form([
            "reset_password[plainPassword]" => "password20"
        ]);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
}
