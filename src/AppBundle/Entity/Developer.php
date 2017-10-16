<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Developer
 *
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class Developer extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="firstname", type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "profile.register.notification.name.too-short",
     *      maxMessage = "profile.register.notification.name.too-long"
     * )
     */
    private $firstname;

    /**
     * @var string
     * @ORM\Column(name="infix", type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 10,
     *      minMessage = "profile.register.notification.prefix.too-short",
     *      maxMessage = "profile.register.notification.prefix.too-long"
     * )
     */
    private $infix;

    /**
     * @var string
     * @ORM\Column(name="lastname", type="string", length=255)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "profile.register.notification.lastname.too-short",
     *      maxMessage = "profile.register.notification.lastname.too-long"
     * )
     */
    private $lastname;

    /**
     * @var string
     */
    protected $email;



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
     * Set firstname
     *
     * @param string $firstname
     * @return Developer
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set infix
     *
     * @param string $infix
     * @return Developer
     */
    public function setInfix($infix)
    {
        $this->infix = $infix;

        return $this;
    }

    /**
     * Get infix
     *
     * @return string
     */
    public function getInfix()
    {
        return $this->infix;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Developer
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $email
     * @return $this|\FOS\UserBundle\Model\UserInterface
     */
    public function setEmail($email)
    {
        if (is_null($this->getUsername())) {
            $this->setUsername($email);
        }

        return parent::setEmail($email);
    }
}
