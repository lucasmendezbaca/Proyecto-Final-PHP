<?php

namespace App\Controller;

use App\Entity\Iva;
use App\Form\IvaType;
use App\Repository\IvaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/iva')]
class IvaController extends AbstractController
{
    #[Route('/', name: 'app_iva_index', methods: ['GET'])]
    public function index(IvaRepository $ivaRepository): Response
    {
        return $this->render('iva/index.html.twig', [
            'ivas' => $ivaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_iva_new', methods: ['GET', 'POST'])]
    public function new(Request $request, IvaRepository $ivaRepository): Response
    {
        $iva = new Iva();
        $form = $this->createForm(IvaType::class, $iva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ivaRepository->save($iva, true);

            return $this->redirectToRoute('app_iva_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('iva/new.html.twig', [
            'iva' => $iva,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_iva_show', methods: ['GET'])]
    public function show(Iva $iva): Response
    {
        return $this->render('iva/show.html.twig', [
            'iva' => $iva,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_iva_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Iva $iva, IvaRepository $ivaRepository): Response
    {
        $form = $this->createForm(IvaType::class, $iva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ivaRepository->save($iva, true);

            return $this->redirectToRoute('app_iva_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('iva/edit.html.twig', [
            'iva' => $iva,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_iva_delete', methods: ['POST'])]
    public function delete(Request $request, Iva $iva, IvaRepository $ivaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$iva->getId(), $request->request->get('_token'))) {
            $ivaRepository->remove($iva, true);
        }

        return $this->redirectToRoute('app_iva_index', [], Response::HTTP_SEE_OTHER);
    }
}
