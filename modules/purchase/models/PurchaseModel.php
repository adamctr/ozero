<?php


class PurchaseModel
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }
    public function newPurchase(PurchaseEntity $purchase)
    {
        $stmt = $this->db->prepare('INSERT INTO purchase (userId, totalAmount, status, addressId, paymentMethod) VALUES (:userId, :totalAmount, :status, :addressId, :paymentMethod)');
        $stmt->bindValue(':userId', $purchase->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':totalAmount', $purchase->getTotalAmount(), PDO::PARAM_STR);
        $stmt->bindValue(':status', $purchase->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':addressId', $purchase->getAddressId(), PDO::PARAM_INT);
        $stmt->bindValue(':paymentMethod', $purchase->getPaymentMethod(), PDO::PARAM_INT);
        $stmt->execute();
    }
}
