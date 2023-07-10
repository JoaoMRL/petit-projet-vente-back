<?php

namespace App\Entity;

class Product {
	private ?string $picture;
    public function __construct(
        private string $label,
        private float $basePrice,
        private string $description,
        private ?int $idShop=null,
        private ?int $id=null
    ){}

	/**
	 * @return string
	 */
	public function getLabel(): string {
		return $this->label;
	}
	
	/**
	 * @param string $label 
	 * @return self
	 */
	public function setLabel(string $label): self {
		$this->label = $label;
		return $this;
	}
	
	/**
	 * @return float
	 */
	public function getBasePrice(): float {
		return $this->basePrice;
	}
	
	/**
	 * @param float $basePrice 
	 * @return self
	 */
	public function setBasePrice(float $basePrice): self {
		$this->basePrice = $basePrice;
		return $this;
	}
	
	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}
	
	/**
	 * @param string $description 
	 * @return self
	 */
	public function setDescription(string $description): self {
		$this->description = $description;
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getPicture(): ?string {
		return $this->picture;
	}
	
	/**
	 * @param  $picture 
	 * @return self
	 */
	public function setPicture(?string $picture): self {
		$this->picture = $picture;
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
	
	/**
	 * @return 
	 */
	public function getIdShop(): ?int {
		return $this->idShop;
	}
	
	/**
	 * @param  $idShop 
	 * @return self
	 */
	public function setIdShop(?int $idShop): self {
		$this->idShop = $idShop;
		return $this;
	}
}