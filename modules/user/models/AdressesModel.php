<?php


class AdressesModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }
    public function getAllAddresses()
    {
        $stmt = $this->db->query('SELECT * FROM adresses');;
        $datas = $stmt->fetchAll();

        $adressesList = [];
        foreach ($datas as $data) {
            $adressesList[] = new AddressesEntity($data);
        }
        return $adressesList;
    }

    public function getAddressesByUserId(int $userId): ?AddressesEntity
    {
        $stmt = $this->db->prepare('SELECT * FROM addresses WHERE userId = :userId');
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result ? new AddressesEntity($result) : null;
    }

    public function createAddress(AddressesEntity $address)
    {

        $stmt = $this->db->prepare('INSERT INTO addresses (userId, street, city, zipCode, country, phone, isDefault) VALUES (:userId, :street, :city, :zipCode, :country, :phone, :isDefault)');
        $stmt->bindValue(':userId', $address->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':street', $address->getStreet(), PDO::PARAM_STR);
        $stmt->bindValue(':city', $address->getCity(), PDO::PARAM_STR);
        $stmt->bindValue(':zipCode', $address->getZipCode(), PDO::PARAM_STR);
        $stmt->bindValue(':country', $address->getCountry(), PDO::PARAM_STR);
        $stmt->bindValue(':phone', $address->getPhone(), PDO::PARAM_STR);
        $stmt->bindValue(':isDefault', $address->getIsDefault(), PDO::PARAM_INT);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updateAddress(AddressesEntity $address)
    {
        $stmt = $this->db->prepare('UPDATE addresses SET street = :street, city = :city, zipCode = :zipCode, country = :country, phone = :phone, isDefault = :isDefault WHERE userId = :userId');
        $stmt->bindValue(':userId', $address->getUserId(), PDO::PARAM_INT);
        $stmt->bindValue(':street', $address->getStreet(), PDO::PARAM_STR);
        $stmt->bindValue(':city', $address->getCity(), PDO::PARAM_STR);
        $stmt->bindValue(':zipCode', $address->getZipCode(), PDO::PARAM_STR);
        $stmt->bindValue(':country', $address->getCountry(), PDO::PARAM_STR);
        $stmt->bindValue(':phone', $address->getPhone(), PDO::PARAM_STR);
        $stmt->bindValue(':isDefault', $address->getIsDefault(), PDO::PARAM_INT);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}
