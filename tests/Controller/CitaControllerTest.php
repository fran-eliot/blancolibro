<?php

namespace App\Test\Controller;

use App\Entity\Cita;
use App\Repository\CitaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CitaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private CitaRepository $repository;
    private string $path = '/cita/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Cita::class);
        $this->manager = static::getContainer()->get('doctrine')->getManager();

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cita index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

       // $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'cita[tipoPadre]' => 'SECCION',
            'cita[contenidoCita]' => 'Testing',
            'cita[fkSeccion]' => "",
            'cita[fkApartado]' => "",
            'cita[fkSubapartado]' => "",
        ]);

        self::assertResponseRedirects('/cita/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
       // $this->markTestIncomplete();
        $fixture = new Cita();
        $fixture->setTipoPadre('SECCION');
        $fixture->setContenidoCita('My Title');
        $fixture->setFkSeccion(NULL);
        $fixture->setFkApartado(NULL);
        $fixture->setFkSubapartado(NULL);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Cita');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
      //  $this->markTestIncomplete();
        $fixture = new Cita();
        $fixture->setTipoPadre('SECCION');
        $fixture->setContenidoCita('My Title');
        $fixture->setFkSeccion(NULL);
        $fixture->setFkApartado(NULL);
        $fixture->setFkSubapartado(NULL);

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'cita[tipoPadre]' => 'APARTADO',
            'cita[contenidoCita]' => 'Something New',
            'cita[fkSeccion]' => '',
            'cita[fkApartado]' => '',
            'cita[fkSubapartado]' => '',
        ]);

        self::assertResponseRedirects('/cita/');

        $fixture = $this->repository->findAll();

        self::assertSame('APARTADO', $fixture[0]->getTipoPadre());
        self::assertSame('Something New', $fixture[0]->getContenidoCita());
        self::assertSame(NULL, $fixture[0]->getFkSeccion());
        self::assertSame(NULL, $fixture[0]->getFkApartado());
        self::assertSame(NULL, $fixture[0]->getFkSubapartado());
    }

    public function testRemove(): void
    {
      //  $this->markTestIncomplete();


        $originalNumObjectsInRepository = count($this->repository->findAll());


        $fixture = new Cita();
        $fixture->setTipoPadre('APARTADO');
        $fixture->setContenidoCita('My Title');
        $fixture->setFkSeccion(NULL);
        $fixture->setFkApartado(NULL);
        $fixture->setFkSubapartado(NULL);

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');
       
        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/cita/');
    }
}
