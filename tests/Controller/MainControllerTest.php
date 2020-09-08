<?php

namespace App\Tests\Controller;

use App\Controller\MainController;
use App\Entity\Sentence;
use App\Repository\SentenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testGetText()
    {
        $sentence = new Sentence();
        $sentence->setText('Oi tu išverstaakė karvė!');

        $sentenceRepository = $this->createMock(SentenceRepository::class);

        $sentenceRepository->expects($this->any())
            ->method('find')
            ->willReturn($sentence);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($sentenceRepository);

        $test = new MainController($sentenceRepository,$entityManager);

        $this->assertEquals("Oi tu išverstaakė karvė!", $test->findText(1));
    }

    public function testGenerateSentence()
    {
        $sentence = new Sentence();

        $sentenceRepository = $this->createMock(SentenceRepository::class);

        $sentenceRepository->expects($this->any())
            ->method('find')
            ->willReturn($sentence);

        $entityManager = $this->createMock(EntityManagerInterface::class);

        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($sentenceRepository);

        $test = new MainController($sentenceRepository, $entityManager);

        $this->assertNotNull($test->generateSentence());
    }

    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}