<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Sintoma;
use App\Repository\SintomaRepository;

use Clasecita;

class DashboardController extends AbstractController
{
    private $arreglo_sintomas = array();

    /**
     * @Route("/dashboard", name="dashboard", methods={"GET"})
     */

    public function index(SintomaRepository $sintomas): Response
    {
        if ($this->getUser()){
            foreach ($this->getUser()->getUserSintomas() as $sintoma) {
                $clase = new Clasecita(
                    $this->getUser()->getNombre(),
                    $sintoma->getFecha(),
                    $sintomas->find($sintoma->getSintoma())->getDescripcion(),
                    $sintoma->getId()
                );
    
                if ($sintoma->getDescripcion() != null){
                    $clase->setDescripcion($sintoma->getDescripcion());
                }
                array_push($this->arreglo_sintomas, $clase);
            }
    
            return $this->render('dashboard/index.html.twig', [
                'sintomas' => $this->arreglo_sintomas,
                'nombre' => $this->getUser()->getNombre()
            ]);
        }
        else{
            return $this->redirectToRoute('app_login');
        }
        
    }

}
