<?php

namespace App\Test\Controller;

use App\Entity\Contacto;
use App\Repository\ContactoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactoControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ContactoRepository $repository;
    private string $path = '/contacto/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Contacto::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Contacto index');

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
            'contacto[nombreContacto]' => 'Testing',
            'contacto[consultaContacto]' => 'Testing',
            'contacto[emailContacto]' => 'Testing',
        ]);

        self::assertResponseRedirects('/contacto/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contacto();
        $fixture->setNombreContacto('My Title');
        $fixture->setConsultaContacto('My Title');
        $fixture->setEmailContacto('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Contacto');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Contacto();
        $fixture->setNombreContacto('My Title');
        $fixture->setConsultaContacto('My Title');
        $fixture->setEmailContacto('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'contacto[nombreContacto]' => 'Something New',
            'contacto[consultaContacto]' => 'Something New',
            'contacto[emailContacto]' => 'Something New',
        ]);

        self::assertResponseRedirects('/contacto/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getNombreContacto());
        self::assertSame('Something New', $fixture[0]->getConsultaContacto());
        self::assertSame('Something New', $fixture[0]->getEmailContacto());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Contacto();
        $fixture->setNombreContacto('My Title');
        $fixture->setConsultaContacto('My Title');
        $fixture->setEmailContacto('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/contacto/');
    }
}
