<?php

namespace FosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FosBundle\Entity\Threads;
use FosBundle\Form\ThreadsType;

/**
 * Threads controller.
 *
 * @Route("/threads")
 */
class ThreadsController extends Controller
{

    /**
     * Lists all Threads entities.
     *
     * @Route("/", name="threads")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FosBundle:Threads')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Threads entity.
     *
     * @Route("/", name="threads_create")
     * @Method("POST")
     * @Template("FosBundle:Threads:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Threads();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('threads_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Threads entity.
     *
     * @param Threads $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Threads $entity)
    {
        $form = $this->createForm(new ThreadsType(), $entity, array(
            'action' => $this->generateUrl('threads_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Threads entity.
     *
     * @Route("/new", name="threads_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Threads();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Threads entity.
     *
     * @Route("/{id}", name="threads_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FosBundle:Threads')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Threads entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Threads entity.
     *
     * @Route("/{id}/edit", name="threads_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FosBundle:Threads')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Threads entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Threads entity.
    *
    * @param Threads $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Threads $entity)
    {
        $form = $this->createForm(new ThreadsType(), $entity, array(
            'action' => $this->generateUrl('threads_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Threads entity.
     *
     * @Route("/{id}", name="threads_update")
     * @Method("PUT")
     * @Template("FosBundle:Threads:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FosBundle:Threads')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Threads entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('threads_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Threads entity.
     *
     * @Route("/{id}", name="threads_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FosBundle:Threads')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Threads entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('threads'));
    }

    /**
     * Creates a form to delete a Threads entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('threads_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
