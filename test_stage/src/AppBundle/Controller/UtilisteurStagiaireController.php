<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UtilisateurStagiaire;
use AppBundle\Form\UtilisateurStagiaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class UtilisteurStagiaireController extends Controller
{
    /**
     * @Route("/afficherstagiaire", name ="afficherstagiaire")
     */
    public function afficherstagiaireAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $stagiaire = $em->getRepository('AppBundle:UtilisateurStagiaire')->findAll();

        if ($stagiaire == null) {
            return $this->redirectToRoute('ajouterstagiaire');
        } else {
            return $this->render('@App/UtilisteurStagiaire/afficherstagiaire.html.twig', array(
                'stagiaire' => $stagiaire
            ));
        }
    }

    /**
     * @Route("/ajouterstagiaire", name ="ajouterstagiaire")
     */
    public function ajouterstagiaireAAction(Request $request)
    {
        $stagiaire = new UtilisateurStagiaire();
        $formBuilder = $this->get('form.factory')->createBuilder(UtilisateurStagiaireType::class, $stagiaire);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //  La méthode persist permet de modifier l'objet stagiaire dans Doctrine
                $em->persist($stagiaire);
                //  enregistrer en base
                $em->flush();
                // apres avoir ajouter rediriger le visiteur sur accueilview
                return $this->redirectToRoute('afficherstagiaire', ['stagiaire' => $stagiaire]);
            }
        } else {
            return $this->render('@App/UtilisteurStagiaire/ajouterstagiaire.html.twig', array(
                'formUtilisateurStagiaire' => $form->createView()
            ));
        }
    }

    /**
     * @Route("/modifierstagiaire/{id}", name ="modifierstagiaire")
     */
    public function modifierstagiaireAction(Request $request, UtilisateurStagiaire $stagiaire)
    {
        $formBuilder = $this->get('form.factory')->createBuilder(UtilisateurStagiaireType::class, $stagiaire);
        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($stagiaire);
                $em->flush();
                return $this->redirectToRoute('afficherstagiaire');
            }
        } else {
            return $this->render('@App/UtilisteurStagiaire/ajouterstagiaire.html.twig', array(
                'formUtilisateurStagiaire' => $form->createView()
            ));
        }
    }

    /**
     * @Route("/supprimerstagiaire/{id}", name ="supprimerstagiaire")
     */
    public function supprimerstagiaireAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $stagiaire = $em->getRepository("AppBundle:UtilisateurStagiaire")->find($id);
        if ($stagiaire != null) {
            $em->remove($stagiaire);

            $em->flush();

            return $this->redirectToRoute('afficherstagiaire');
        } else {
            return $this->render('@App/UtilisteurStagiaire/supprimerstagiaire.html.twig', array(// ...
            ));
        }

    }
}
