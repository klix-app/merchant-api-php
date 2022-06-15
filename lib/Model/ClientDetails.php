<?php
namespace Klix\Model;

class ClientDetails implements \JsonSerializable {
	use JsonSerializer;

	/**
	 *
	 * @var string
	 */
	public $email;
	
	/**
	 *
	 * @var string
	 */
	public $phone;
	
	/**
	 *
	 * @var string
	 */
	public $full_name;
	
	/**
	 *
	 * @var string
	 */
	public $personal_code;
	
	/**
	 *
	 * @var string
	 */
	public $street_address;
	
	/**
	 *
	 * @var string
	 */
	public $country;
	
	/**
	 *
	 * @var string
	 */
	public $city;
	
	/**
	 *
	 * @var string
	 */
	public $zip_code;
	
	/**
	 *
	 * @var string
	 */
	public $shipping_street_address;
	
	/**
	 *
	 * @var string
	 */
	public $shipping_country;
	
	/**
	 *
	 * @var string
	 */
	public $shipping_city;
	
	/**
	 *
	 * @var string
	 */
	public $shipping_zip_code;
	
	/**
	 *
	 * @var string[]
	 */
	public $cc;
	
	/**
	 *
	 * @var string[]
	 */
	public $bcc;
	
	/**
	 *
	 * @var string
	 */
	public $legal_name;
	
	/**
	 *
	 * @var string
	 */
	public $brand_name;
	
	/**
	 *
	 * @var string
	 */
	public $registration_number;
	
	/**
	 *
	 * @var string
	 */
	public $tax_number;
}
