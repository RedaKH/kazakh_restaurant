<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BlogController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/blog/new', name: 'make_blog')]
    public function make_blog(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFileName = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si le téléchargement de l'image échoue
                }

                // Insère l'image dans l'entité
                $blog->setImage($newFileName);
            }

            // Mettre à jour la date de création
            $blog->setCreatedAt(new \DateTimeImmutable());

            // Mettre à jour l'auteur
            $blog->setAuthor($this->getUser());

            // Sauvegarde le blog dans la base de données
            $this->entityManager->persist($blog);
            $this->entityManager->flush();

            return $this->redirectToRoute('blogs');
        }

        return $this->render('blog/make_blog.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/{id}', name: 'blog_read')]
    public function read_blog(Blog $blog): Response
    {
        return $this->render('blog/blog.html.twig', [
            'blog' => $blog
        ]);
    }

    #[Route('/articles', name: 'blogs')]
    public function blogs(): Response
    {
        $blogs = $this->entityManager->getRepository(Blog::class)->findAll();

        return $this->render('blog/blogs.html.twig', [
            'blogs' => $blogs,
        ]);
    }

    #[Route('/blog/{id}/edit', name: 'edit_blog')]
    public function edit_blog(Request $request, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $newFileName = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {
                    // Gérer l'exception si le téléchargement de l'image échoue
                }

                // Mettre à jour l'image de l'article
                $blog->setImage($newFileName);
            }

            // Mettre à jour la date de création
            $blog->setCreatedAt(new \DateTimeImmutable());

            // Mettre à jour l'auteur
            $blog->setAuthor($this->getUser());

            // Sauvegarder les modifications dans la base de données
            $this->entityManager->flush();

            // Rediriger vers la page de l'article après la modification
            return $this->redirectToRoute('blog_read', ['id' => $blog->getId()]);
        }

        return $this->render('blog/edit_blog.html.twig', [
            'form' => $form->createView(),
            'blog' => $blog,
        ]);
    }

    #[Route('/blog/{id}/delete', name: 'delete_blog')]
    public function delete_blog(Blog $blog): Response
    {
        $this->entityManager->remove($blog);
        $this->entityManager->flush();

        return $this->redirectToRoute('blogs');
    }
}
