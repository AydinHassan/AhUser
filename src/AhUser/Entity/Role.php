<?php

namespace AhUser\Entity;

use BjyAuthorize\Acl\HierarchicalRoleInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Aydin Hassan <aydin@hotmail.co.uk>
 *
 * @ORM\Entity
 * @ORM\Table(name="role")
 */
class Role implements HierarchicalRoleInterface
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
     * @ORM\Column(type="string", length=255, unique=true, nullable=true, name="role_id")
     */
    protected $roleId;

    /**
     * @var AhUser\Entity\Role
     * 
     * @ORM\ManyToOne(targetEntity="AhUser\Entity\Role")
     */
    protected $parent;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param type $id
     * @return \AhUser\Entity\Role
     */
    public function setId($id)
    {
        $this->id = (int) $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoleId()
    {
        return $this->roleId;
    }

    /**
     * @param type $roleId
     * @return \AhUser\Entity\Role
     */
    public function setRoleId($roleId)
    {
        $this->roleId = (string) $roleId;
        return $this;
    }

    /**
     * @return \AhUser\Entity\Role
     */
    public function getParent()
    {
        return $this->parent;
    }

   /**
    * @param \AhUser\Entity\Role $parent
    * @return \AhUser\Entity\Role
    */
    public function setParent(Role $parent)
    {
        $this->parent = $parent;
        return $this;
    }
}
