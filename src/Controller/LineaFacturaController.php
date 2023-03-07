<?php

namespace App\Controller;

use App\Entity\LineaFactura;
use App\Form\LineaFacturaType;
use App\Repository\LineaFacturaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/linea/factura')]
class LineaFacturaController extends AbstractController
{
    #[Route('/', name: 'app_linea_factura_index', methods: ['GET'])]
    public function index(LineaFacturaRepository $lineaFacturaRepository): Response
    {
        return $this->render('linea_factura/index.html.twig', [
            'totales' => $lineaFacturaRepository->getTotalLineasFacturas(),
            'linea_facturas' => $lineaFacturaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_linea_factura_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LineaFacturaRepository $lineaFacturaRepository): Response
    {
        $lineaFactura = new LineaFactura();
        $form = $this->createForm(LineaFacturaType::class, $lineaFactura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineaFacturaRepository->save($lineaFactura, true);

            return $this->redirectToRoute('app_linea_factura_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('linea_factura/new.html.twig', [
            'linea_factura' => $lineaFactura,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_linea_factura_show', methods: ['GET'])]
    public function show(LineaFactura $lineaFactura, LineaFacturaRepository $lineaFacturaRepository): Response
    {
        return $this->render('linea_factura/show.html.twig', [
            'linea_factura' => $lineaFactura,
            'total' => $lineaFacturaRepository->getTotalLineaFactura($lineaFactura),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_linea_factura_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LineaFactura $lineaFactura, LineaFacturaRepository $lineaFacturaRepository): Response
    {
        $form = $this->createForm(LineaFacturaType::class, $lineaFactura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineaFacturaRepository->save($lineaFactura, true);

            return $this->redirectToRoute('app_linea_factura_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('linea_factura/edit.html.twig', [
            'linea_factura' => $lineaFactura,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_linea_factura_delete', methods: ['POST'])]
    public function delete(Request $request, LineaFactura $lineaFactura, LineaFacturaRepository $lineaFacturaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lineaFactura->getId(), $request->request->get('_token'))) {
            $lineaFacturaRepository->remove($lineaFactura, true);
        }

        return $this->redirectToRoute('app_linea_factura_index', [], Response::HTTP_SEE_OTHER);
    }
}
