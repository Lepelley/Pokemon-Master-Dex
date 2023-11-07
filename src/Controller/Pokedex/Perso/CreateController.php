<?php

namespace App\Controller\Pokedex\Perso;

use App\Entity\UserPokedex;
use App\Form\UserPokedexPersoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/pokedex/create/perso', name: 'app_pokedex_create_perso')]
#[IsGranted("ROLE_USER")]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $pokedex = new UserPokedex();
        $form = $this->createForm(UserPokedexPersoType::class, $pokedex);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserPokedex $pokedex */
            $pokedex = $form->getData();

            $time = new \DateTimeImmutable();
            $pokedex
                ->setTrainer($this->getUser())
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($pokedex);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_pokedex_view', ['id' => $pokedex->getId()]);
        }

        return $this->render('pokedex/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
