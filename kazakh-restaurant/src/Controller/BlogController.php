<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class BlogController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/blog/new', name: 'make_blog')]
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

    #[Route('/article/{id}', name: 'blog_read')]
 

    public function read_blog(Blog $blog){
        return $this->render('blog/read_blog.html.twig',[
            'blog'=>$blog
        ]);
    }

    #[Route('/articles', name: 'blogs')]

    public function blogs(Blog $blog){
        return $this->render('blog/read_blog.html.twig',[
            'blogs'=>$blog
        ]);
    }



    #[Route('/blog/{id}/edit', name: 'blog_edit')]
 

    public function edit_blog(Request $request,Blog $blog){
        
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
        
            return $this->redirectToRoute('blog', ['id' => $blog->getId()]);
            }


            return $this->render('blog/edit.html.twig', [
                'form' => $form->createView(),
                'blog'=> $blog
            ]);




    }

    
    

}
#[Route('/blog/{id}/delete', name: 'blog_delete')]

    public function delete_blog(Blog $blog): Response
    {
        $this->entityManager->remove($blog);
        $this->entityManager->flush();
    
        return $this->redirectToRoute('blogs');
    }

}




