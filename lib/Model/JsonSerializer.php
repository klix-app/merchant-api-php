<?php


namespace Klix\Model;


trait JsonSerializer
{
	public function jsonSerialize(): mixed {
		return array_filter((array) $this, function($property) {
			return isset($property);
		});
	}
}
