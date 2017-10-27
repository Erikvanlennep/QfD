<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Category controller.
 *
 * @Route("profile/category")
 * @Security("has_role('ROLE_USER')")
 */
class CategoryController extends Controller
{
    /**
     * Lists all category entities.
     *
     * @Route("/", name="category_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $category = new Category();
        $form = $this->createCreateForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('category_index');
        }


        return $this->render('category/index.html.twig', array(
            'categories' => $categories,
            'form' => $form->createView(),
        ));
    }


    
    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/{id}/edit", name="category_edit")
     * @Method({"GET", "PUT"})
     */
    public function editAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Category')->find($category);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $form = $this->createEditForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('category_index'));
        }

        return $this->render('category/edit.html.twig', array(
            'category' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a category entity.
     *
     * @Route("/{id}", name="category_delete")
     */
    public function deleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Category')->find($category);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        $em->remove($entity);
        $em->flush();
        return $this->redirectToRoute('category_index');
    }


    /**
     * Creates a form te create a new category.
     * @param Category $category
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateForm(Category $category){

        $form = $this->createForm('AppBundle\Form\CategoryType', $category, array(
            'action' => $this->generateUrl('category_index'),
            'attr' => array('class' => 'form-inline text-center'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Creates a form to edit a category.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm('AppBundle\Form\CategoryType', $entity, array(
            'action' => $this->generateUrl('category_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
            'attr' => array('class' => 'form-inline text-center'),
        ));

        return $form;
    }

    /**
     * Creates a form to delete a category.
     *
     * @param Category $category The category entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Category $category)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $category->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
