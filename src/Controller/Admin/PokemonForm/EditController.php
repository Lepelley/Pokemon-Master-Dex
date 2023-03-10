<?php

namespace App\Controller\Admin\PokemonForm;

use App\Entity\PokemonForm;
use App\Form\PokemonFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokemon/form/{id}/edit', name: 'app_admin_pokemon_form_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request, PokemonForm $pokemon): Response
    {
        $form = $this->createForm(PokemonFormType::class, $pokemon)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PokemonForm $pokemon */
            $pokemon = $form->getData();
            $pokemon->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokemon_form_list');
        }

        return $this->render('admin/pokemon_form/edit.html.twig', [
            'form' => $form->createView(),
            'pokemon' => $pokemon,
        ]);
    }
}
