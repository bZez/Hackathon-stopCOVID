<?php

namespace App\Controller;

use App\Entity\Ordo;
use App\Form\OrdoType;
use App\Repository\OrdoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/p/ordonnances")
 */
class OrdoController extends AbstractController
{
    /**
     * @Route("/", name="ordo_index", methods={"GET|POST"})
     */
    public function index(Request $request,OrdoRepository $ordoRepository,SluggerInterface $slugger): Response
    {
        $patient = $this->getUser();

        $ordo = new Ordo();
        $formOrdo = $this->createForm(OrdoType::class, $ordo);
        $formOrdo->handleRequest($request);
        if ($formOrdo->isSubmitted() && $formOrdo->isValid()) {
            $ordo->setPatient($patient);
            /** @var UploadedFile $ordoFile */
            $ordoFile = $formOrdo->get('file')->getData();
            if ($ordoFile) {
                $originalFilename = pathinfo($ordoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $ordoFile->guessExtension();

                try {
                    $ordoFile->move(
                        $this->getParameter('ordos_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $ordo->setFile($newFilename);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ordo);
                $entityManager->flush();
                return $this->redirectToRoute('ordo_index');
            }
        }

        return $this->render('ordo/index.html.twig', [
            'ordos' => $ordoRepository->findBy(['patient'=>$this->getUser()],['at' => 'DESC']),
            'formOrdo' => $formOrdo->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="ordo_show", methods={"GET"})
     */
    public function show(Ordo $ordo): Response
    {
        return $this->render('ordo/show.html.twig', [
            'ordo' => $ordo,
        ]);
    }

    /**
     * @Route("/{id}", name="ordo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ordo $ordo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ordo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ordo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ordo_index');
    }
}
