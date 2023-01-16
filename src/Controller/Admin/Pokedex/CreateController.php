<?php

namespace App\Controller\Admin\Pokedex;

use App\Entity\Pokedex;
use App\Form\PokedexType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/create', name: 'app_admin_pokedex_create')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request): Response
    {
        $pokedex = new Pokedex();
        $form = $this->createForm(PokedexType::class, $pokedex)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Pokedex $pokedex */
            $pokedex = $form->getData();
            $time = new \DateTimeImmutable();
            $pokedex
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($pokedex);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokedex_list');
        }

        return $this->render('admin/pokedex/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
