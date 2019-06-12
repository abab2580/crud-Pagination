<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleController extends Controller
{
    /**
     * @Route("/afficher", name="afficher")
     */
    public function afficherAction()
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->findAll();
        if ($article == null) {
            return $this->redirectToRoute('ajouter');
        } else {
            return $this->render('@App/Article/afficher.html.twig', array(
                'article' => $article
            ));
        }

    }

    /**
     * @Route("/ajouter" , name="ajouter")
     */
    public function ajouterAction(Request $request)
    {
        $article = new Article();
        $formBuilder = $this->get('form.factory')->createBuilder(ArticleType::class, $article);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //  La méthode persist permet de modifier l'objet utilisateur dans Doctrine
                $em->persist($article);
                //  enregistrer en base
                $em->flush();
                // apres avoir ajouter rediriger le visiteur sur accueilview
                return $this->redirectToRoute('afficher', ['article' => $article]);
            }
        } else {
            return $this->render('@App/Article/ajouter.html.twig', array(
                'formArticle' => $form->createView()
            ));
        }


        return $this->render('@App/Article/ajouter.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/modifier/{id}" , name="modifier")
     */
    public function modifierAction(Request $request, Article $article)
    {
        $formBuilder = $this->get('form.factory')->createBuilder(ArticleType::class, $article);
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                return $this->redirectToRoute('afficher');
            }
        } else {
            return $this->render('@App/Article/ajouter.html.twig', [
                'formArticle' => $form->createView()
            ]);
        }

    }


    /**
     * @Route("/supprimer/{id}" , name="supprimer")
     */
    public function supprimerAction($id)


    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository("AppBundle:Article")->find($id);
        if ($article != null) {
            $em->remove($article);
            // enregistrement en BDD
            $em->flush();
            // apres suppression rediriger le visiteur sur accueilview
            return $this->redirectToRoute('afficher');
        } else {
            return $this->render('@App/Article/supprimer.html.twig', array(// ...
            ));
        }

    }
}
