<?php

namespace App\Controller;

use App\Entity\Suivi;
use App\Repository\TypeSuiviRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/~/_/#/")
 */
class AjaxController extends AbstractController
{
    /**
     * @Route("/s", name="ajax_suivi",methods={"POST"})
     */
    public function index(Request $request, TypeSuiviRepository $typeSuiviRepository)
    {
        $suivi = new Suivi();
        $patient = $this->getUser();
        $results = $request->get('results');
        $theme = $typeSuiviRepository->find($request->get('type'));
        $suivi->setTheme($theme);
        $suivi->setPatient($patient);
        $suivi->setResultat($results);
        $em = $this->getDoctrine()->getManager();
        $em->persist($suivi);
        try {
            $em->flush();
        } catch (\Exception $exception) {
            return $this->json([
                'response' => $exception->getMessage()
            ], 200);
        }
        return $this->json([
            'response' => 'ok',
        ], 200);
    }
}
