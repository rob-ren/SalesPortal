<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 10/8/17
 * Time: 4:14 PM
 */

namespace DatabaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="ipx_sales_project")
 */
class Project
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="projects")
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id")
     */
    protected $account;

    /**
     * @ORM\OneToMany(targetEntity="ProjectMeta",mappedBy="project")
     */
    protected $project_metas;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $suburb;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $postcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $country;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $availability = 1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable= true)
     */
    protected $min_price = 1;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable= true)
     */
    protected $max_price = 1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $front_image;

    /**
     * @ORM\Column(type="decimal", scale=6, nullable=true)
     */
    protected $longitude;

    /**
     * @ORM\Column(type="decimal", scale=6, nullable=true)
     */
    protected $latitude;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $timestamp;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $trashed = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $beds;

    /**
     * @ORM\Column(type="decimal", scale=1, nullable=true)
     */
    protected $baths;

    /**
     * @ORM\Column(type="decimal", scale=1, nullable=true)
     */
    protected $cars;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $storages;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $internal_area;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $external_area;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $land;

    /**
     */
    public function __construct()
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
     * Set title
     *
     * @param string $title
     *
     * @return Project
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
     * Set type
     *
     * @param string $type
     *
     * @return Project
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
     * Set address
     *
     * @param string $address
     *
     * @return Project
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set suburb
     *
     * @param string $suburb
     *
     * @return Project
     */
    public function setSuburb($suburb)
    {
        $this->suburb = $suburb;

        return $this;
    }

    /**
     * Get suburb
     *
     * @return string
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * Set state
     *
     * @param string $state
     *
     * @return Project
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     *
     * @return Project
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Project
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set availability
     *
     * @param string $availability
     *
     * @return Project
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Project
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
     * Set minPrice
     *
     * @param string $minPrice
     *
     * @return Project
     */
    public function setMinPrice($minPrice)
    {
        $this->min_price = $minPrice;

        return $this;
    }

    /**
     * Get minPrice
     *
     * @return string
     */
    public function getMinPrice()
    {
        return $this->min_price;
    }

    /**
     * Set maxPrice
     *
     * @param string $maxPrice
     *
     * @return Project
     */
    public function setMaxPrice($maxPrice)
    {
        $this->max_price = $maxPrice;

        return $this;
    }

    /**
     * Get maxPrice
     *
     * @return string
     */
    public function getMaxPrice()
    {
        return $this->max_price;
    }

    /**
     * Set frontImage
     *
     * @param string $frontImage
     *
     * @return Project
     */
    public function setFrontImage($frontImage)
    {
        $this->front_image = $frontImage;

        return $this;
    }

    /**
     * Get frontImage
     *
     * @return string
     */
    public function getFrontImage()
    {
        return $this->front_image;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Project
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Project
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     *
     * @return Project
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
     * Set trashed
     *
     * @param boolean $trashed
     *
     * @return Project
     */
    public function setTrashed($trashed)
    {
        $this->trashed = $trashed;

        return $this;
    }

    /**
     * Get trashed
     *
     * @return boolean
     */
    public function getTrashed()
    {
        return $this->trashed;
    }

    /**
     * Set beds
     *
     * @param integer $beds
     *
     * @return Project
     */
    public function setBeds($beds)
    {
        $this->beds = $beds;

        return $this;
    }

    /**
     * Get beds
     *
     * @return integer
     */
    public function getBeds()
    {
        return $this->beds;
    }

    /**
     * Set baths
     *
     * @param integer $baths
     *
     * @return Project
     */
    public function setBaths($baths)
    {
        $this->baths = $baths;

        return $this;
    }

    /**
     * Get baths
     *
     * @return integer
     */
    public function getBaths()
    {
        return $this->baths;
    }

    /**
     * Set cars
     *
     * @param integer $cars
     *
     * @return Project
     */
    public function setCars($cars)
    {
        $this->cars = $cars;

        return $this;
    }

    /**
     * Get cars
     *
     * @return integer
     */
    public function getCars()
    {
        return $this->cars;
    }

    /**
     * Set storages
     *
     * @param integer $storages
     *
     * @return Project
     */
    public function setStorages($storages)
    {
        $this->storages = $storages;

        return $this;
    }

    /**
     * Get storages
     *
     * @return integer
     */
    public function getStorages()
    {
        return $this->storages;
    }

    /**
     * Set internalArea
     *
     * @param string $internalArea
     *
     * @return Project
     */
    public function setInternalArea($internalArea)
    {
        $this->internal_area = $internalArea;

        return $this;
    }

    /**
     * Get internalArea
     *
     * @return string
     */
    public function getInternalArea()
    {
        return $this->internal_area;
    }

    /**
     * Set externalArea
     *
     * @param string $externalArea
     *
     * @return Project
     */
    public function setExternalArea($externalArea)
    {
        $this->external_area = $externalArea;

        return $this;
    }

    /**
     * Get externalArea
     *
     * @return string
     */
    public function getExternalArea()
    {
        return $this->external_area;
    }

    /**
     * Set land
     *
     * @param string $land
     *
     * @return Project
     */
    public function setLand($land)
    {
        $this->land = $land;

        return $this;
    }

    /**
     * Get land
     *
     * @return string
     */
    public function getLand()
    {
        return $this->land;
    }

    /**
     * Set account
     *
     * @param \DatabaseBundle\Entity\Account $account
     *
     * @return Project
     */
    public function setAccount(\DatabaseBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \DatabaseBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * convert Project Obj to Array output
     *
     * @return array
     */
    public function convertToArray()
    {
        $result = array();
        $result ['id'] = $this->id;
        $result ['account'] = $this->getAccount()->convertToArray();
        $result ['title'] = $this->title;
        $result ['type'] = $this->type;
        $result ['address'] = $this->address;
        $result ['suburb'] = $this->suburb;
        $result ['postcode'] = $this->postcode;
        $result ['country'] = $this->country;
        $result ['availability'] = $this->availability;
        $result ['description'] = $this->description;
        $result ['min_price'] = $this->min_price;
        $result ['max_price'] = $this->max_price;
        $result ['front_image'] = $this->front_image;
        $result ['longitude'] = $this->longitude;
        $result ['latitude'] = $this->latitude;
        $result ['trashed'] = $this->trashed;
        $result ['beds'] = $this->beds;
        $result ['baths'] = $this->baths;
        $result ['cars'] = $this->cars;
        $result ['trashed'] = $this->storages;
        $result ['internal_area'] = $this->internal_area;
        $result ['external_area'] = $this->external_area;
        $result ['land'] = $this->land;
        $result ['created_time_stamp'] = $this->timestamp->format('m/d/Y H:i:s');
        return $result;
    }
}
