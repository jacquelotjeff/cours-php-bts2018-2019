<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use AppBundle\Service\ArticleManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(ArticleManager $articleManager)
    {
        $dernierArticle = $articleManager->dernierArticle();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'articles' => $this->getDoctrine()->getRepository(Article::class)->findAll(),
        ]);
    }

    /**
     * @Route("/articles/add", name="add_article")
     */
    public function addArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/add_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/articles/edit/{idArticle}", name="edit_article")
     */
    public function editArticleAction(Request $request, int $idArticle)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($idArticle);

        if (null === $article) {
            throw new NotFoundHttpException("Désolé, l'article n'a pas été trouvé.");
        }

        $form = $this->createForm(ArticleType::class, $article, [
            'is_edit' => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('show_article', [
                'idArticle' => $article->getId()
            ]);
        }

        return $this->render('default/edit_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/articles/{idArticle}", name="show_article")
     */
    public function showArticleAction(int $idArticle)
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->find($idArticle);

        if (null === $article) {
            throw new NotFoundHttpException("Désolé, l'article n'a pas été trouvé.");
        }

        // replace this example code with whatever you need
        return $this->render('default/show_article.html.twig', [
            'article' => $article,
        ]);
    }


}
