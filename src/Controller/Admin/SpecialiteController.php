<?php

namespace App\Controller\Admin;

use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/specialite')]
final class SpecialiteController extends AbstractController
{
    #[Route(name: 'app_admin_specialite_index', methods: ['GET'])]
    public function index(SpecialiteRepository $specialiteRepository): Response
    {
        return $this->render('admin/specialite/index.html.twig', [
            'specialites' => $specialiteRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_specialite_show', methods: ['GET'])]
    public function show(Specialite $specialite): Response
    {
        return $this->render('admin/specialite/show.html.twig', [
            'specialite' => $specialite,
        ]);
    }
}
