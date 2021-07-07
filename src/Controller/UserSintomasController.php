<?php

namespace App\Controller;

use App\Entity\UserSintomas;
use App\Form\UserSintomasType;
use App\Repository\UserSintomasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/sintomas")
 */
class UserSintomasController extends AbstractController
{
    /**
     * @Route("/", name="user_sintomas_index", methods={"GET"})
     */
    public function index(UserSintomasRepository $userSintomasRepository): Response
    {
        return $this->render('user_sintomas/index.html.twig', [
            'user_sintomas' => $userSintomasRepository->findAll(),
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
     * @Route("/{id}", name="user_sintomas_show", methods={"GET"})
     */
    public function show(UserSintomas $userSintoma): Response
    {
        return $this->render('user_sintomas/show.html.twig', [
            'user_sintoma' => $userSintoma,
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

            return $this->redirectToRoute('user_sintomas_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('user_sintomas_index', [], Response::HTTP_SEE_OTHER);
    }
}
