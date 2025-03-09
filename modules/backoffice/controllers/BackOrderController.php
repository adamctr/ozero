<?php
require_once __DIR__ . '/../../utils/controllers/EnumControllers.php';
class BackOrderController
{

    public function __construct() {}

    public function showAllOrders()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['totalAmount'] = $_POST['totalAmount'];
        try {

            if (!isset($_COOKIE['auth_token'])) {
                header('Location: /login');
            } else {
                $jwtManager = new JWT();
                if (!$jwtManager->getUserIdFromJWT()) {
                    header('Location: /login');
                } else {
                    $enums = new Enums();
                    $enumsStatus = $enums->getStatusOptions();
                    $purchaseModel = new PurchaseModel();
                    $purchaseList = $purchaseModel->getAllPurchases();
                    $view = new BackOrderView();
                    $view->showAllOrders($purchaseList, $enumsStatus);
                }
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
