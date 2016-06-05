<?php

namespace FosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FosBundle\Entity\comments;
use FosBundle\Form\commentsType;

/**
 * comments controller.
 *
 * @Route("/comments")
 */
class commentsController extends Controller
{

    /**
     * Lists all comments entities.
     *
     * @Route("/", name="comments")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('FosBundle:comments')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new comments entity.
     *
     * @Route("/", name="comments_create")
     * @Method("POST")
     * @Template("FosBundle:comments:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new comments();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('comments_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a comments entity.
     *
     * @param comments $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(comments $entity)
    {
        $form = $this->createForm(new commentsType(), $entity, array(
            'action' => $this->generateUrl('comments_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new comments entity.
     *
     * @Route("/new", name="comments_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new comments();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a comments entity.
     *
     * @Route("/{id}", name="comments_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FosBundle:comments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find comments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing comments entity.
     *
     * @Route("/{id}/edit", name="comments_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FosBundle:comments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find comments entity.');
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
    * Creates a form to edit a comments entity.
    *
    * @param comments $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(comments $entity)
    {
        $form = $this->createForm(new commentsType(), $entity, array(
            'action' => $this->generateUrl('comments_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing comments entity.
     *
     * @Route("/{id}", name="comments_update")
     * @Method("PUT")
     * @Template("FosBundle:comments:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('FosBundle:comments')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find comments entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('comments_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a comments entity.
     *
     * @Route("/{id}", name="comments_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('FosBundle:comments')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find comments entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('comments'));
    }

    /**
     * Creates a form to delete a comments entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comments_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
