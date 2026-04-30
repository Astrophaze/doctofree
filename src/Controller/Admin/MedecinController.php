<?php

namespace App\Controller\Admin;

use App\Entity\Medecin;
use App\Repository\MedecinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/medecin')]
final class MedecinController extends AbstractController
{
    #[Route(name: 'app_admin_medecin_index', methods: ['GET'])]
    public function index(MedecinRepository $medecinRepository): Response
    {
        return $this->render('admin/medecin/index.html.twig', [
            'medecins' => $medecinRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_medecin_show', methods: ['GET'])]
    public function show(Medecin $medecin): Response
    {
        return $this->render('admin/medecin/show.html.twig', [
            'medecin' => $medecin,
        ]);
    }
}
