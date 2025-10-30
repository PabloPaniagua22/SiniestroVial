<?php

namespace App\Tests\Controller;

use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UsuarioControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $usuarioRepository;
    private string $path = '/usuario/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->usuarioRepository = $this->manager->getRepository(Usuario::class);

        foreach ($this->usuarioRepository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Usuario index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first()->text());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'usuario[nombre]' => 'Testing',
            'usuario[apellido]' => 'Testing',
            'usuario[email]' => 'Testing',
            'usuario[contrasena]' => 'Testing',
            'usuario[rol]' => 'Testing',
            'usuario[estado]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->usuarioRepository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Usuario();
        $fixture->setNombre('My Title');
        $fixture->setApellido('My Title');
        $fixture->setEmail('My Title');
        $fixture->setContrasena('My Title');
        $fixture->setRol('My Title');
        $fixture->setEstado('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Usuario');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Usuario();
        $fixture->setNombre('Value');
        $fixture->setApellido('Value');
        $fixture->setEmail('Value');
        $fixture->setContrasena('Value');
        $fixture->setRol('Value');
        $fixture->setEstado('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'usuario[nombre]' => 'Something New',
            'usuario[apellido]' => 'Something New',
            'usuario[email]' => 'Something New',
            'usuario[contrasena]' => 'Something New',
            'usuario[rol]' => 'Something New',
            'usuario[estado]' => 'Something New',
        ]);

        self::assertResponseRedirects('/usuario/');

        $fixture = $this->usuarioRepository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombre());
        self::assertSame('Something New', $fixture[0]->getApellido());
        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getContrasena());
        self::assertSame('Something New', $fixture[0]->getRol());
        self::assertSame('Something New', $fixture[0]->getEstado());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Usuario();
        $fixture->setNombre('Value');
        $fixture->setApellido('Value');
        $fixture->setEmail('Value');
        $fixture->setContrasena('Value');
        $fixture->setRol('Value');
        $fixture->setEstado('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/usuario/');
        self::assertSame(0, $this->usuarioRepository->count([]));
    }
}
