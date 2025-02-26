<?php

class PaymentsEntity
{
    private int $paymentId;
    private int $purchaseId;
    private int $amount;
    private string $paymentDate;
    private string $paymentStatus;
    private string $transactionId;

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
     * Get the value of paymentId
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }
    /**
     * Set the value of paymentId
     * @return  self
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
        return $this;
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
     * @return  self
     */
    public function setPurchaseId($purchaseId)
    {
        $this->purchaseId = $purchaseId;
        return $this;
    }
    /**
     * Get the value of amount
     */
    public function getAmount()
    {
        return $this->amount;
    }
    /**
     * Set the value of amount
     * @return  self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * Get the value of paymentDate
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }
    /**
     * Set the value of paymentDate
     * @return  self
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }
    /**
     * Get the value of paymentStatus
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }
    /**
     * Set the value of paymentStatus
     * @return  self
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
        return $this;
    }
    /**
     * Get the value of transactionId
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    /**
     * Set the value of transactionId
     * @return  self
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}
