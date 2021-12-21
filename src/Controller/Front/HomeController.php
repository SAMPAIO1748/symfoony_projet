<?php

namespace App\Controller\Front;

use App\Repository\CategoryRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/", name="front_home")
     */
    public function home(CategoryRepository $categoryRepository)
    {
        $id = rand(1, 10);
        $categorie = $categoryRepository->find($id);
        if ($categorie) {
            return $this->render('front/home.html.twig', ['categorie' => $categorie]);
        } else {
            return $this->redirectToRoute('front_home');
        }
    }
}
