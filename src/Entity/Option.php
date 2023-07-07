<?php

namespace App\Entity;

class Option {
    public function __construct(
        private string $label,
        private float $price,
        private ?int $idProduct = null,
        private ?int $id = null
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
	public function getPrice(): float {
		return $this->price;
	}
	
	/**
	 * @param float $price 
	 * @return self
	 */
	public function setPrice(float $price): self {
		$this->price = $price;
		return $this;
	}
	
	/**
	 * @return 
	 */
	public function getIdProduct(): ?int {
		return $this->idProduct;
	}
	
	/**
	 * @param  $idProduct 
	 * @return self
	 */
	public function setIdProduct(?int $idProduct): self {
		$this->idProduct = $idProduct;
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