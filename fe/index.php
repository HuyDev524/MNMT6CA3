<?php 
// Gọi logic backend vào đây
require_once 'backend.php'; 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-center mb-4 text-primary">Hệ Thống Quản Lý Sinh Viên (FE & BE Tách Biệt)1</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <?php echo $editStudent ? 'Cập Nhật Thông Tin' : 'Thêm Sinh Viên Mới'; ?>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="index.php">
                            <input type="hidden" name="id" value="<?php echo $editStudent['id'] ?? ''; ?>">

                            <div class="mb-3">
                                <label class="form-label">Họ và Tên</label>
                                <input type="text" name="name" class="form-control" required 
                                       value="<?php echo $editStudent['name'] ?? ''; ?>" placeholder="Nhập tên...">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Năm Sinh</label>
                                <input type="number" name="year" class="form-control" required 
                                       value="<?php echo $editStudent['year'] ?? ''; ?>" placeholder="200x">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Ngành Hoc</label>
                                <select name="major" class="form-select">
                                    <option value="CNTT" <?php echo (isset($editStudent) && $editStudent['major'] == 'CNTT') ? 'selected' : ''; ?>>CNTT</option>
                                    <option value="Kinh Tế" <?php echo (isset($editStudent) && $editStudent['major'] == 'Kinh Tế') ? 'selected' : ''; ?>>Kinh Tế</option>
                                    <option value="Ngôn Ngữ" <?php echo (isset($editStudent) && $editStudent['major'] == 'Ngôn Ngữ') ? 'selected' : ''; ?>>Ngôn Ngữ</option>
                                </select>
                            </div>
                            
                            <button type="submit" name="save" class="btn btn-success w-100">
                                <?php echo $editStudent ? 'Lưu Cập Nhật' : 'Thêm Mới'; ?>
                            </button>

                            <?php if($editStudent): ?>
                                <a href="index.php" class="btn btn-secondary w-100 mt-2">Hủy Bỏ</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        Danh Sách Sinh Viên
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ Tên</th>
                                    <th>Năm Sinh</th>
                                    <th>Ngành</th>
                                    <th class="text-center">Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($_SESSION['students'])): ?>
                                    <?php foreach ($_SESSION['students'] as $sv): ?>
                                        <tr>
                                            <td><?php echo $sv['id']; ?></td>
                                            <td><?php echo $sv['name']; ?></td>
                                            <td><?php echo $sv['year']; ?></td>
                                            <td><span class="badge bg-info text-dark"><?php echo $sv['major']; ?></span></td>
                                            <td class="text-center">
                                                <a href="index.php?action=edit&id=<?php echo $sv['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                                                
                                                <a href="index.php?action=delete&id=<?php echo $sv['id']; ?>" 
                                                   class="btn btn-danger btn-sm" 
                                                   onclick="return confirm('Bạn chắc chắn muốn xóa?');">Xóa</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">Chưa có dữ liệu</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>