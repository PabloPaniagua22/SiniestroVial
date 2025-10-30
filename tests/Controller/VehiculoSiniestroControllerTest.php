<?php

namespace App\Tests\Controller;

use App\Entity\VehiculoSiniestro;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VehiculoSiniestroControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $vehiculoSiniestroRepository;
    private string $path = '/vehiculo/siniestro/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->vehiculoSiniestroRepository = $this->manager->getRepository(VehiculoSiniestro::class);

        foreach ($this->vehiculoSiniestroRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('VehiculoSiniestro index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'vehiculo_siniestro[siniestro]' => 'Testing',
            'vehiculo_siniestro[vehiculo]' => 'Testing',
            'vehiculo_siniestro[persona]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->vehiculoSiniestroRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new VehiculoSiniestro();
        $fixture->setSiniestro('My Title');
        $fixture->setVehiculo('My Title');
        $fixture->setPersona('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('VehiculoSiniestro');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new VehiculoSiniestro();
        $fixture->setSiniestro('Value');
        $fixture->setVehiculo('Value');
        $fixture->setPersona('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'vehiculo_siniestro[siniestro]' => 'Something New',
            'vehiculo_siniestro[vehiculo]' => 'Something New',
            'vehiculo_siniestro[persona]' => 'Something New',
        ]);

        self::assertResponseRedirects('/vehiculo/siniestro/');

        $fixture = $this->vehiculoSiniestroRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getSiniestro());
        self::assertSame('Something New', $fixture[0]->getVehiculo());
        self::assertSame('Something New', $fixture[0]->getPersona());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new VehiculoSiniestro();
        $fixture->setSiniestro('Value');
        $fixture->setVehiculo('Value');
        $fixture->setPersona('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/vehiculo/siniestro/');
        self::assertSame(0, $this->vehiculoSiniestroRepository->count([]));
    }
}
