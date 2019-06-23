<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisteurStagiaireControllerTest extends WebTestCase
{
    public function testAfficher()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/afficher');
    }

    public function testAjouterstagiairea()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/ajouterstagiaireA');
    }

    public function testModifierstagiaire()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modifierstagiaire');
    }

    public function testSupprimerstagiaire()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/supprimerstagiaire');
    }

}
