<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Repository\QuestionRepository;


/**
 * Question
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="question", type="text")
     * @Assert\Length(
     *      min = 10,
     *      minMessage = "Your explanation must be at least {{ limit }} characters long"
     * )
     */
    private $question;


    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text")
     * @Assert\Length(
     *      min = 10,
     *      max = 140,
     *      minMessage = "Your question must be longer than {{ limit }} characters",
     *      maxMessage = "Your question can only be {{ limit }} characters long"
     * )
     */
    private $title;


    /**
     * @var datetime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer", nullable = true)
     */
    private $likes;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(nullable=true)
     */
    private $category;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Developer")
     *
     */
    private $developer;

    /**
     * @var string
     *
     * @ORM\Column(name="answer", type="text", nullable = true)
     */
    private $answer;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", nullable = true)
     */
    private $city;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable = true)
     * @Assert\Type(type="numeric", message="Je leeftijd moet een getal zijn.")
     * @Assert\Range(
     *      min = 5,
     *      max = 120,
     *      minMessage = "Je moet minstens {{ limit }} jaar oud zijn",
     *      maxMessage = "Weet je zeker dat je zo oud bent?"
     * )
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable = true)
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable = false, options={"default":false})
     *
     */
    private $deleted;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set question
     *
     * @param string $question
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Question
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }


    /**
     * Set likes
     *
     * @param integer $likes
     * @return Question
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get likes
     *
     * @return integer
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Set categorieId
     *
     * @param integer $categorieId
     * @return Question
     */
    public function setCategorieId($categorieId)
    {
        $this->categorieId = $categorieId;

        return $this;
    }

    /**
     * Get categorieId
     *
     * @return integer
     */
    public function getCategorieId()
    {
        return $this->categorieId;
    }

    /**
     * Set answer
     *
     * @param string $answer
     * @return Question
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * Get answer
     *
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return Question
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Question
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Question
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Deleted
     *
     * @param $deleted
     * @return Question
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }


    /**
     * Get Deleted
     *
     * @return bool
     */
    public function getDeleted()
    {
        return $this->deleted;
    }


    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Question
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\Category $category
     * @return Question
     */
    public function setCategory(\AppBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set developer
     *
     * @param \AppBundle\Entity\Developer $developer
     * @return Question
     */
    public function setDeveloper(\AppBundle\Entity\Developer $developer = null)
    {
        $this->developer = $developer;

        return $this;
    }

    /**
     * Get developer
     *
     * @return \AppBundle\Entity\Developer
     */
    public function getDeveloper()
    {
        return $this->developer;
    }


}
