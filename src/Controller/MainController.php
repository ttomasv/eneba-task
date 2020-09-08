<?php

namespace App\Controller;

use App\Entity\Sentence;
use App\Repository\SentenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @var SentenceRepository
     */
    private $sentenceRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(SentenceRepository $sentenceRepository, EntityManagerInterface $entityManager) {

        $this->sentenceRepository = $sentenceRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        $goesFirst = ["Oi tu", "Och tu", "Ach tu"];
        $goesSecond = ["aukštielninka", "stora", "skraidanti", "išverstaakė", "bjauri", "kvaila", "negraži", "bevertė"];
        $goesThird = ["rupūžė", "kiaulė", "karvė", "višta"];

        $sentence = "";
        $sentence .= $goesFirst[array_rand($goesFirst)] . " ";

        $fromOneToThree = rand(1,3);
        $usedWords = [];

        for ( $i = 0; $i < $fromOneToThree; $i++ ) {

            $temp = $goesSecond[array_rand($goesSecond)];

            if(!in_array($temp, $usedWords)) {

                $sentence .= $temp;

                if( $i < $fromOneToThree - 1 ) {
                    $sentence .= ", ";
                }
                else {
                    $sentence .= " ";
                }
            }
            else {
                $i--;
            }
            array_push($usedWords, $temp);
        }

        $sentence .= $goesThird[array_rand($goesThird)] . "!";

        return $this->render('main/index.html.twig', [
            'randomSentence' => $sentence
        ]);
    }

    /**
     * @Route("/save", name="save")
     * @param Request $request
     * @return string
     */
    public function getSentence(Request $request)
    {
        $sentence = new Sentence();

        $form = $this->createFormBuilder($sentence)
            ->add('text')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sentence = $form->getData();

            $this->entityManager->persist($sentence);
            $this->entityManager->flush();

            return $this->render('main/generatedUrl.html.twig', [
                'url' => 'http://localhost:8000/' . $sentence->getId(),
                'sentence' => $sentence->getText(),
            ]);
        }
        else
            {
                return $this->render('main/generatedUrl.html.twig', [
                    'url' => 'url not found',
                    'sentence' => 'error: form is not submitted',
                ]);
            }
    }

    /**
     * @Route("/{id}", name="specific")
     * @param int $id
     * @return Response
     */
    public function find (int $id)
    {
        $sentence = $this->findText($id);

        return $this->render('main/specific.html.twig', [
            'sentence' => $sentence,
        ]);
    }

    /**
     * @param int $id
     * @return string
     */
    public function findText (int $id)
    {
        $sentence = $this->sentenceRepository->find($id);

        if($sentence) {
            return $sentence->getText();
        } else {
            return "Sentence with ID: " . $id . " does not exist!";
        }
    }
}
