<?php


class PurchaseDetailsModel
{
    private $db;
    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function newPurchaseDetail(PurchaseDetailsEntity $purchaseDetail)
    {
        $stmt = $this->db->prepare('INSERT INTO purchaseDetails (purchaseId, productId, quantity, unitPrice) VALUES (:purchaseId, :productId, :quantity, :unitPrice)');
        $stmt->bindValue(':purchaseId', $purchaseDetail->getPurchaseId(), PDO::PARAM_INT);
        $stmt->bindValue(':productId', $purchaseDetail->getProductId(), PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $purchaseDetail->getQuantity(), PDO::PARAM_INT);
        $stmt->bindValue(':unitPrice', $purchaseDetail->getunitPrice(), PDO::PARAM_STR);
        $stmt->execute();
    }
}
