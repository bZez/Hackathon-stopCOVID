<?php

namespace App\Controller;

use App\Entity\Pro;
use App\Form\ProType;
use App\Repository\ProRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pro")
 */
class ProController extends AbstractController
{
    /**
 * @Route("/", name="pro_index", methods={"GET"})
 */
    public function index(ProRepository $proRepository): Response
    {
        return $this->render('pro/index.html.twig', [
            'pros' => $proRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pro_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pro = new Pro();
        $form = $this->createForm(ProType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pro);
            $entityManager->flush();

            return $this->redirectToRoute('pro_index');
        }

        return $this->render('pro/new.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/{uuid}", name="pro_show", methods={"GET"})
     */
    public function show(Pro $pro): Response
    {
        return $this->render('pro/show.html.twig', [
            'pro' => $pro,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pro_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pro $pro): Response
    {
        $form = $this->createForm(ProType::class, $pro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pro_index');
        }

        return $this->render('pro/edit.html.twig', [
            'pro' => $pro,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pro_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pro $pro): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pro->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pro);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pro_index');
    }
}
