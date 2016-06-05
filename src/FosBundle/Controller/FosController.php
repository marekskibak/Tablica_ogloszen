<?php

namespace FosBundle\Controller;

use FosBundle\Entity\Categories;
use FosBundle\Entity\comments;
use FosBundle\Entity\Threads;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class FosController extends Controller
{

    /**
     *@Route("/show/{id}")
     *@Template("FosBundle:Fos:showAllThreads.html.twig")
     */

    public function showAllAction($id){

        $user = $this->getUser();
        if(!$user) {
            $userstr ="empty";
        } else {
            $userstr = $user->getUsername();
            if($userstr == 'skiba') {
                $userstr = 'admin';
            }
         }
       // to store dataandtime in string in array
        $datatime=[];

        $category =$this->getDoctrine()->getRepository('FosBundle:Categories')->find($id);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
             FROM FosBundle:Threads p WHERE
             p.category = :categorieToLook
            ORDER BY p.category DESC'
            )->setParameter('categorieToLook', $category);
        $therads = $query->getResult();


        foreach ( $therads as $thread) {
            $datatime[] = $thread->getDate()->format('Y-m-d H:i:s');

        }
          

        return [
            'threads' => $therads, 'category'=>$category, 'asUser'=>$userstr, 'datatime'=>$datatime
        ];
    }

    /**
     * @Route("/deleteThread/{id}/{idd}")
     *
     */

    public function deleteThreadAction($id, $idd){
        $user = $this->getUser();
        var_dump($user);
        die();
        $Thread = $this->getDoctrine()->getRepository('FosBundle:Threads')->find($id);
        if(!$Thread){
            $this->createNotFoundException('Thread not found');
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => $Thread]);
        }
        if($Thread->getUser() != $user->getUsername()){
            $string ="you can't modify not yours threads";
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => $string]);
        }
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('FosBundle:Threads');
        $em->remove($Thread);
        $em->flush();
        return $this->redirectToRoute('fos_fos_showall',['id'=>$idd]);
    }

    /**
     * @ROute("/EdditThread/{id}/{idd}")
     */

    public function edditThreadAction(Request $request,$id,$idd){
        $users= $this->getUser();
        $Thread = $this->getDoctrine()->getRepository('FosBundle:Threads')->find($id);
        if(!$Thread){
            $this->createNotFoundException('Thread not found');
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => $Thread]);
        }

        if($Thread->getUser() != $users->getUsername()){
            $string ="you can't modify not yours threads";
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => $string]);
        }

        $url = $this->generateUrl('fos_fos_edditthread',['id'=>$id,'idd'=>$idd]);

        $form = $this->createThreadsForm($Thread,'Edit',$url);

        $form->handleRequest($request);


        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('FosBundle:Threads');
            $em->persist($Thread);
            $em->flush();


            return $this->redirectToRoute('fos_fos_showall',['id'=>$idd]);
        }

        return $this->render('FosBundle:Fos:form.html.twig',['form'=>$form->createView()]);

    }


    /**
     *@Route("/showcoment/{id}")
     *@Template("FosBundle:Fos:showAllComments.html.twig")
     */
     public function shwoAllCommentsAction($id){
         
         
         $thread =$this->getDoctrine()->getRepository('FosBundle:Threads')->find($id);
         $datatime_thread = $thread->getDate()->format('Y-m-d H:i:s');
         $datatime_comments = [];
         $em = $this->getDoctrine()->getManager();
         $query = $em->createQuery(
             'SELECT p
             FROM FosBundle:comments p WHERE
             p.threads = :threadsToLook
            ORDER BY p.threads DESC'
         )->setParameter('threadsToLook', $thread);
         $comments = $query->getResult();

         $lenght = count($comments);
          for($i=0; $i<$lenght; $i++){
              $wariable = $i;
              $datatime_comments[++$wariable] = $comments[$i]->getDate()->format('Y-m-d H:i:s');
          }  

      return [
          'comments' => $comments, 'threads' => $thread, 'numberofcomments'=>$lenght,
           'threaddatatime'=>$datatime_thread, 'commentsdatatime'=> $datatime_comments
      ];
     }


    /**
     * @Route("/{id}/show")
     * @Template("FosBundle:Fos:showAllThreads.html.twig")
     *
     */

    // show by Category Action

    public function shwoCategoryAction(){

        return [
            'threads' => $this->getDoctrine()->getRepository('FosBundle:Threads')->findAll()
        ];

    }
    /**
     *
     *
     * @Route("/showindex")
     *
     */

     public function allshowAction(){

         return $this->render('FosBundle:Fos:allshow.html.twig');

     }


    /**
     *
     * @Route("/showcategories")
     * @Template("FosBundle:Fos:showAllCategories.html.twig")
     *
     */
    public function showAllCategoAction(){

        return [
            'categories' => $this->getDoctrine()->getRepository('FosBundle:Categories')->findAll()
        ];
    }


    /**
     *
     * @Route("/ferst")
     *
     *
     */
    //threads

     public function ferstAction(Request $request){

         $user = $this->getDoctrine()->getRepository('FosBundle:User')->find(1);
         if(!$user){
             $this->createNotFoundException('User not found');
               return $this->render('FosBundle:Fos:Error.html.twig',['error' => $user]);

         }
         $date = new \DateTime();
         $threads = new Threads();
         $threads->setUser($user);
         $url = $this->generateUrl('fos_fos_ferst');
         $form = $this->createThreadsForm($threads,'ADD',$url);
         $form->handleRequest($request);
         $threads->setDate($date);
         if($form->isSubmitted()){
             $em = $this->getDoctrine()->getManager();
             $em->getRepository('FosBundle:Threads');
             $em->persist($threads);
             $em->flush();
             $user->addThread($threads);

             return $this->redirectToRoute('fos_fos_showall');
         }

         return $this->render('FosBundle:Fos:form.html.twig',['form'=>$form->createView()]);
     }

    /**
     *@Route("/showtreads/$id")
     *
     */
    public function showAllThreadsinCategories($id){
        $categori = $this->getDoctrine()->getRepository('FosBundle:Categories')->find($id);
        if(!$categori) {
            throw $this->createNotFoundException('Categories not found');
        }

    }


    /**
     * @Route("/{id}/ferst/")
     */
    public function ferstAddThreadsAction(Request $request,$id){
        $user= $this->getUser();
        if(!$user) {
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => "you are not logged in you
             can't add new thread", 'loginerror'=>'login' ]);
        }
        $user = $this->getDoctrine()->getRepository('FosBundle:User')->find($user->getId());
        if(!$user){
            $this->createNotFoundException('User not found');
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => $user]);
        }

        $categori = $this->getDoctrine()->getRepository('FosBundle:Categories')->find($id);
        if(!$categori){
            throw $this->createNotFoundException('Categories not found');
            //return $this->render('FosBundle:Fos:Error.html.twig',['error' => $categories]);
        }


        $date = new \DateTime();
        $threads = new Threads();
        $threads->setUser($user);
        $threads->setCategory($categori);

        $url = $this->generateUrl('fos_fos_ferstaddthreads', ['id' => $id]);
        $form = $this->createThreadsForm($threads,'ADD',$url);
        $form->handleRequest($request);
        $threads->setDate($date);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('FosBundle:Threads');
            $em->persist($threads);
            $em->flush();
            $user->addThread($threads);

            return $this->redirectToRoute('fos_fos_showall',['id'=> $id]);
        }

        return $this->render('FosBundle:Fos:form.html.twig',['form'=>$form->createView()]);
    }


    /**
     * @param $variable
     * @param $url
     * @return \Symfony\Component\Form\Form
     * @Route("/comments")
     *
     *
     */
    //comments and user and threads

     public function addcommentsAction(Request $request){
         $users= $this->getUser();
         $user = $this->getDoctrine()->getRepository('FosBundle:User')->find($users->getId());
         if(!$user){
             $this->createNotFoundException('User not found');
             return $this->render('FosBundle:Fos:Error.html.twig',['error' => $user]);

         }
         $threads = $this->getDoctrine()->getRepository('FosBundle:Threads')->find(1);
         if(!$threads){
             $this->createNotFoundException('Threads not found');
             return $this->render('FosBundle:Fos:Error.html.twig',['error' => $threads]);

         }
         $date = new \DateTime();
         $comments = new comments();
         $comments->setThreads($threads);
         $comments->setUser($threads);
         $url = $this->generateUrl('fos_fos_addcomments');
         $form = $this->createCommentsForm($comments,'ADD',$url);
         $form->handleRequest($request);
         $comments->setDate($date);
         if($form->isSubmitted()){
             $em = $this->getDoctrine()->getManager();
             $em->getRepository('FosBundle:comments');
             $em->persist($threads);
             $em->flush();
             $user->addThread($threads);

             return $this->redirectToRoute('fos_fos_showall');
         }

         return $this->render('FosBundle:Fos:form.html.twig',['form'=>$form->createView()]);
     }



    /**
     *
     *
     *
     */


    /**
     * @Route("/{id}/comments/")
     */
    public function ferstAddCommentsAction(Request $request,$id){
        $users= $this->getUser();
        $user = $this->getDoctrine()->getRepository('FosBundle:User')->find($users->getId());
        if(!$user){
            $this->createNotFoundException('User not found');
            return $this->render('FosBundle:Fos:Error.html.twig',['error' => $user]);

        }

        $thread = $this->getDoctrine()->getRepository('FosBundle:Threads')->find($id);
        if(!$thread){
            throw $this->createNotFoundException('Categories not found');
            //return $this->render('FosBundle:Fos:Error.html.twig',['error' => $categories]);
        }


        $date = new \DateTime();
        $comment = new comments();
        $comment->setUser($user);
        $comment->setThreads($thread);

        $url = $this->generateUrl('fos_fos_ferstaddcomments', ['id' => $id]);
        $form = $this->createCommentsForm($comment,'ADD',$url);
        $form->handleRequest($request);
        $comment->setDate($date);
        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('FosBundle:comments');
            $em->persist($comment);
            $em->flush();


            return $this->redirectToRoute('fos_fos_shwoallcomments',['id'=> $id]);
        }

        return $this->render('FosBundle:Fos:form.html.twig',['form'=>$form->createView()]);
    }



    /**
     * @param $variable
     * @param $url
     * @return \Symfony\Component\Form\Form
     * @Route("/CategoriesFos")
     * 
     */

    // add new actegories.

    public function createCategoriesAction(Request $request){
        
        $categories = new Categories();
        $url = $this->generateUrl('fos_fos_createcategories');

        $form = $this->createCategoriesForm($categories,'ADD',$url);

        $form->handleRequest($request);


        if($form->isSubmitted()){
            $em = $this->getDoctrine()->getManager();
            $em->getRepository('FosBundle:categories');
            $em->persist($categories);
            $em->flush();


            return $this->redirectToRoute('fos_fos_showallcatego');
        }

        return $this->render('FosBundle:Fos:form.html.twig',['form'=>$form->createView()]);

    }
    
    
    
    
   // create Formss

    public function createFormm($variable,$url)
    {

        $form = $this->createFormBuilder($variable)
            ->setAction($url)
            ->add('name')
            ->add('description')
            ->add('save', 'submit')
            ->getForm();
        return $form;
    }

    public function createThreadsForm(Threads $Threads, $submit, $url) {
         return $this->createFormBuilder($Threads)
         ->setAction($url)
         ->add('name')
         ->add('description')
         ->add($submit, 'submit')
         ->getForm();
}

     public function createCommentsForm(comments $comments, $submit, $url) {
        return $this->createFormBuilder($comments)
            ->setAction($url)
            ->add('name')
            ->add('descriptionn')
            ->add($submit, 'submit')
            ->getForm();
    }

    public function createCategoriesForm(Categories $categories, $submit, $url ){
        return $this->createFormBuilder($categories)
            ->setAction($url)
            ->add('name')
            ->add('number')
            ->add($submit, 'submit')
            ->getForm();
    }

/*
    public function findExpiredNoticesByUser($user) {
        return $this->getEntityManager()->createQuery(
            'SELECT n FROM NoticeBoardBundle:Notice n
             JOIN n.user u
             WHERE
             u.id= :id AND
             n.expirationDate < :dateNow ORDER BY n.expirationDate DESC '
        )->setParameter('dateNow', new \DateTime())->setParameter('id', $user)->getResult();
    }
  */


}