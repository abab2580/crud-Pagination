<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Article;
use AppBundle\Entity\Client;
use AppBundle\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ClientController extends Controller
{
    /**
     * @Route("/view" ,name="view")
     */
    public function viewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository('AppBundle:Client')->findAll();
        if ($client == null) {
            return $this->redirectToRoute('insert');
        } else {
            return $this->render('@App/Article/view.html.twig', array(
                'client' => $client
            ));
        }

    }

    /**
     * @Route("/insert", name="insert")
     */
    public function insertAction(Request $request)
    {
        $client = new Client();
        $formBuilder = $this->get('form.factory')->createBuilder(ClientType::class, $client);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                //  La méthode persist permet de modifier l'objet utilisateur dans Doctrine
                $em->persist($client);
                //  enregistrer en base
                $em->flush();
                // apres avoir ajouter rediriger le visiteur sur accueilview
                return $this->redirectToRoute('view', ['client' => $client]);
            }
        } else {
            return $this->render('@App/Client/insert.html.twig', array(
                'formClient' => $form->createView()
            ));
        }


    }

    /**
     * @Route("/update", name="update")
     */
    public function updateAction()
    {
        return $this->render('@App/Client/update.html.twig', array(
            // ...
        ));
    }

    /**
     * @Route("/delete", name="delete")
     */
    public function deleteAction()
    {
        return $this->render('@App/Client/delete.html.twig', array(
            // ...
        ));
    }

}
