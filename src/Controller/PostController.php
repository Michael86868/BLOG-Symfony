<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\PostComments;
use App\Entity\PostTags;
use App\Form\PostCommentType;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Service\FileUploader;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository(PostTags::class)->findAll(),
            'posts' => $postRepository->findApproved(20),
        ]);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        if(!$this->getUser()){
            $this->addFlash('error', 'Když nejsi přihlášen, nemůžeš přidávat příspěvky !');
            return $this->redirectToRoute('post_index');
        }

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $post->setImage($imageFileName);
            }
            $entityManager = $this->getDoctrine()->getManager();
            foreach($form->get('tags')->getData() as $item){
                $post->getTags()->add($entityManager->getRepository(PostTags::class)->find($item));
            }
            $post->setAuthor($this->getUser());
            $entityManager->persist($post);
            $entityManager->flush();

            $this->addFlash('success', 'Článek byl úspěšně vytvořen.');

            return $this->redirectToRoute('post_index');
        }
        return $this->render('post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET","POST"})
     */
    public function show(Request $request, Post $post): Response
    {
        $postComment = new PostComments();
        $form = $this->createForm(PostCommentType::class, $postComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if(!$this->getUser()){
                $this->addFlash('error', 'Komentář nemohl být přidán, protože nejsi přihlášen !');
                return $this->redirectToRoute('post_show', ['id' => $post->getId(),]);
            }
                $entityManager = $this->getDoctrine()->getManager();
                $postComment->setAuthor($this->getUser());
                $postComment->setPost($post);

                $entityManager->persist($postComment);
                $entityManager->flush();
                $this->addFlash('success', 'Komentář byl přidán.');
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Post $post, FileUploader $fileUploader): Response
    {
        if(!$this->getUser()){
            $this->addFlash('error', 'Nemůžeš upravovat příspěvek, když nejsi přihlášen !');
            return $this->redirectToRoute('post_index');
        }

        if($post->getAuthor() !== $this->getUser() && !in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
            $this->addFlash('error', 'Nejsi autorem příspěvku !');
            return $this->redirectToRoute('post_index');
        }

        $checkedTags = new ArrayCollection();

        foreach($post->getTags() as $tag) {
            $checkedTags->add($tag->getId());
        }


        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $post->setImage($imageFileName);
            }
            foreach($post->getTags() as $tag) {
                $post->removeTag($this->getDoctrine()->getManager()->getRepository(PostTags::class)->find($tag));
            }
            foreach($form->get('tags')->getData() as $item){
                $post->getTags()->add($this->getDoctrine()->getManager()->getRepository(PostTags::class)->find($item));
            }
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Příspěvek byl uložen.');

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'checkedTags' => $checkedTags,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if(!$this->getUser()){
            $this->addFlash('error', 'Nemůžeš odebrat tento článek, protože nejsi přihlášen !');
            return $this->redirectToRoute('post_index');
        }
        if(!in_array("ROLE_ADMIN", $this->getUser()->getRoles())){
            $this->addFlash('error', 'Nemůžeš odebrat tento článek !');
            return $this->redirectToRoute('post_index');
        }

        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
            $this->addFlash('success', 'Příspěvek byl smazán.');
        }

        return $this->redirectToRoute('post_index');
    }
}
