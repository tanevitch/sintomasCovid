<?php

namespace App\Controller;
require '../vendor/autoload.php';

use App\Entity\UserSintomas;
use App\Form\UserSintomasType;
use App\Repository\UserSintomasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Repository\SintomaRepository;

use Clasecita;

/**
 * @Route("/user/sintomas")
 */
class UserSintomasController extends AbstractController
{
    private $arreglo_sintomas = array();

    /**
     * @Route("/generate_pdf", name="generate_pdf")
     */
    public function generatePDF(SintomaRepository $sintomas)
    {   
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
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

        $dompdf = new Dompdf();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('user_sintomas/generate_pdf.html.twig', [
            'sintomas' => $this->arreglo_sintomas,
            'nombre' => $this->getUser()->getNombre(),
            'fecha' => date('d/m/y')
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();
        ob_end_clean();
        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        
    }

    /**
     * @Route("/new", name="user_sintomas_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {

        $userSintoma = new UserSintomas($this->getUser());
        $form = $this->createForm(UserSintomasType::class, $userSintoma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($userSintoma);
            $entityManager->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->renderForm('user_sintomas/new.html.twig', [
            'user_sintoma' => $userSintoma,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_sintomas_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserSintomas $userSintoma): Response
    {
        $form = $this->createForm(UserSintomasType::class, $userSintoma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_sintomas/edit.html.twig', [
            'user_sintoma' => $userSintoma,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="user_sintomas_delete", methods={"POST"})
     */
    public function delete(Request $request, UserSintomas $userSintoma): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userSintoma->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($userSintoma);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dashboard', [], Response::HTTP_SEE_OTHER);
    }
}
