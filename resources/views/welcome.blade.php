<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Document</title>
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/jquery.magicsearch.css') }}">
</head>
<body>
    <form action="" method="POST" role="form">
        <input class="form-control magicsearch" id="tag" name="tag">    
    </form>

    <script type="text/javascript" src="{{ asset('admin_assets/jquery.magicsearch.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajax({
                type: 'get',
                //Đường dẫn lấy ra tất cả các tag
                url: '/get-tag',
                success: function (response) {
                    $('#tag').magicsearch({
                        // Tất cả các tag có trong cơ sở dữ liệu, kiểu json
                        dataSource: response.tags,
                        fields: ['name'],
                        // Chọn id là giá trị lưu vào data-id của ô input
                        id: 'id',
                        // Chọn tất cả các tag sẽ hiển thị theo cách nào, %name% để hiển thị giá trị name của tag
                        format: '%name%',
                        // Được chọn nhiều tag
                        multiple: true,
                        // Hiển thị các tag được chọn
                        focusShow: true,
                        // Không hiển thị các tag đã được chọn
                        showSelected: false,
                        // Các tag được chọn hiển thị theo name
                        multiField: 'name',
                        // Css tag
                        multiStyle: {
                            space: 5,
                            width: 100
                        },
                        // Nhập tag không có trong cơ sở dữ liệu thì hiển thị thông báo
                        noResult: 'Không tìm thấy tag này'
                    });
                }
            })
        })
    </script>
</body>
</html>