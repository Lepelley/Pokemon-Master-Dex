<?php

namespace App\Controller\Admin\Pokedex;

use App\Entity\Pokedex;
use App\Form\PokedexType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokedex/{id}/edit', name: 'app_admin_pokedex_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request, Pokedex $pokedex): Response
    {
        $form = $this->createForm(PokedexType::class, $pokedex);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Pokedex $pokedex */
            $pokedex = $form->getData();
            $pokedex->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($pokedex);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokedex_list');
        }

        return $this->render('admin/pokedex/edit.html.twig', [
            'form' => $form->createView(),
            'pokedex' => $pokedex,
        ]);
    }
}
