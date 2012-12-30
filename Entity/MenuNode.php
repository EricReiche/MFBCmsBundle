<?php

namespace MFB\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * @Gedmo\Tree(type="nested")
 * @ORM\Table(name="menu_nodes")
 * @ORM\Entity(repositoryClass="Gedmo\Tree\Entity\Repository\NestedTreeRepository")
 */
class MenuNode
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=64)
     */
    private $title;

    /**
     * @ORM\Column(name="link_plain", type="string", length=255)
     */
    private $linkPlain;

    /**
     * @ORM\Column(name="link_type", type="string", length=64, nullable=true)
     *
     * @see Types\MenuNodeLinkTypeTypem
     */
    private $linkType;

    /**
     * @ORM\Column(name="link_path", type="string", length=255, nullable=true)
     */
    private $linkPath;

    /**
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(name="link_arguments", type="array", nullable=true)
     */
    private $linkArguments;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="lft", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="lvl", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="rgt", type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\Column(name="root", type="integer", nullable=true)
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="MenuNode", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="MenuNode", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLft()
    {
        return $this->lft;
    }

    public function getRoot()
    {
        return $this->root;
    }

    public function getRgt()
    {
        return $this->rgt;
    }

    public function setParent(MenuNode $parent = null)
    {
        $this->parent = $parent;
    }

    public function getParent()
    {
        return $this->parent;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function getLinkPlain()
    {
        return $this->linkPlain;
    }

    public function setLinkPlain($linkPlain)
    {
        return $this->linkPlain = $linkPlain;
    }

    public function getLinkType()
    {
        return $this->linkType;
    }

    public function setLinkType($linkType)
    {
        return $this->linkType = $linkType;
    }

    public function getLinkPath()
    {
        return $this->linkPath;
    }

    public function setLinkPath($linkPath)
    {
        return $this->linkPath = $linkPath;
    }

    public function getLinkArguments()
    {
        return $this->linkArguments;
    }

    public function setLinkArguments($linkArguments)
    {
        return $this->linkArguments = $linkArguments;
    }
}
