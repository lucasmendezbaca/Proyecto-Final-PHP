<?php

namespace App\Controller;

use App\Entity\Estado;
use App\Form\EstadoType;
use App\Repository\EstadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/estado')]
class EstadoController extends AbstractController
{
    #[Route('/', name: 'app_estado_index', methods: ['GET'])]
    public function index(EstadoRepository $estadoRepository): Response
    {
        return $this->render('estado/index.html.twig', [
            'estados' => $estadoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_estado_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EstadoRepository $estadoRepository): Response
    {
        $estado = new Estado();
        $form = $this->createForm(EstadoType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $estadoRepository->save($estado, true);

            return $this->redirectToRoute('app_estado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('estado/new.html.twig', [
            'estado' => $estado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estado_show', methods: ['GET'])]
    public function show(Estado $estado): Response
    {
        return $this->render('estado/show.html.twig', [
            'estado' => $estado,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estado_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estado $estado, EstadoRepository $estadoRepository): Response
    {
        $form = $this->createForm(EstadoType::class, $estado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $estadoRepository->save($estado, true);

            return $this->redirectToRoute('app_estado_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('estado/edit.html.twig', [
            'estado' => $estado,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estado_delete', methods: ['POST'])]
    public function delete(Request $request, Estado $estado, EstadoRepository $estadoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estado->getId(), $request->request->get('_token'))) {
            $estadoRepository->remove($estado, true);
        }

        return $this->redirectToRoute('app_estado_index', [], Response::HTTP_SEE_OTHER);
    }
}
