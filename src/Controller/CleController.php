<?php

namespace App\Controller;

use App\Entity\Cle;
use App\Entity\Code;
use App\Form\CleType;
use App\Repository\CleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cle")
 */
class CleController extends AbstractController
{
    /**
     * @Route("/", name="cle_index", methods={"GET"})
     */
    public function index(CleRepository $cleRepository): Response
    {
        return $this->render('cle/index.html.twig', [
            'cles' => $cleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cle_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cle = new Cle();

        if ($request->isMethod('POST')) {
            $datas = $request->request->get('cle');
            $cle->setCle($datas['cle']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cle);
            foreach ($datas['codeSecu'] as $codeSecu) {
                $code = new Code();
                $code->setCodeSecure($codeSecu);
                $code->setCle($cle);
                $entityManager->persist($code);
            }
            $entityManager->flush();

            return $this->redirectToRoute('cle_index');
        }

        return $this->render('cle/new.html.twig', [
            'cle' => $cle,

        ]);
    }

    /**
     * @Route("/{id}", name="cle_show", methods={"GET"})
     */
    public function show(Cle $cle): Response
    {
        return $this->render('cle/show.html.twig', [
            'cle' => $cle,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cle_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cle $cle): Response
    {
        $form = $this->createForm(CleType::class, $cle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cle_index');
        }

        return $this->render('cle/edit.html.twig', [
            'cle' => $cle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cle_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cle $cle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cle->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cle_index');
    }
}
