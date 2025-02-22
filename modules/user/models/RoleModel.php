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
}
