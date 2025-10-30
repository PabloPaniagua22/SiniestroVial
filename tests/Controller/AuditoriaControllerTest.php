<?php

namespace App\Tests\Controller;

use App\Entity\Auditoria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AuditoriaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $auditoriumRepository;
    private string $path = '/auditoria/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->auditoriumRepository = $this->manager->getRepository(Auditoria::class);

        foreach ($this->auditoriumRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auditorium index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'auditorium[accion]' => 'Testing',
            'auditorium[entidadAfectada]' => 'Testing',
            'auditorium[fechaHora]' => 'Testing',
            'auditorium[usuario]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->auditoriumRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auditoria();
        $fixture->setAccion('My Title');
        $fixture->setEntidadAfectada('My Title');
        $fixture->setFechaHora('My Title');
        $fixture->setUsuario('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Auditorium');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auditoria();
        $fixture->setAccion('Value');
        $fixture->setEntidadAfectada('Value');
        $fixture->setFechaHora('Value');
        $fixture->setUsuario('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'auditorium[accion]' => 'Something New',
            'auditorium[entidadAfectada]' => 'Something New',
            'auditorium[fechaHora]' => 'Something New',
            'auditorium[usuario]' => 'Something New',
        ]);

        self::assertResponseRedirects('/auditoria/');

        $fixture = $this->auditoriumRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getAccion());
        self::assertSame('Something New', $fixture[0]->getEntidadAfectada());
        self::assertSame('Something New', $fixture[0]->getFechaHora());
        self::assertSame('Something New', $fixture[0]->getUsuario());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Auditoria();
        $fixture->setAccion('Value');
        $fixture->setEntidadAfectada('Value');
        $fixture->setFechaHora('Value');
        $fixture->setUsuario('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/auditoria/');
        self::assertSame(0, $this->auditoriumRepository->count([]));
    }
}
