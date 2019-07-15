<?php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * Matches / exactly
     *
     * @Route("/", name="index_list")
     */
   /* public function indexAction()
    {
        var_dump(111); exit;
    }
*/
    public function create()
    {
        $article = new Article();
        $article->setName('Write a blog post');
        $article->setDescription('Write description');
        $article->setCreatedAt(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($article)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('createdAt', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Article'])
            ->getForm();

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}