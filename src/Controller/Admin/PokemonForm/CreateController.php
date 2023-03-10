<?php

namespace App\Controller\Admin\PokemonForm;

use App\Entity\PokemonForm;
use App\Form\PokemonFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokemon/form/create', name: 'app_admin_pokemon_form_create')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request): Response
    {
        $pokemon = new PokemonForm();
        $form = $this->createForm(PokemonFormType::class, $pokemon)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var PokemonForm $pokemon */
            $pokemon = $form->getData();
            $time = new \DateTimeImmutable();
            $pokemon
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokemon_form_list');
        }

        return $this->render('admin/pokemon_form/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
