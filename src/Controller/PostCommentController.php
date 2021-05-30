<?php

namespace App\Controller;

use App\Entity\PostComments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class PostCommentController extends AbstractController
{
    /**
     * @Route("/post/comment/{id}", name="delete_comment", methods={"POST"})
     */
    public function delete(Request $request, PostComments $postComments): Response
    {

        if($this->getUser() !== $postComments->getAuthor() && !in_array("ROLE_ADMIN",$this->getUser()->getRoles()))
            $this->addFlash('error', 'Nemůžeš smazat tento komentář !');
            return $this->redirectToRoute('post_show', [
                'id' => $postComments->getPost()->getId(),
            ]);

        if ($this->isCsrfTokenValid('delete'.$postComments->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postComments);
            $entityManager->flush();
            $this->addFlash('success', "Komentář byl úspěšně smazán.");
        }

        return $this->redirectToRoute('post_show', [
            'id' => $postComments->getPost()->getId(),
        ]);
    }
}
