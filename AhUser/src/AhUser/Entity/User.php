<?php
 
namespace AhUser\Entity;

use BjyAuthorize\Provider\Role\ProviderInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ZfcUser\Entity\UserInterface;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 * 
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface, ProviderInterface
{
    /**
     * @var int
     * 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=255, unique=true, nullable=false)
     */
    protected $username;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", unique=true,  length=255, nullable=false)
     */
    protected $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="first_name", length=255, nullable=false)
     */
    protected $firstName;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="last_name", length=255, nullable=false)
     */
    protected $lastName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="display_name", length=50, nullable=true)
     */
    protected $displayName;

    /**
     * @var string
     * 
     * @ORM\Column(type="string", length=128)
     */
    protected $password;

    /**
     * @var int
     * 
     * @ORM\Column(type="integer", name="state", nullable=true) 
     */
    protected $state;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="AhUser\Entity\Role")
     * @ORM\JoinTable(name="user_role",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
    
    /**
     * Initialise the roles variable.
     */
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return \AhUser\Entity\User
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return \AhUser\Entity\User
     */
    public function setUsername($username)
    {
        $this->username = (string) $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \AhUser\Entity\User
     */
    public function setEmail($email)
    {
        $this->email = (string) $email;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFirstName() 
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return \AhUser\Entity\User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = (string) $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName() 
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return \AhUser\Entity\User
     */
    public function setLastName($lastName)
    {
        $this->lastName = (string) $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param string $displayName
     * @return \AhUser\Entity\User
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = (string) $displayName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return \AhUser\Entity\User
     */
    public function setPassword($password)
    {
        $this->password = (string) $password;
        return $this;
    }
    
    /**
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param int $state
     * @return \AhUser\Entity\User
     */
    public function setState($state)
    {
        $this->state = (int) $state;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->getValues();
    }

    /**
     * @param type $role
     * @return \AhUser\Entity\User
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getFullName() {
        return ucfirst($this->getFirstName()) . ' ' . ucfirst($this->getLastName());
    }
    
}
