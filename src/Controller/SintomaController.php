<?php

namespace App\Controller;

use App\Entity\Sintoma;
use App\Form\SintomaType;
use App\Repository\SintomaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sintoma")
 */
class SintomaController extends AbstractController
{
    /**
     * @Route("/", name="sintoma_index", methods={"GET"})
     */
    public function index(SintomaRepository $sintomaRepository): Response
    {
        return $this->render('sintoma/index.html.twig', [
            'sintomas' => $sintomaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sintoma_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sintoma = new Sintoma();
        $form = $this->createForm(SintomaType::class, $sintoma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sintoma);
            $entityManager->flush();

            return $this->redirectToRoute('sintoma_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sintoma/new.html.twig', [
            'sintoma' => $sintoma,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sintoma_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Sintoma $sintoma): Response
    {
        $form = $this->createForm(SintomaType::class, $sintoma);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sintoma_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sintoma/edit.html.twig', [
            'sintoma' => $sintoma,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="sintoma_delete", methods={"POST"})
     */
    public function delete(Request $request, Sintoma $sintoma): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sintoma->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sintoma);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sintoma_index', [], Response::HTTP_SEE_OTHER);
    }
}
