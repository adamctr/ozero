<?php


class Model
{
    protected $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function createPayment(PaymentsEntity $payment)
    {
        $stmt = $this->db->prepare('INSERT INTO payments (purchaseId, amount, paymentStatus)VALUES (:purchaseId, :amount, :paymentStatus)');
        $stmt->bindValue(':purchaseId', $payment->getPurchaseId(), PDO::PARAM_INT);
        $stmt->bindValue(':amount', $payment->getAmount(), PDO::PARAM_STR);
        $stmt->bindValue(':paymentStatus', $payment->getPaymentStatus(), PDO::PARAM_STR);
        $stmt->execute();
    }
}
