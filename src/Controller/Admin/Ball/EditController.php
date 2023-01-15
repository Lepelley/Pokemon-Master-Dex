<?php

namespace App\Controller\Admin\Ball;

use App\Entity\Ball;
use App\Form\BallType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ball/{id}/edit', name: 'app_admin_ball_edit')]
class EditController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request, Ball $ball): Response
    {
        $form = $this->createForm(BallType::class, $ball);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Ball $ball */
            $ball = $form->getData();
            $time = new \DateTimeImmutable();
            $ball
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($ball);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_ball_list');
        }

        return $this->render('admin/ball/edit.html.twig', [
            'form' => $form->createView(),
            'ball' => $ball,
        ]);
    }
}
