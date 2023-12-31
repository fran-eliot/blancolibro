<?php

namespace App\Test\Controller;

use App\Entity\Apartado;
use App\Entity\Seccion;
use App\Repository\ApartadoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApartadoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ApartadoRepository $repository;
    private string $path = '/apartado/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Apartado::class);
        $this->manager = static::getContainer()->get('doctrine')->getManager();

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Apartado index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

   //     $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'apartado[tituloApartado]' => 'Testing',
            'apartado[contenidoApartado]' => 'Testing',
            'apartado[fkSeccion]' => '10',
        ]);

        self::assertResponseRedirects('/apartado/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
    //    $this->markTestIncomplete();
       
        $seccion = new Seccion();
        $seccion->setTituloSeccion('Test');
        $this->manager->persist($seccion);
        $this->manager->flush();
        
        $fixture = new Apartado();
        $fixture->setTituloApartado('My Title');
        $fixture->setContenidoApartado('My Title');
        $fixture->setFkSeccion($seccion);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Apartado');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
  //      $this->markTestIncomplete();
        $seccion = new Seccion();
        $seccion->setTituloSeccion('Test');
        $this->manager->persist($seccion);
        $this->manager->flush();

        $fixture = new Apartado();
        $fixture->setTituloApartado('My Title');
        $fixture->setContenidoApartado('My Title');
        $fixture->setFkSeccion($seccion);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'apartado[tituloApartado]' => 'Something New',
            'apartado[contenidoApartado]' => 'Something New',
            'apartado[fkSeccion]' => $seccion->getId(),
        ]);

        self::assertResponseRedirects('/apartado/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTituloApartado());
        self::assertSame('Something New', $fixture[0]->getContenidoApartado());
        self::assertSame($seccion->getId(), $fixture[0]->getFkSeccion()->getId());
    }

    public function testRemove(): void
    {
   //     $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $seccion = new Seccion();
        $seccion->setTituloSeccion('Test');
        $this->manager->persist($seccion);
        $this->manager->flush();

        $fixture = new Apartado();
        $fixture->setTituloApartado('My Title');
        $fixture->setContenidoApartado('My Title');
        $fixture->setFkSeccion($seccion);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/apartado/');
    }
}
