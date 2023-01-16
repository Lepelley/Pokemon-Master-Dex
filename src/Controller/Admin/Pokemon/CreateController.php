<?php

namespace App\Controller\Admin\Pokemon;

use App\Entity\Pokemon;
use App\Form\PokemonType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/pokemon/create', name: 'app_admin_pokemon_create')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request): Response
    {
        $pokemon = new Pokemon();
        $form = $this->createForm(PokemonType::class, $pokemon)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Pokemon $pokemon */
            $pokemon = $form->getData();
            $time = new \DateTimeImmutable();
            $pokemon
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($pokemon);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_pokemon_list');
        }

        return $this->render('admin/pokemon/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
