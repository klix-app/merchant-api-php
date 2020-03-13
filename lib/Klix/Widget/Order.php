<?php


namespace Klix\Widget;


class Order extends JsonSerializableObject
{

	use SignatureSourceFieldFormatter;

	/**
	 * @var string
	 */
	protected $orderId;

	/**
	 * @var OrderItem[]
	 */
	protected $items = array();

	/**
	 * @var ShippingOption[]
	 */
	protected $shippingOptions = array();

	/**
	 * @var OrderConstraints
	 */
	protected $constraints;

	/**
	 * @return Order
	 */
	public static function create() {
		return new Order();
	}

	/**
	 * @return string
	 */
	public function toSignatureSource()
	{
		$isJsonConfiguration = self::isJsonConfiguration();
		$signatureSource = $this->orderId;
		foreach ($this->items as $item) {
			$signatureSource .= $item->toSignatureSource($isJsonConfiguration);
		}
		if ($this->shippingOptions != null) {
			foreach ($this->shippingOptions as $shippingOption) {
				$signatureSource .= $shippingOption->toSignatureSource();
			}
		}
		if ($this->constraints != null) {
			$signatureSource .= $this->constraints->toSignatureSource();
		}
		return $signatureSource;
	}

	/**
	 * @return bool
	 */
	public function isJsonConfiguration() {
		return self::hasConstraints() ||
			self::hasShippingOptions() ||
			self::getOrderItemCount() > 1 ||
			(self::getOrderItemCount() == 1 && self::getOrderItem(0)->isJsonConfiguration());
	}

	/**
	 * @return int
	 */
	private function getOrderItemCount() {
		return sizeof($this->items);
	}

	/**
	 * @param integer $index
	 * @return OrderItem
	 */
	private function getOrderItem($index) {
		return $this->items[$index];
	}

	/**
	 * @return bool
	 */
	private function hasShippingOptions() {
		return $this->shippingOptions !== null && sizeof($this->shippingOptions) > 0;
	}

	/**
	 * @return bool
	 */
	private function hasConstraints() {
		return $this->constraints !== null;
	}

	/**
	 * @param $orderId string
	 * @return $this
	 */
	public function setOrderId($orderId)
	{
		$this->orderId = $orderId;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getOrderId()
	{
		return $this->orderId;
	}

	/**
	 * @param OrderItem[] $items
	 * @return $this
	 */
	public function setItems($items)
	{
		$this->items = $items;
		return $this;
	}

	/**
	 * @param OrderItem $item
	 * @return $this
	 */
	public function addItem($item) {
		array_push($this->items, $item);
		return $this;
	}

	/**
	 * @return OrderItem
	 */
	public function getFirstItem() {
		return $this->items[0];
	}

	/**
	 * @param ShippingOption[] $shippingOptions
	 * @return $this
	 */
	public function setShippingOptions($shippingOptions)
	{
		$this->shippingOptions = $shippingOptions;
		return $this;
	}

	/**
	 * @param ShippingOption $shippingOption
	 * @return $this
	 */
	public function addShippingOption($shippingOption) {
		array_push($this->shippingOptions, $shippingOption);
		return $this;
	}

	/**
	 * @param OrderConstraints $constraints
	 * @return $this
	 */
	public function setConstraints($constraints)
	{
		$this->constraints = $constraints;
		return $this;
	}
}
