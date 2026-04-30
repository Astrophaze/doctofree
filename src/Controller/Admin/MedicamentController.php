<?php

namespace App\Controller\Admin;

use App\Entity\Medicament;
use App\Repository\MedicamentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/medicament')]
final class MedicamentController extends AbstractController
{
    #[Route(name: 'app_admin_medicament_index', methods: ['GET'])]
    public function index(MedicamentRepository $medicamentRepository): Response
    {
        return $this->render('admin/medicament/index.html.twig', [
            'medicaments' => $medicamentRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_medicament_show', methods: ['GET'])]
    public function show(Medicament $medicament): Response
    {
        return $this->render('admin/medicament/show.html.twig', [
            'medicament' => $medicament,
        ]);
    }
}
