<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Question;
use AppBundle\Form\EditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Service\QuestionService;
use Symfony\Component\Security\Acl\Exception\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Question controller.
 *
 * @Route("/question")
 */
class QuestionController extends Controller
{
    /**
     * Finds and displays a question entity.
     *
     * @Route("/detail/{question}", name="question_detail")
     * @ParamConverter("question", class="AppBundle:Question")
     */
    public function detailAction(Request $request, Question $question)
    {

        $user = $this->getUser();

        try {
            $previousUrl = $this->redirect($request->headers->get('referer'));
            $previousUrl = $previousUrl->getTargetUrl();
        }catch (Exception $exception){
            $previousUrl = $this->redirectToRoute('question_index');
        }




        $hasAnswer = $question->getAnswer();

        if ($user == null and $hasAnswer == null) {
            return $this->redirectToRoute('question_index');
        } else {
            return $this->render('question/show.html.twig', array(
                'question' => $question,
                'user' => $user,
                'previous' => $previousUrl,
            ));
        }
    }

    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("edit/{question}", name="question_edit")
     * @ParamConverter("question", class="AppBundle:Question")
     * @Method({"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function editAction(Request $request, Question $question)
    {
        $label = $this->get('translator')->trans('question.general.edit');

        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('AppBundle\Form\EditType', $question);

        if (!$question->getDeveloper()) {
            $question->setDeveloper($user);
        }

        if (($question->getDeveloper()->getId() == $user->getId()) || ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))) {

            $form->add('answer', TextareaType::class, array(
                'attr' => array('cols' => '5', 'rows' => '8')))
                ->add($label, SubmitType::class);

            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($question);
                $em->flush();
                return $this->redirectToRoute('question_index');
            }

            return $this->render('question/edit.html.twig', array(
                'form' => $form->createView(),
            ));
        } else {
            return $this->redirectToRoute('fos_user_security_login');
        }
    }

    /**
     * Deletes a question entity.
     *
     * @Route("delete/{question}", name="question_delete")
     * @ParamConverter("question", class="AppBundle:Question")
     */
    public function deleteAction(Request $request, Question $question)
    {
        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('AppBundle:Question')->findBy(array("id" => $question));

        if($question->getDeveloper()->getId()){

        }

        if (($question->getDeveloper()->getId() == $user->getId())) {

            if ($questions === null) {
                return $this->redirectToRoute('question_index');
            } else {
                $questions[0]->setDeleted(true);
                $em->persist($questions[0]);
                $em->flush();
                return $this->redirectToRoute('question_index');
            }
        }
        return $this->redirectToRoute('question_index');
    }
}
