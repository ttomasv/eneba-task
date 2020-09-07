<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
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
}
