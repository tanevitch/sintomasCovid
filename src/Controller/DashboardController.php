<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Sintoma;
use App\Repository\SintomaRepository;
use Clasecita;
use Fi\Collections\Collection;


class DashboardController extends AbstractController
{
    private $arreglo_sintomas = array();

    /**
     * @Route("/dashboard", name="dashboard", methods={"GET"})
     */

    public function index(SintomaRepository $sintomas): Response
    {
        foreach ($this->getUser()->getUserSintomas() as $sintoma) {
            array_push($this->arreglo_sintomas, 
                        $sintomas->find($sintoma->getId())
                    );
        }
        return $this->render('dashboard/index.html.twig', [
            'sintomas' => $this->arreglo_sintomas,
            'user' => $this->getUser(),
            'sintomas_user' =>$this->getUser()->getUserSintomas(),
        ]);
    }

}
