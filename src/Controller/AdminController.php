<?php

namespace App\Controller;

use App\Entity\Code;
use App\Form\CodeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @Route("/code/new", name="code_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $code = new Code();
        $form = $this->createForm(CodeType::class, $code);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($code);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('code/new.html.twig', [
            'code' => $code,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/code/{id}", name="code_show", methods={"GET"})
     */
    public function show(Code $code): Response
    {
        return $this->render('code/show.html.twig', [
            'code' => $code,
        ]);
    }

    /**
     * @Route("/code/{id}/edit", name="code_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Code $code): Response
    {
        $form = $this->createForm(CodeType::class, $code);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('code/edit.html.twig', [
            'code' => $code,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/code/{id}", name="code_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Code $code): Response
    {
        if ($this->isCsrfTokenValid('delete' . $code->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($code);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }
}
