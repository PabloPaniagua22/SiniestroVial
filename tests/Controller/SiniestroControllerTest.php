<?php

namespace App\Tests\Controller;

use App\Entity\Siniestro;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class SiniestroControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $siniestroRepository;
    private string $path = '/siniestro/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->siniestroRepository = $this->manager->getRepository(Siniestro::class);

        foreach ($this->siniestroRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Siniestro index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'siniestro[fecha]' => 'Testing',
            'siniestro[hora]' => 'Testing',
            'siniestro[descripcion]' => 'Testing',
            'siniestro[severidad]' => 'Testing',
            'siniestro[estado]' => 'Testing',
            'siniestro[localidad]' => 'Testing',
            'siniestro[calle]' => 'Testing',
            'siniestro[coordenadas]' => 'Testing',
            'siniestro[nroActa]' => 'Testing',
            'siniestro[Usuario]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->siniestroRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Siniestro();
        $fixture->setFecha('My Title');
        $fixture->setHora('My Title');
        $fixture->setDescripcion('My Title');
        $fixture->setSeveridad('My Title');
        $fixture->setEstado('My Title');
        $fixture->setLocalidad('My Title');
        $fixture->setCalle('My Title');
        $fixture->setCoordenadas('My Title');
        $fixture->setNroActa('My Title');
        $fixture->setUsuario('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Siniestro');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Siniestro();
        $fixture->setFecha('Value');
        $fixture->setHora('Value');
        $fixture->setDescripcion('Value');
        $fixture->setSeveridad('Value');
        $fixture->setEstado('Value');
        $fixture->setLocalidad('Value');
        $fixture->setCalle('Value');
        $fixture->setCoordenadas('Value');
        $fixture->setNroActa('Value');
        $fixture->setUsuario('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'siniestro[fecha]' => 'Something New',
            'siniestro[hora]' => 'Something New',
            'siniestro[descripcion]' => 'Something New',
            'siniestro[severidad]' => 'Something New',
            'siniestro[estado]' => 'Something New',
            'siniestro[localidad]' => 'Something New',
            'siniestro[calle]' => 'Something New',
            'siniestro[coordenadas]' => 'Something New',
            'siniestro[nroActa]' => 'Something New',
            'siniestro[Usuario]' => 'Something New',
        ]);

        self::assertResponseRedirects('/siniestro/');

        $fixture = $this->siniestroRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getFecha());
        self::assertSame('Something New', $fixture[0]->getHora());
        self::assertSame('Something New', $fixture[0]->getDescripcion());
        self::assertSame('Something New', $fixture[0]->getSeveridad());
        self::assertSame('Something New', $fixture[0]->getEstado());
        self::assertSame('Something New', $fixture[0]->getLocalidad());
        self::assertSame('Something New', $fixture[0]->getCalle());
        self::assertSame('Something New', $fixture[0]->getCoordenadas());
        self::assertSame('Something New', $fixture[0]->getNroActa());
        self::assertSame('Something New', $fixture[0]->getUsuario());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Siniestro();
        $fixture->setFecha('Value');
        $fixture->setHora('Value');
        $fixture->setDescripcion('Value');
        $fixture->setSeveridad('Value');
        $fixture->setEstado('Value');
        $fixture->setLocalidad('Value');
        $fixture->setCalle('Value');
        $fixture->setCoordenadas('Value');
        $fixture->setNroActa('Value');
        $fixture->setUsuario('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/siniestro/');
        self::assertSame(0, $this->siniestroRepository->count([]));
    }
}
