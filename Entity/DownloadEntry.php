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
 * MFB\CmsBundle\Entity\Category
 *
 * @ORM\Table(name="cms_download_entries")
 * @ORM\Entity()
 */
class DownloadEntry
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
     * @var Category $category
     *
     * @ORM\ManyToOne(targetEntity="DownloadCategory")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=255)
     * @Gedmo\Slug(fields={"title"})
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $uploader;

    /**
     * @var integer
     *
     * @ORM\Column(name="vote_amount", type="integer")
     */
    private $voteAmount = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="vote_sum", type="integer")
     */
    private $voteSum = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="decimal", precision=4, scale=2, nullable=true)
     */
    private $rating = null;

    /**
     * @var string $active
     *
     * @ORM\Column(name="active", type="boolean")
     */
    protected $active;

    /**
     * @var \DateTime $createdAt
     *
     * @ORM\Column(name="created_at", type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    protected $createdAt;

    /**
     * @var \DateTime $updatedAt
     *
     * @ORM\Column(name="updated_at", type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $updatedAt;

    /**
     * Get title
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ? $this->getTitle() : '';
    }

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
     * Set category
     *
     * @param integer $category
     *
     * @return DownloadEntry
     */
    public function setCategory($category)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return integer 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return DownloadEntry
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
     * Set rating
     *
     * @param float $rating
     *
     * @return DownloadEntry
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    
        return $this;
    }

    /**
     * Get rating
     *
     * @return float 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return DownloadEntry
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
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
     *
     * @return DownloadEntry
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set author
     *
     * @param string $author
     *
     * @return DownloadEntry
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Category
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Category
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Category
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set uploader
     *
     * @param User $uploader
     *
     * @return DownloadEntry
     */
    public function setUploader(User $uploader = null)
    {
        $this->uploader = $uploader;
    
        return $this;
    }

    /**
     * Get uploader
     *
     * @return User
     */
    public function getUploader()
    {
        return $this->uploader;
    }

    /**
     * Add to voteAmount
     *
     * @param integer $voteAmount
     *
     * @return DownloadEntry
     */
    public function addVoteAmount($voteAmount = 1)
    {
        $this->voteAmount += $voteAmount;

        if ($this->voteAmount > 0) {
            $this->rating = round($this->voteSum / $this->voteAmount, 2);
        }
    
        return $this;
    }

    /**
     * Set voteAmount
     *
     * @param integer $voteAmount
     *
     * @return DownloadEntry
     */
    public function setVoteAmount($voteAmount)
    {
        $this->voteAmount = $voteAmount;

        if ($this->voteAmount > 0) {
            $this->rating = round($this->voteSum / $this->voteAmount, 2);
        }

        return $this;
    }

    /**
     * Get voteAmount
     *
     * @return integer 
     */
    public function getVoteAmount()
    {
        return $this->voteAmount;
    }

    /**
     * Add to voteSum
     *
     * @param integer $voteSum
     *
     * @return DownloadEntry
     */
    public function addVoteSum($voteSum = 1)
    {
        $this->voteSum += $voteSum;

        if ($this->voteAmount > 0) {
            $this->rating = round($this->voteSum / $this->voteAmount, 2);
        }
    
        return $this;
    }

    /**
     * Set voteSum
     *
     * @param integer $voteSum
     *
     * @return DownloadEntry
     */
    public function setVoteSum($voteSum)
    {
        $this->voteSum = $voteSum;

        if ($this->voteAmount > 0) {
            $this->rating = round($this->voteSum / $this->voteAmount, 2);
        }

        return $this;
    }

    /**
     * Get voteSum
     *
     * @return integer 
     */
    public function getVoteSum()
    {
        return $this->voteSum;
    }
}