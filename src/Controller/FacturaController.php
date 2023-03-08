<?php

namespace App\Controller;

use App\Entity\Factura;
use App\Entity\LineaFactura;
use App\Form\FacturaType;
use App\Repository\FacturaRepository;
use App\Repository\EstadoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/factura')]
class FacturaController extends AbstractController
{
    #[Route('/', name: 'app_factura_index', methods: ['GET'])]
    public function index(FacturaRepository $facturaRepository, EstadoRepository $estadoRepository): Response
    {
        return $this->render('factura/index.html.twig', [
            'estados' => $estadoRepository->findAll(),
            'totales' => $facturaRepository->getTotalFacturas(),
            'facturas' => $facturaRepository->findAll(),
        ]);
    }

    #[Route('/estado', name: 'app_factura_estado', methods: ['GET'])]
    public function estado(FacturaRepository $facturaRepository, EstadoRepository $estadoRepository, Request $request): Response
    {
        $estado = $request->query->get('estado');

        return $this->render('factura/index.html.twig', [
            'estados' => $estadoRepository->findAll(),
            'totales' => $facturaRepository->getTotalFacturas(),
            'facturas' => $facturaRepository->getFacturasByEstado($estado),
        ]);
    }

    #[Route('/new', name: 'app_factura_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FacturaRepository $facturaRepository): Response
    {
        $factura = new Factura();
        $form = $this->createForm(FacturaType::class, $factura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineaFacutra = new LineaFactura();
            $facturaRepository->save($factura, $lineaFacutra, true);

            return $this->redirectToRoute('app_factura_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('factura/new.html.twig', [
            'factura' => $factura,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_factura_show', methods: ['GET'])]
    public function show(Factura $factura, FacturaRepository $facturaRepository): Response
    {
        return $this->render('factura/show.html.twig', [
            'total' => $facturaRepository->getTotalFactura($factura),
            'lineas' => $factura->getLineaFacturas(),
            'factura' => $factura,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_factura_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Factura $factura, FacturaRepository $facturaRepository): Response
    {
        $form = $this->createForm(FacturaType::class, $factura);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lineaFacutra = new LineaFactura();
            $facturaRepository->save($factura, $lineaFacutra, true);

            return $this->redirectToRoute('app_factura_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('factura/edit.html.twig', [
            'factura' => $factura,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_factura_delete', methods: ['POST'])]
    public function delete(Request $request, Factura $factura, FacturaRepository $facturaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$factura->getId(), $request->request->get('_token'))) {
            $facturaRepository->remove($factura, true);
        }

        return $this->redirectToRoute('app_factura_index', [], Response::HTTP_SEE_OTHER);
    }
}
