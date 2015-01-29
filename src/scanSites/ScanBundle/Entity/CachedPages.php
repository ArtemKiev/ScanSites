<?php

namespace scanSites\ScanBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CachedPages
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CachedPages
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
     * @var integer
     *
     * @ORM\Column(name="SiteID", type="integer")
     */
    private $siteID;

    /**
     * @var string
     *
     * @ORM\Column(name="Url", type="string", length=255)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="StatusCode", type="integer")
     */
    private $statusCode;

    /**
     * @var array
     *
     * @ORM\Column(name="InternalLinks", type="json_array")
     */
    private $internalLinks;

    /**
     * @var array
     *
     * @ORM\Column(name="OutLinks", type="json_array")
     */
    private $outLinks;

    /**
     * @var array
     *
     * @ORM\Column(name="BadLinks", type="json_array")
     */
    private $badLinks;

    /**
     * @var array
     *
     * @ORM\Column(name="Rels", type="json_array")
     */
    private $rels;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Created", type="datetime")
     */
    private $created;


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
     * Set siteID
     *
     * @param integer $siteID
     * @return CachedPages
     */
    public function setSiteID($siteID)
    {
        $this->siteID = $siteID;

        return $this;
    }

    /**
     * Get siteID
     *
     * @return integer 
     */
    public function getSiteID()
    {
        return $this->siteID;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return CachedPages
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set statusCode
     *
     * @param integer $statusCode
     * @return CachedPages
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Get statusCode
     *
     * @return integer 
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set internalLinks
     *
     * @param array $internalLinks
     * @return CachedPages
     */
    public function setInternalLinks($internalLinks)
    {
        $this->internalLinks = $internalLinks;

        return $this;
    }

    /**
     * Get internalLinks
     *
     * @return array 
     */
    public function getInternalLinks()
    {
        return $this->internalLinks;
    }

    /**
     * Set outLinks
     *
     * @param array $outLinks
     * @return CachedPages
     */
    public function setOutLinks($outLinks)
    {
        $this->outLinks = $outLinks;

        return $this;
    }

    /**
     * Get outLinks
     *
     * @return array 
     */
    public function getOutLinks()
    {
        return $this->outLinks;
    }

    /**
     * Set badLinks
     *
     * @param array $badLinks
     * @return CachedPages
     */
    public function setBadLinks($badLinks)
    {
        $this->badLinks = $badLinks;

        return $this;
    }

    /**
     * Get badLinks
     *
     * @return array 
     */
    public function getBadLinks()
    {
        return $this->badLinks;
    }

    /**
     * Set rels
     *
     * @param array $rels
     * @return CachedPages
     */
    public function setRels($rels)
    {
        $this->rels = $rels;

        return $this;
    }

    /**
     * Get rels
     *
     * @return array 
     */
    public function getRels()
    {
        return $this->rels;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return CachedPages
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }
}
