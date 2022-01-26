<?php

namespace App\Entity;

use App\Repository\CardRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardRepository::class)
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Command::class, inversedBy="cards")
     */
    private $command;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="cards")
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $product_amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function setCommand(?Command $command): self
    {
        $this->command = $command;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getProductAmount(): ?int
    {
        return $this->product_amount;
    }

    public function setProductAmount(int $product_amount): self
    {
        $this->product_amount = $product_amount;

        return $this;
    }
}
