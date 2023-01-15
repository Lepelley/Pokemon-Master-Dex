<?php

namespace App\Controller\Admin\Ball;

use App\Entity\Ball;
use App\Form\BallType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/ball/create', name: 'app_admin_ball_create')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {}

    public function __invoke(Request $request): Response
    {
        $ball = new Ball();
        $form = $this->createForm(BallType::class, $ball);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Ball $ball */
            $ball = $form->getData();
            $time = new \DateTimeImmutable();
            $ball
                ->setCreatedAt($time)
                ->setUpdatedAt($time)
            ;
            $this->entityManager->persist($ball);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_admin_ball_list');
        }

        return $this->render('admin/ball/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
