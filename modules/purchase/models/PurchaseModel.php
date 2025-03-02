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
        $stmt = $this->db->prepare('INSERT INTO purchases (userId, totalAmount, status, addressId, paymentMethod) VALUES (:userId, :totalAmount, :status, :addressId, :paymentMethod)');
        $stmt->bindValue(':userId', $purchase->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':totalAmount', $purchase->getTotalAmount(), PDO::PARAM_STR);
        $stmt->bindValue(':status', $purchase->getStatus(), PDO::PARAM_STR);
        $stmt->bindValue(':addressId', $purchase->getAddressId(), PDO::PARAM_INT);
        $stmt->bindValue(':paymentMethod', $purchase->getPaymentMethod(), PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updatePurchaseStatus($purchaseId, string $status)
    {
        $stmt = $this->db->prepare('UPDATE purchases SET status = :status WHERE purchaseId = :purchaseId');
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':purchaseId', $purchaseId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getAllPurchasesById($userId): array
    {
        $stmt = $this->db->prepare('SELECT * FROM purchases WHERE userId = :userId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $datas = $stmt->fetchAll();
        $purchasesList = [];
        foreach ($datas as $data) {
            $purchasesList[] = new PurchaseEntity($data);
        }
        return $purchasesList;
    }

    public function getPurchaseById($userId, $purchaseId): ?PurchaseEntity
    {
        $stmt = $this->db->prepare('SELECT * FROM purchases WHERE userId = :userId AND purchaseId = :purchaseId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':purchaseId', $purchaseId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result ? new PurchaseEntity($result) : null;
    }
}
