<?php

namespace App\Controller;

use App\Entity\Estudiante;
use App\Form\EstudianteType;
use App\Repository\EstudianteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/estudiante")
 */
class EstudianteController extends AbstractController
{
    /**
     * @Route("/", name="estudiante_index", methods={"GET"})
     */
    public function index(EstudianteRepository $estudianteRepository): Response
    {
        return $this->render('estudiante/index.html.twig', [
            'estudiantes' => $estudianteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estudiante_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $estudiante = new Estudiante();
        $form = $this->createForm(EstudianteType::class, $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estudiante);
            $entityManager->flush();

            return $this->redirectToRoute('estudiante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('estudiante/new.html.twig', [
            'estudiante' => $estudiante,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="estudiante_show", methods={"GET"})
     */
    public function show(Estudiante $estudiante): Response
    {
        return $this->render('estudiante/show.html.twig', [
            'estudiante' => $estudiante,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estudiante_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estudiante $estudiante): Response
    {
        $form = $this->createForm(EstudianteType::class, $estudiante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estudiante_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('estudiante/edit.html.twig', [
            'estudiante' => $estudiante,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="estudiante_delete", methods={"POST"})
     */
    public function delete(Request $request, Estudiante $estudiante): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estudiante->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estudiante);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estudiante_index', [], Response::HTTP_SEE_OTHER);
    }
}
