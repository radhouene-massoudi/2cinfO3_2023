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
    #[Route('/detailstudent/{id}', name: 'detailstudent')]
    public function detail(StudentRepository $repo,$id): Response
    {
        $result=$repo->find($id);
        //dd($result);
        return $this->render('student/detail.html.twig', [
            'student' => $result,
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
    public function addStudnets(ManagerRegistry $mg,Request $req,StudentRepository $repo): Response
    {
        $st=new Student();
        //$st->setName('2Cinfo3');
        $form=$this->createForm(StType::class,$st);
$form->handleRequest($req);
       
       if($form->isSubmitted()){
        $cin=$st->getCin();
      $result=$repo->find($cin);
      if($result==null){
        $em=$mg->getManager();
        $em->persist($st);
        $em->flush();
        return $this->redirectToRoute('listehhhhh');
      }else{
        return new Response('cin deja existe ');
      }

}
        return $this->render('student/add.html.twig', [
            'f' => $form->createView(),
        ]);
    }

    #[Route('/update/{id}', name: 'update')]
    public function updateStudnets(ManagerRegistry $mg,Request $req,StudentRepository $repo,$id): Response
    {
        $st=$repo->find($id);
        //dd($st);
        
        $form=$this->createForm(StType::class,$st);
$form->handleRequest($req);

       if($form->isSubmitted()){
     
$em=$mg->getManager();
//$em->persist($st);
$em->flush();
return $this->redirectToRoute('listehhhhh');
}
        return $this->render('student/add.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/updat2/{id}', name: 'up')]
    public function updatSStudnets($id, StudentRepository $repo,Request $req)
    {
$st=$repo->find($id);
$form=$this->createForm(StType::class,$st);
$form->handleRequest($req);
       
       if($form->isSubmitted()){
       $repo->save($st,true);
       return $this->redirectToRoute('listehhhhh');
       }
       return $this->render('student/add.html.twig', [
        'f' => $form->createView(),
    ]);
    }

    #[Route('/remove/{id}', name: 'remove')]
    public function removee($id,ManagerRegistry $mg,StudentRepository $repo): Response
    {
        $st=$repo->find($id);
        if($st!=null){
            $em=$mg->getManager();
            $em->remove($st);
            $em->flush();
               //dd($result);
               return $this->redirectToRoute('listehhhhh');
        }else{
            return new Response('cin nexiste pas' );
        }
        
    }
}
