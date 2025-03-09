<?php


class RoleModel
{
    protected $db;

    public function __construct()
    {
        $this->db = DataBase::getConnection();
    }

    public function getRoles(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM roles");
        $stmt->execute();

        $roles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $roleEntities = [];
        foreach ($roles as $role) {
            $roleEntities[] = new RoleEntity($role['roleId'], $role['role']);
        }
        return $roleEntities;
    }

    public function getRoleById(int $roleId): ?string
    {
        $stmt = $this->db->prepare("SELECT role FROM roles WHERE roleId = :roleId");
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['role'] : null;
    }
}
