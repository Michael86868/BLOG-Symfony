<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/approval/{post}", name="approval_view_post", methods={"GET","POST"})
     */
    public function approval(Request $request, Post $post, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $post->setImage($imageFileName);
            }
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('approval/approval.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/approve/{post}", name="approval_post", methods={"GET"})
     * @param Post $post
     * @return RedirectResponse
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
