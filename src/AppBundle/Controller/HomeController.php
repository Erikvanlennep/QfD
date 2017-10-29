<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Question;
use AppBundle\Form\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\QuestionService;
use Symfony\Component\Security\Acl\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Home controller.
 *
 * @Route("/")
 */
class HomeController extends Controller
{
    /**
     * Lists all question entities.
     *
     * @Route("/", name="question_index")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('AppBundle:Question')->findAllAnswered();

        $user = $this->getUser();

        $form = $this->filterForms($request);

        return $this->render('question/index.html.twig', array(
            'questions' => $questions,
            'postform' => $form->createView(),
            'user' => $user,
        ));
    }

    /**
     * List of all unanswered questions
     *
     * @Route("/unanswered", name="question_unanswered")
     * @Template()
     *
     */
    public function unansweredAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $questions = $em->getRepository('AppBundle:Question')->findAllUnanswered();

        $form = $this->filterForms($request);

        return $this->render('question/index.html.twig', array(
            'questions' => $questions,
            'postform' => $form->createView(),
            'user' => $user,
        ));
    }

    /**
     * Lists of all questions in a category.
     *
     * @Route("/categories", name="question_categories")
     * @Template()
     */
    public function categoryAction(Request $request)
    {
        $questions = null;

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $label = $this->get('translator')->trans('question.general.filter');

        foreach ($categories as $category) {
            $name_set[$category->getCategory()] = $category->getId();
        }

        $form = $this->createFormBuilder(null)
            ->add('category', ChoiceType::class, array(
                'label' => 'question.category.label',
                'choices'  => $name_set,
            ))
            ->add($label, SubmitType::class, array(
                'label' => 'question.general.filter'
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $category = $form['category']->getData();

            $questions = $em->getRepository('AppBundle:Question')->findAllByCategory($category);


        } else if(!empty($categories)) {

            $category = reset($name_set);

            $questions = $em->getRepository('AppBundle:Question')->findAllByCategory($category);
        }

        return $this->render('question/index.html.twig', array(
            'postform' => $form->createView(),
            'questions' => $questions,
            'user' => $user,
        ));
    }

    /**
     * List of all the newest answered questions
     *
     * @Route("/newest", name="question_newest")
     * @Template()
     */
    public function newestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $questions = $em->getRepository('AppBundle:Question')->findByFilter("date");

        $form = $this->filterForms($request);

        return $this->render('question/index.html.twig', array(
            'questions' => $questions,
            'postform' => $form->createView(),
            'user' => $user,
        ));
    }

    /**
     * Creates a form to create a Question entity.
     *
     * @param Question $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Question $entity)
    {
        $form = $this->createForm('AppBundle\Form\QuestionType', $entity, array(
            'action' => $this->generateUrl('question_index'),
            'method' => 'POST',
        ));

        $form->remove("category");

        $translated = $this->get('translator')->trans('question.general.create');

        $form->add($translated, SubmitType::class, array(
                'attr' => array(
                    'class' => 'submit-form-button'
                ),
                'label' => 'question.general.create'
            )
        );

        return $form;
    }

    public function filterForms(Request $request)
    {
        $question = new Question();

        $form = $this->createCreateForm($question);

        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($form->isValid()) {
            $question->setDate(new \DateTime());
            $question->setDeleted(false);
            $em->persist($question);
            $em->flush();

            //create empty form after submit
            $question = new Question();
            $form = $this->createCreateForm($question);
        }

        return $form;
    }
}
