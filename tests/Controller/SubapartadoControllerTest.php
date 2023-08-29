<?php

namespace App\Test\Controller;

use App\Entity\Subapartado;
use App\Repository\SubapartadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SubapartadoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SubapartadoRepository $repository;
    private string $path = '/subapartado/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Subapartado::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Subapartado index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'subapartado[tituloSubapartado]' => 'Testing',
            'subapartado[contenidoSubapartado]' => 'Testing',
            'subapartado[fkApartado]' => 'Testing',
        ]);

        self::assertResponseRedirects('/subapartado/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Subapartado();
        $fixture->setTituloSubapartado('My Title');
        $fixture->setContenidoSubapartado('My Title');
        $fixture->setFkApartado('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Subapartado');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Subapartado();
        $fixture->setTituloSubapartado('My Title');
        $fixture->setContenidoSubapartado('My Title');
        $fixture->setFkApartado('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'subapartado[tituloSubapartado]' => 'Something New',
            'subapartado[contenidoSubapartado]' => 'Something New',
            'subapartado[fkApartado]' => 'Something New',
        ]);

        self::assertResponseRedirects('/subapartado/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTituloSubapartado());
        self::assertSame('Something New', $fixture[0]->getContenidoSubapartado());
        self::assertSame('Something New', $fixture[0]->getFkApartado());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Subapartado();
        $fixture->setTituloSubapartado('My Title');
        $fixture->setContenidoSubapartado('My Title');
        $fixture->setFkApartado('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/subapartado/');
    }
}
