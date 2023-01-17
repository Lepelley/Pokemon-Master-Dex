<?php

namespace App\Controller\User;

use App\Entity\Ball;
use App\Entity\User;
use App\Form\BallType;
use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile/edit', name: 'app_user_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {}

    public function __invoke(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            if (null !== $user->getPlainPassword()) {
                $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPlainPassword()));
            }

            $user
                ->setUpdatedAt(new \DateTimeImmutable())
            ;
            
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash("success", "Votre profil a bien été modifié !");

            return $this->redirectToRoute('app_home');
        }

        return $this->render('user/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
