<?php

namespace App\Entity;

class Option {
    public function __construct(
        private string $label,
        private float $price,
        private ?int $id_product = null,
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
	public function getId_product(): ?int {
		return $this->id_product;
	}
	
	/**
	 * @param  $id_product 
	 * @return self
	 */
	public function setId_product(?int $id_product): self {
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