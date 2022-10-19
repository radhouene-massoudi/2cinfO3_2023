<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Entity\Student;
use App\Form\St2Type;
use App\Form\StType;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/addstttt/{id}', name: 'addSttt')]
    public function addSt(ManagerRegistry $mg,Request $req,StudentRepository $repo,Classroom $c): Response
    {
        $st=new Student();
        
        $form=$this->createForm(St2Type::class,$st);
$form->handleRequest($req);
       
       if($form->isSubmitted()){
        $cin=$st->getCin();
      $result=$repo->find($cin);
      if($result==null){
        $st->setCreatedAt(new DateTimeImmutable());
        $st->setGrade($c);
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

    #[Route('/fetchclassroom/{id}', name: 'fetchclassroom')]
    public function fetchclassroom(ClassroomRepository $repo,$id,StudentRepository $st): Response
    {
        $t=$st->queryBuil();
        $resul=$st->searchbyclasse($id);
        dd($resul);
        return $this->render('student/class.html.twig', [
            'grades' => $repo->findAll(),
        ]);
    } 

    #[Route('/dql', name: 'dql')]
    public function dql(EntityManagerInterface $em)
    {
        $cin='1234';
        $name='rama';
     // $q=$em->createQuery('SELECT s FROM App\Entity\Student s')->getResult();
    // $q=$em->createQuery('SELECT count(s) FROM App\Entity\Student s')->getResult();
   // $q=$em->createQuery('SELECT count(s) FROM App\Entity\Student s')->getSingleScalarResult();
   //$q = $em->createQuery('SELECT u FROM App\Entity\Student u JOIN u.grade g')->getResult();
        
   $q=$em->createQuery("SELECT s FROM App\Entity\Student s WHERE  s.name=:name");
            $q->setParameter('name','rama');
            
      $t= $q->getResult();dd($t);
        return true;
    } 
}

