<?php

namespace App\Controller\Admin;

use App\Entity\Rendezvous;
use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/rendezvous')]
final class RendezvousController extends AbstractController
{
    #[Route(name: 'app_admin_rendezvous_index', methods: ['GET'])]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('admin/rendezvous/index.html.twig', [
            'rendezvouses' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_admin_rendezvous_show', methods: ['GET'])]
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('admin/rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }
}
