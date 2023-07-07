<?php

namespace App\Entity;
use DateTime;

class Order 
{
    public function __construct(
        private DateTime $creatAt,
        private string $customerName,
        private int $id_product,
        private ?int $id = null
    ){}

	/**
	 * @return DateTime
	 */
	public function getCreatAt(): DateTime {
		return $this->creatAt;
	}
	
	/**
	 * @param DateTime $creatAt 
	 * @return self
	 */
	public function setCreatAt(DateTime $creatAt): self {
		$this->creatAt = $creatAt;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getCustomerName(): string {
		return $this->customerName;
	}
	
	/**
	 * @param string $customerName 
	 * @return self
	 */
	public function setCustomerName(string $customerName): self {
		$this->customerName = $customerName;
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getIdProduct(): int {
		return $this->id_product;
	}
	
	/**
	 * @param  $id_product 
	 * @return self
	 */
	public function setIdProduct(int $id_product): self {
		$this->id_product = $id_product;
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getId(): ?int {
		return $this->id;
	}
	
	/**
	 * @param  $id 
	 * @return self
	 */
	public function setId(?int $id): self {
		$this->id = $id;
		return $this;
	}
}
