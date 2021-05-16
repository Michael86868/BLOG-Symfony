<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class ApprovalController extends AbstractController
{
    /**
     * @Route("/approval", name="approval", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('approval/index.html.twig', [
            'posts' => $this->getDoctrine()->getRepository(Post::class)->findNonApproved(20),
        ]);
    }

    /**
     * @Route("/approve_view/{post}", name="approval_view_post")
     */
    public function approve_view(Post $post)
    {
        return $this->render('approval/approval.html.twig', [
            'post' => $post
        ]);
    }


    /**
     * @Route("/approve/{post}", name="approval_post")
     * @param Post $post
     * @return Response
     */
    public function approve(Post $post): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $Approval = $post->getApproval();

        try {
            $Approval->approve($this->getUser());
            $em->flush();
        } catch (\Exception $exception) {

        }

        $this->addFlash('success', 'Článek byl schválen');

        return $this->redirectToRoute('approval');
    }
}
