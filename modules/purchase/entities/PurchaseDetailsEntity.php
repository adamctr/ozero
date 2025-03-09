<?php

class PurchaseDetailsEntity
{
    private int $purchaseId;
    private int $productid;
    private int $quantity;
    private float $unitPrice;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = "set" . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }



    /**
     * Get the value of purchaseId
     */
    public function getPurchaseId()
    {
        return $this->purchaseId;
    }

    /**
     * Set the value of purchaseId
     *
     * @return  self
     */
    public function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;

        return $this;
    }



    /**
     * Get the value of productid
     */
    public function getProductid()
    {
        return $this->productid;
    }

    /**
     * Set the value of productid
     *
     * @return  self
     */
    public function setProductid($productid)
    {
        $this->productid = $productid;

        return $this;
    }

    /**
     * Get the value of quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set the value of quantity
     *
     * @return  self
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get the value of unitPrice
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * Set the value of unitPrice
     *
     * @return  self
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }
}
