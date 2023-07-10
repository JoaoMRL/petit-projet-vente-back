<?php

namespace App\Entity;
use DateTime;

class Order 
{
    public function __construct (
        private DateTime $createAt,
        private string $customerName,
        private int $idProduct,
        private ?int $id = null
    ){}
	/** 
	 * @return DateTime
	 */
	public function getCreateAt(): DateTime {
		return $this->createAt;
	}
	
	/**
	 * @param DateTime $createAt 
	 * @return self
	 */
	public function setCreateAt(DateTime $creatAt): self {
		$this->createAt = $creatAt;
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
		return $this->idProduct;
	}
	
	/**
	 * @param  $id_product 
	 * @return self
	 */
	public function setIdProduct(int $id_product): self {
		$this->idProduct = $id_product;
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
