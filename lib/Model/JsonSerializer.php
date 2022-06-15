<?php


namespace Klix\Model;


trait JsonSerializer
{
	function jsonSerialize() {
		return array_filter((array) $this, function($property) {
			return isset($property);
		});
	}
}
