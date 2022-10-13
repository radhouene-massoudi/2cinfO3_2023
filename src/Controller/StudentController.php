<?php

namespace App\Controller;

use App\Entity\Student;
use App\Form\StType;
use App\Repository\StudentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fetch(StudentRepository $repo): Response
    {
        $result=$repo->findAll();
        dd($result);
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/liste', name: 'listehhhhh')]
    public function getStudnets(StudentRepository $repo): Response
    {
        $result=$repo->findAll();
        return $this->render('student/list.html.twig', [
            'students' => $result,
        ]);
    }

    #[Route('/add', name: 'add')]
    public function addStudnets(ManagerRegistry $mg,Request $req): Response
    {
        $st=new Student();
        $st->setName('2Cinfo3');
        $form=$this->createForm(StType::class,$st);
$form->handleRequest($req);
       
       if($form->isSubmitted()){
      
$em=$mg->getManager();
$em->persist($st);
$em->flush();
return $this->redirectToRoute('listehhhhh');
}
        return $this->render('student/add.html.twig', [
            'f' => $form->createView(),
        ]);
    }
}
