<?php

namespace App\Controller\Admin\Pokemon;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokemon/{id}/edit', name: 'app_admin_pokemon_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request, Pokemon $pokemon): Response
    {
        $form = $this->createForm(PokemonType::class, $pokemon)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Pokemon $pokemon */
            $pokemon = $form->getData();
            $pokemon->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokemon_list');
        }

        return $this->render('admin/pokemon/edit.html.twig', [
            'form' => $form->createView(),
            'pokemon' => $pokemon,
        ]);
    }
}
