<?php

namespace App\Controller;

use App\Entity\Ordo;
use App\Form\OrdoType;
use App\Form\PatientType;
use App\Repository\SuiviRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/p")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/profil", name="profile")
     */
    public function index(Request $request, SuiviRepository $suiviRepository, SluggerInterface $slugger)
    {
        $patient = $this->getUser();
        $ordo = new Ordo();
        $formOrdo = $this->createForm(OrdoType::class, $ordo);
        $formOrdo->handleRequest($request);

        if (!$this->getUser()->getFirstname()) {
            $formPatient = $this->createForm(PatientType::class, $patient);
            $formPatient->handleRequest($request);

            if ($formPatient->isSubmitted() && $formPatient->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($patient);
                $entityManager->flush();

                return $this->redirectToRoute('patient_index');
            }
            return $this->render('profile/setter.html.twig', [
                'form' => $formPatient->createView(),
            ]);
        }

        if ($formOrdo->isSubmitted() && $formOrdo->isValid()) {
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

        $suivis = $suiviRepository->findBy(['patient' => $patient], ['at' => 'DESC']);
        return $this->render('profile/index.html.twig', [
            'suivis' => $suivis,
            'formOrdo' => $formOrdo->createView()
        ]);
    }

        /**
         * @Route("/suivi", name="suivi")
         */
        public function suivi(Request $request)
        {
            $patient = $this->getUser();
            if (!$this->getUser()->getFirstname()) {
                $formPatient = $this->createForm(PatientType::class, $patient);
                $formPatient->handleRequest($request);

                if ($formPatient->isSubmitted() && $formPatient->isValid()) {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($patient);
                    $entityManager->flush();

                    return $this->redirectToRoute('patient_index');
                }
                return $this->render('profile/setter.html.twig', [
                    'form' => $formPatient->createView(),
                ]);
            }
            return $this->render('profile/suivi.html.twig');
        }
}