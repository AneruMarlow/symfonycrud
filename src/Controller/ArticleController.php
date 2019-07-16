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
     * @Route("/create", name="create_article")
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
     * @Route("/", name="list_article")
     */
    public function readAction($id, $name, $description, $createdAt)
    {
        $article = $this->getDoctrine()->getRepository(Article::class);
        $articles = $article->findAll();

        return $this->render('article/list.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/update/{id}", name="update_article")
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

            return $this->redirectToRoute('list_article');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}