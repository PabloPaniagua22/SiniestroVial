<?php

namespace App\Tests\Controller;

use App\Entity\Vehiculo;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class VehiculoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $vehiculoRepository;
    private string $path = '/vehiculo/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->vehiculoRepository = $this->manager->getRepository(Vehiculo::class);

        foreach ($this->vehiculoRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vehiculo index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'vehiculo[tipo]' => 'Testing',
            'vehiculo[patente]' => 'Testing',
            'vehiculo[marca]' => 'Testing',
            'vehiculo[modelo]' => 'Testing',
            'vehiculo[anio]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->vehiculoRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vehiculo();
        $fixture->setTipo('My Title');
        $fixture->setPatente('My Title');
        $fixture->setMarca('My Title');
        $fixture->setModelo('My Title');
        $fixture->setAnio('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Vehiculo');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vehiculo();
        $fixture->setTipo('Value');
        $fixture->setPatente('Value');
        $fixture->setMarca('Value');
        $fixture->setModelo('Value');
        $fixture->setAnio('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'vehiculo[tipo]' => 'Something New',
            'vehiculo[patente]' => 'Something New',
            'vehiculo[marca]' => 'Something New',
            'vehiculo[modelo]' => 'Something New',
            'vehiculo[anio]' => 'Something New',
        ]);

        self::assertResponseRedirects('/vehiculo/');

        $fixture = $this->vehiculoRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getTipo());
        self::assertSame('Something New', $fixture[0]->getPatente());
        self::assertSame('Something New', $fixture[0]->getMarca());
        self::assertSame('Something New', $fixture[0]->getModelo());
        self::assertSame('Something New', $fixture[0]->getAnio());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Vehiculo();
        $fixture->setTipo('Value');
        $fixture->setPatente('Value');
        $fixture->setMarca('Value');
        $fixture->setModelo('Value');
        $fixture->setAnio('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/vehiculo/');
        self::assertSame(0, $this->vehiculoRepository->count([]));
    }
}
