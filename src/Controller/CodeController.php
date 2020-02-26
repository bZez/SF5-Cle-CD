<?php

namespace App\Controller;

use App\Entity\Cle;
use App\Entity\Client;
use App\Entity\Code;
use App\Form\CodeType;
use App\Repository\ClientRepository;
use App\Repository\CodeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class CodeController extends AbstractController
{
    /**
     * @Route("/", name="code_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('index.html.twig', [
        ]);
    }

    /**
     * @Route("/check", name="form", methods={"POST"})
     */
    public function form(Request $request, CodeRepository $codeRepository,SessionInterface $session): Response
    {
        if ($datas = $request->request->get('checker')) {
            if ($code = $codeRepository->findOneBy(['codeSecure' => $datas['codeSecu']])) {
                $session->set('cdkey',$code->getCle()->getCle());
                return $this->render('form.html.twig');
            } else {
                $this->addFlash('notice','Vous avez entrez des informations incorrectes...');
                return $this->render('index.html.twig');
            }
        }
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/validate", name="register", methods={"POST"})
     */
    public function register(Request $request, ClientRepository $clientRepository,EntityManagerInterface $em,SessionInterface $session): Response
    {
        if ($datas = $request->request->get('infos')) {
            $client = new Client();
            $client->setLastname($datas['lname']);
            $client->setFirstname($datas['fname']);
            $client->setEmail($datas['email']);
            $client->setAddress($datas['address']);
            $client->setZipcode($datas['zipcode']);
            $client->setCity($datas['city']);
            $em->persist($client);
            $em->flush();
            $this->addFlash('notice','Votre clé CD est: '.$session->get('cdkey'));
            return $this->redirectToRoute('code_index');
        }
        return $this->render('index.html.twig');
    }

}
