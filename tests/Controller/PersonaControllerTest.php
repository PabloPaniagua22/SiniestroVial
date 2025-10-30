<?php

namespace App\Tests\Controller;

use App\Entity\Persona;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PersonaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $personaRepository;
    private string $path = '/persona/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->personaRepository = $this->manager->getRepository(Persona::class);

        foreach ($this->personaRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Persona index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'persona[nombre]' => 'Testing',
            'persona[apellido]' => 'Testing',
            'persona[dni]' => 'Testing',
            'persona[fechaNacimiento]' => 'Testing',
            'persona[genero]' => 'Testing',
            'persona[estadoCivil]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->personaRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Persona();
        $fixture->setNombre('My Title');
        $fixture->setApellido('My Title');
        $fixture->setDni('My Title');
        $fixture->setFechaNacimiento('My Title');
        $fixture->setGenero('My Title');
        $fixture->setEstadoCivil('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Persona');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Persona();
        $fixture->setNombre('Value');
        $fixture->setApellido('Value');
        $fixture->setDni('Value');
        $fixture->setFechaNacimiento('Value');
        $fixture->setGenero('Value');
        $fixture->setEstadoCivil('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'persona[nombre]' => 'Something New',
            'persona[apellido]' => 'Something New',
            'persona[dni]' => 'Something New',
            'persona[fechaNacimiento]' => 'Something New',
            'persona[genero]' => 'Something New',
            'persona[estadoCivil]' => 'Something New',
        ]);

        self::assertResponseRedirects('/persona/');

        $fixture = $this->personaRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getApellido());
        self::assertSame('Something New', $fixture[0]->getDni());
        self::assertSame('Something New', $fixture[0]->getFechaNacimiento());
        self::assertSame('Something New', $fixture[0]->getGenero());
        self::assertSame('Something New', $fixture[0]->getEstadoCivil());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Persona();
        $fixture->setNombre('Value');
        $fixture->setApellido('Value');
        $fixture->setDni('Value');
        $fixture->setFechaNacimiento('Value');
        $fixture->setGenero('Value');
        $fixture->setEstadoCivil('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/persona/');
        self::assertSame(0, $this->personaRepository->count([]));
    }
}
