<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BlogController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/employe/makeblog', name: 'make_blog')]
    public function make_blog(Request $request): Response
    {
        $blog = new Blog();
        $form = $this->createForm(BlogType::class,$blog);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {

                $originalFilename = pathinfo($imageFile->getClientOriginalName(),PATHINFO_FILENAME);
                $newFileName = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('uploads_directory'),
                        $newFileName
                    );
                } catch (FileException $e) {
                    //throw $th;
                }
                //insere l'image a l'entite

                $blog->setImage($newFileName);


                // Sauvegarde le blog dans la base de données
            $this->entityManager->persist($blog);
            $this->entityManager->flush();
        
                return $this->redirectToRoute('make_blog');
            }
        }
        

        return $this->render('blog/make_blog.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
