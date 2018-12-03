<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'articles' => $this->getDoctrine()->getRepository('AppBundle:Article')->findAll(),
        ]);
    }

    /**
     * @Route("/articles/add", name="add_article")
     */
    public function addArticleAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('AppBundle\Form\ArticleType', $article);

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
    public function editArticleAction(int $idArticle)
    {
        /** @var Article $article */
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($idArticle);

        if (null === $article) {
            throw new NotFoundHttpException("Désolé, l'article n'a pas été trouvé.");
        }

        $article->setNom("Nouveau nom pour mon article");

        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('show_article', [
            'idArticle' => $article->getId()
        ]);
    }

    /**
     * @Route("/articles/{idArticle}", name="show_article")
     */
    public function showArticleAction(int $idArticle)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($idArticle);

        if (null === $article) {
            throw new NotFoundHttpException("Désolé, l'article n'a pas été trouvé.");
        }

        // replace this example code with whatever you need
        return $this->render('default/show_article.html.twig', [
            'article' => $article,
        ]);
    }


}
