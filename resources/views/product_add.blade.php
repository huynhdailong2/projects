<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Thêm Sản Phẩm</title>
    <style>
        /* Gradient background */
        body {
            font-family: Arial, sans-serif;

            margin: 0;
            color: #333;
        }

        /* Sidebar compatibility */
        .body-wrapper {
            margin-left: 280px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Container styling */
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            margin: 0 auto;
            /* Đặt ở giữa màn hình */
            text-align: center;
        }

        /* Heading styling */
        .container h1 {
            color: #4facfe;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 10px;
            font-size: 16px;
        }

        input[type="text"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-top: 5px;
        }

        /* Button styling */
        input[type="submit"] {
            background-color: #4facfe;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #00d4fe;
        }
    </style>
</head>

<body>
    @include('dashboard') <!-- Sidebar -->

    <!-- Body content -->
    <div class="body-wrapper">
        <div class="container">
            <h1>Thêm sản phẩm</h1>
            <form action="/them-san-pham" method="post" enctype="multipart/form-data">
                <table>
                    @csrf
                    <tr>
                        <td>Tên</td>
                        <td><input type="text" name="txt_name" required></td>
                    </tr>
                    <tr>
                        <td>Danh mục</td>
                        <td>
                            <select name="txt_category" required>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->Category_ID ?>"><?= $category->Category_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Ảnh</td>
                        <td><input type="file" name="txt_image" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td>Giá</td>
                        <td><input type="text" name="txt_price" required></td>
                    </tr>
                    <tr>
                        <td>Số lượng</td>
                        <td><input type="text" name="txt_quantily" required></td>
                    </tr>
                    <tr>
                        <td>Mô tả</td>
                        <td>
                            <textarea name="txt_description" cols="30" rows="5" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="submit" value="Thêm"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>

</html>
