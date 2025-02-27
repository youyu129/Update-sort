<?php
// 假設使用 POST 方法傳送 sortedIDs 參數
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 確保接收到排序後的 ID 陣列
    if (isset($_POST['sortedIDs'])) {
        $sortedIDs = $_POST['sortedIDs'];

        // 連接到資料庫
        $conn = new mysqli('localhost', 'username', 'password', 'database_name');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // 開始處理排序資料
        foreach ($sortedIDs as $rank => $id) {
            // 更新每個項目的 rank 欄位
            $stmt = $conn->prepare("UPDATE items SET rank = ? WHERE id = ?");
            $stmt->bind_param("ii", $rank, $id);
            $stmt->execute();
        }

        // 關閉資料庫連線
        $stmt->close();
        $conn->close();

        // 回應成功訊息
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No sorted IDs received']);
    }
}
