<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\EditPersonType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PersonController extends AbstractController
{
    /**
     * @Route("/person", name="person")
     */
    public function index(): Response
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $repositoryPerson = $manager->getRepository(Person::class);

        return $this->render('person/index.html.twig', [
            'persons' => $repositoryPerson->findAll(),
        ]);
    }
    /**
     * @Route("/edit", name="edit")
     */
    public function edit(Request $request)
    {
        $person = new Person;
        $form = $this->createForm(EditPersonType::class, $person);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $person = $form->getData();
            $doctrine = $this->getDoctrine();
            $manager = $doctrine->getManager();
            $manager->persist($person);
            $manager->flush();
        }
        return $this->render('person/edit.html.twig',[
                'view' => $form->createView(),
        ]);
    }
}
