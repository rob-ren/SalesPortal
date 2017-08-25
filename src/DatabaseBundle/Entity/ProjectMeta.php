<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 4:58 PM
 */

namespace DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ipx_sales_project_meta")
 */
class ProjectMeta
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="project_metas")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    protected $project;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $meta_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $meta_value;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    function __construct()
    {
        $this->timestamp = new \DateTime ();
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
     * Set type
     *
     * @param string $type
     *
     * @return ProjectMeta
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
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
     * Set metaName
     *
     * @param string $metaName
     *
     * @return ProjectMeta
     */
    public function setMetaName($metaName)
    {
        $this->meta_name = $metaName;

        return $this;
    }

    /**
     * Get metaName
     *
     * @return string
     */
    public function getMetaName()
    {
        return $this->meta_name;
    }

    /**
     * Set metaValue
     *
     * @param string $metaValue
     *
     * @return ProjectMeta
     */
    public function setMetaValue($metaValue)
    {
        $this->meta_value = $metaValue;

        return $this;
    }

    /**
     * Get metaValue
     *
     * @return string
     */
    public function getMetaValue()
    {
        return $this->meta_value;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return ProjectMeta
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set project
     *
     * @param \DatabaseBundle\Entity\Project $project
     *
     * @return ProjectMeta
     */
    public function setProject(\DatabaseBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \DatabaseBundle\Entity\Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * convert Project Meta Obj to Array output
     *
     * @return array
     */
    public function convertToArray()
    {
        $result = array();
        $result ['id'] = $this->id;
        $result ['project'] = $this->getProject()->convertToArray();
        $result ['type'] = $this->type;
        $result ['meta_name'] = $this->meta_name;
        $result ['meta_value'] = $this->meta_value;
        $result ['created_time_stamp'] = $this->timestamp->format('m/d/Y H:i:s');
        return $result;
    }
}
