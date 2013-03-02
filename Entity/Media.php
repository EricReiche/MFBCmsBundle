<?php

namespace MFB\CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use MFB\CmsBundle\Entity\Types\MediaTypeType;
use MFB\CmsBundle\Entity\Types\MediaParentType;
use MFB\CmsBundle\Entity\Types\StatusType;

/**
 * @category   MFB
 * @package    MFBCmsBundle
 * @author     Eric Reiche <e@reiche.me>
 * @author     MFB MeinFernbus GmbH <kontakt@meinfernbus.de>
 * @copyright  2012 MFB MeinFernbus GmbH
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/meinfernbusde/MFBCmsBundle
 *
 * MFB\CmsBundle\Entity\Media
 *
 * @ORM\Table(name="medias")
 * @ORM\Entity(repositoryClass="MFB\CmsBundle\Entity\Repository\MediaRepository")
 */
class Media
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    protected $slug;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @ORM\Column(name="type", type="string", length=10, nullable=false)
     *
     * @var string $type
     */
    protected $type = MediaTypeType::PICTURE;

    /**
     * @ORM\Column(name="parent_type", type="string", length=10, nullable=true)
     *
     * @var string $parentType
     */
    protected $parentType = MediaParentType::GALLERY;

    /**
     * @ORM\Column(name="parent_id", type="integer", nullable=true)
     *
     * @var int $parentID
     */
    protected $parentID;

    /**
     * @ORM\Column(name="status", type="string", length=10, nullable=false)
     *
     * @var string $status
     */
    protected $status = StatusType::DISABLED;

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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * Get title
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
