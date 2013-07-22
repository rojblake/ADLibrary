<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorites entity class.
 *
 * Annotations define the entity mappings to database.
 *
 * @ORM\Entity
 * @ORM\Table(name="adlibrary")
 */
class ADLibrary_Entity_Connections extends Zikula_EntityAccess
{

    /**
     * The following are annotations which define the id field.
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * The following are annotations which define the facebook user id field.
     *
     * @ORM\Column(type="bigint", options={"unsigned"=true})
     */
    private $zk_id;
	
	/**
     * The following are annotations which define the user id field.
     *
     * @ORM\Column(type="string")
     */
    private $ad_id;
	

	
	public function getid()
    {
        return $this->id;
    }

    public function getzk_id()
    {
        return $this->zk_id;
    }

    public function getad_id()
    {
        return $this->ad_id;
    }

    public function setzk_id($zk_id)
    {
        $this->zk_id = $zk_id;
    }

    public function setad_id($ad_id)
    {
    	$this->ad_id = $ad_id;	

    }

}