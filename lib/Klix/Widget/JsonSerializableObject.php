<?php


namespace Klix\Widget;


use JsonSerializable;

abstract class JsonSerializableObject implements JsonSerializable
{

	public function jsonSerialize()
	{
		return get_object_vars($this);
	}
}
