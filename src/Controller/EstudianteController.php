<?php

namespace App\Controller;

use App\Entity\Estudiante;
use App\Form\EstudianteType;
use App\Repository\EstudianteRepository;
use App\Repository\NotaRepository;
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
     * @Route("/listado_estudiantes", name="listado_estudiantes", methods={"GET"})
     */
    public function listado_estudiantes(EstudianteRepository $estudianteRepository,  NotaRepository $nr): Response
    {
        
        return $this->render('estudiante/listado_estudiantes.html.twig', [
            'estudiantes' => $estudianteRepository->findAll(),
            'notas' => $nr->findAll()
        ]);
    }

     /**
     * @Route("/mostrar_estudiante/{id}", name="mostrar_estudiante", requirements={"id"="\d+"}, methods={"GET"})
     */
    public function mostrar_estudiante($id, EstudianteRepository $er, NotaRepository $notaRepository): Response
    {   
        $estudiante = $er->find($id);
        $notas = $notaRepository->findBy(
            ['estudiante' => $estudiante], 
        );
        
           //comprobar si existe el inmueble
           if(!$estudiante){
            throw $this->createNotFoundException('Este Estudiante no existe'); 
        }

        return $this->render('estudiante/mostrar_estudiante.html.twig', [
            'estudiante' => $estudiante,
            'notas' => $notas
        ]);
    }

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
