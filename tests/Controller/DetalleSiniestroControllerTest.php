<?php

namespace App\Tests\Controller;

use App\Entity\DetalleSiniestro;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DetalleSiniestroControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $detalleSiniestroRepository;
    private string $path = '/detalle/siniestro/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->detalleSiniestroRepository = $this->manager->getRepository(DetalleSiniestro::class);

        foreach ($this->detalleSiniestroRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('DetalleSiniestro index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'detalle_siniestro[estadoAlcoholico]' => 'Testing',
            'detalle_siniestro[porcentajeAlcohol]' => 'Testing',
            'detalle_siniestro[observaciones]' => 'Testing',
            'detalle_siniestro[rutaDocumento]' => 'Testing',
            'detalle_siniestro[siniestro]' => 'Testing',
            'detalle_siniestro[persona]' => 'Testing',
            'detalle_siniestro[rolPersona]' => 'Testing',
            'detalle_siniestro[vehiculo]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->detalleSiniestroRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new DetalleSiniestro();
        $fixture->setEstadoAlcoholico('My Title');
        $fixture->setPorcentajeAlcohol('My Title');
        $fixture->setObservaciones('My Title');
        $fixture->setRutaDocumento('My Title');
        $fixture->setSiniestro('My Title');
        $fixture->setPersona('My Title');
        $fixture->setRolPersona('My Title');
        $fixture->setVehiculo('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('DetalleSiniestro');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new DetalleSiniestro();
        $fixture->setEstadoAlcoholico('Value');
        $fixture->setPorcentajeAlcohol('Value');
        $fixture->setObservaciones('Value');
        $fixture->setRutaDocumento('Value');
        $fixture->setSiniestro('Value');
        $fixture->setPersona('Value');
        $fixture->setRolPersona('Value');
        $fixture->setVehiculo('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'detalle_siniestro[estadoAlcoholico]' => 'Something New',
            'detalle_siniestro[porcentajeAlcohol]' => 'Something New',
            'detalle_siniestro[observaciones]' => 'Something New',
            'detalle_siniestro[rutaDocumento]' => 'Something New',
            'detalle_siniestro[siniestro]' => 'Something New',
            'detalle_siniestro[persona]' => 'Something New',
            'detalle_siniestro[rolPersona]' => 'Something New',
            'detalle_siniestro[vehiculo]' => 'Something New',
        ]);

        self::assertResponseRedirects('/detalle/siniestro/');

        $fixture = $this->detalleSiniestroRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getEstadoAlcoholico());
        self::assertSame('Something New', $fixture[0]->getPorcentajeAlcohol());
        self::assertSame('Something New', $fixture[0]->getObservaciones());
        self::assertSame('Something New', $fixture[0]->getRutaDocumento());
        self::assertSame('Something New', $fixture[0]->getSiniestro());
        self::assertSame('Something New', $fixture[0]->getPersona());
        self::assertSame('Something New', $fixture[0]->getRolPersona());
        self::assertSame('Something New', $fixture[0]->getVehiculo());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new DetalleSiniestro();
        $fixture->setEstadoAlcoholico('Value');
        $fixture->setPorcentajeAlcohol('Value');
        $fixture->setObservaciones('Value');
        $fixture->setRutaDocumento('Value');
        $fixture->setSiniestro('Value');
        $fixture->setPersona('Value');
        $fixture->setRolPersona('Value');
        $fixture->setVehiculo('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/detalle/siniestro/');
        self::assertSame(0, $this->detalleSiniestroRepository->count([]));
    }
}
