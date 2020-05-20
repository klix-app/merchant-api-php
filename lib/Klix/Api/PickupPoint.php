<?php

namespace Klix\Api;

class PickupPoint extends Model
{
	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->values['name'];
	}

	/**
	 * @param $name string
	 * @return $this
	 */
	public function setName($name)
	{
		$this->values['name'] = $name;
		return $this;
	}

	/**
	 * @return string
	 */
    public function getExternalId()
    {
        return $this->values['external_id'];
    }

	/**
	 * @param $externalId string
	 * @return $this
	 */
    public function setExternalId($externalId)
    {
        $this->values['external_id'] = $externalId;
        return $this;
    }

	/**
	 * @return string
	 */
	public function getComments()
	{
		return $this->values['comments'];
	}

	/**
	 * @param $comments string
	 * @return $this
	 */
	public function setComments($comments)
	{
		$this->values['comments'] = $comments;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getServiceHours()
	{
		return $this->values['service_hours'];
	}

	/**
	 * @param string $serviceHours
	 * @return $this
	 */
	public function setServiceHours($serviceHours)
	{
		$this->values['service_hours'] = $serviceHours;
		return $this;
	}
}
