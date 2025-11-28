<?php
session_start();
$BASE_URL = "http://thanhhuyle.infinityfree.me/index.php";
// --- 1. KHỞI TẠO DỮ LIỆU (MOCK DATA) ---
if (!isset($_SESSION['students'])) {
    $_SESSION['students'] = [
        ['id' => 1, 'name' => 'Nguyễn Văn A', 'year' => 2002, 'major' => 'CNTT'],
        ['id' => 2, 'name' => 'Trần Thị D', 'year' => 2003, 'major' => 'Kinh Tế'],
    ];
}

// Hàm lấy ID tự động tăng
function getNewId($list) {
    $maxId = 0;
    foreach ($list as $sv) {
        if ($sv['id'] > $maxId) $maxId = $sv['id'];
    }
    return $maxId + 1;
}

// Biến để chứa thông tin sinh viên khi bấm Sửa (để Frontend dùng)
$editStudent = null;

// --- 2. XỬ LÝ KHI NGƯỜI DÙNG SUBMIT FORM (POST) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'];
    $year = $_POST['year'];
    $major = $_POST['major'];

    if ($id) {
        // ==> LOGIC SỬA
        foreach ($_SESSION['students'] as &$sv) {
            if ($sv['id'] == $id) {
                $sv['name'] = $name;
                $sv['year'] = $year;
                $sv['major'] = $major;
                break;
            }
        }
    } else {
        // ==> LOGIC THÊM
        $newStudent = [
            'id' => getNewId($_SESSION['students']),
            'name' => $name,
            'year' => $year,
            'major' => $major
        ];
        $_SESSION['students'][] = $newStudent;
    }
    
    // Xử lý xong thì load lại trang chủ để tránh gửi lại form khi F5
    header("Location: index.php");
    exit();
}

// --- 3. XỬ LÝ KHI NGƯỜI DÙNG BẤM LINK (GET) ---
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? 0;

    // ==> LOGIC XÓA
    if ($action == 'delete') {
        foreach ($_SESSION['students'] as $key => $sv) {
            if ($sv['id'] == $id) {
                unset($_SESSION['students'][$key]);
                break;
            }
        }
        // Sắp xếp lại index mảng
        $_SESSION['students'] = array_values($_SESSION['students']);
        header("Location: index.php");
        exit();
    }

  // ==> LOGIC LẤY DỮ LIỆU ĐỂ SỬA
    if ($action == 'edit') {
        foreach ($_SESSION['students'] as $sv) {
            if ($sv['id'] == $id) {
                $editStudent = $sv;
                break;
            }
        }
    }
}

// --- 4. XỬ LÝ TÌM KIẾM ---
// Mặc định danh sách hiển thị là toàn bộ sinh viên
$studentsToDisplay = $_SESSION['students'];
$keyword = '';

if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $filteredList = [];
    
    foreach ($_SESSION['students'] as $sv) {
        // Dùng stripos để tìm kiếm không phân biệt hoa thường
        // Nếu tên sinh viên chứa từ khóa
        if (stripos($sv['name'], $keyword) !== false) {
            $filteredList[] = $sv;
        }
    }
    // Gán danh sách hiển thị bằng danh sách đã lọc
    $studentsToDisplay = $filteredList;
}
?>