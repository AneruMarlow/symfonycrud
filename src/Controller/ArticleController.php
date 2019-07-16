<?php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;


class ArticleController extends AbstractController
{
    /**
     * @Route("/create", name="index_list")
     */
    public function createAction()
    {
        $article = new Article();
        $article->setName('Write a blog post');
        $article->setDescription('Write description');
        $article->setCreatedAt(new \DateTime('tomorrow'));

        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="index_list")
     */
    public function readAction($id, $name, $description, $createdAt)
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $article = $article->findAll();
        return $this->render('article/list.html.twig', ['article' => $article]);
    }

    /**
     * @Route("/update/{id}", name="index_list")
     */

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository(Article::class)->find($id);

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('index_list');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}