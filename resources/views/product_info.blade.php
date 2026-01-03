<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update sản phẩm</title>
    <style>
        /* Body styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #9df0ff;
            margin: 0;
        }

        /* Wrapper for compatibility with sidebar */
        .body-wrapper {
            margin-left: 250px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Container styling */
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
        }

        td {
            padding: 10px;
            border: 1px solid #ddd;
            color: #333;
        }

        textarea {
            width: 100%;
            resize: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            font-family: Arial, sans-serif;
        }

        /* Input styling */
        input[type="text"],
        select,
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* Button styling */
        .btn-custom {
            background: linear-gradient(to right, #8ec3ff, #e1eefc);
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #12fe61, #bdffe1);
            transform: scale(1.05);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 600px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            textarea {
                height: 120px;
            }

            h1 {
                font-size: 1.8em;
            }
        }
    </style>
</head>

<body>
    @include('dashboard') <!-- Sidebar -->

    <div class="body-wrapper">
        <div class="container">
            <h1>Cập nhật sản phẩm</h1>
            <form action="/cap-nhat-san-pham" method="post" enctype="multipart/form-data">
                @csrf
                <table class="table table-hover">
                    <tr>
                        <td>ID</td>
                        <td>
                            {{ $item[0]->Product_ID }}
                            <input type="hidden" value="{{ $item[0]->Product_ID }}" name="txt_id">
                        </td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <td><input type="text" value="{{ $item[0]->Name }}" name="txt_name" required></td>
                    </tr>
                    <tr>
                        <td>Ảnh</td>
                        <td>
                            <img src="{{ @$item[0]->Img }}" width="100" alt="Ảnh sản phẩm">
                            <input type="file" name="txt_image" accept="image/*">
                            <input type="hidden" name="txt_img_old" value="{{ @$item[0]->Img }}">
                        </td>
                    </tr>
                    <tr>
                        <td>Danh mục</td>
                        <td>
                            <select name="txt_category">
                                <?php foreach ($categories as $category) {
                                    $selected = $category->Category_ID == $item[0]->cate_id ? 'selected' : '';
                                    echo "<option value='{$category->Category_ID}' $selected>{$category->Category_name}</option>";
                                } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Giá</td>
                        <td><input type="text" value="{{ $item[0]->Price }}" name="txt_price" required></td>
                    </tr>
                    <tr>
                        <td>Số lượng</td>
                        <td><input type="text" value="{{ $item[0]->Quantily }}" name="txt_quantily" required></td>
                    </tr>
                    <tr>
                        <td>Mô tả</td>
                        <td>
                            <textarea name="txt_description" required>{{ $item[0]->Description }}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-custom">Cập nhật</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>

</html>
