<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <script src="//code.jquery.com/jquery.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
    <form action="/file" id="form-upload" enctype="multipart/form-data" method="POST">
        {{ csrf_field() }}
        <input type="file" name="file" required="true">
        <br/>
        <input type="submit" id="upload">
    </form>
    <div id="file-uploaded">

    </div>

   {{--  <script type="text/javascript">
        $('#form-upload').on('submit', function (e) {
            e.preventDefault();
            //lấy tất cả giá trị các ô input có trong form
            var form = $(this)[0];
            //đẩy tất cả dữ liệu của form vào FormData
            var formData = new FormData(form);
            $.ajax({
                cache: false,
                contentType: false,
                processData: false,
                type: 'post',
                url: '/file',
                data: formData,
                success: function (res) {
                    //Hiển thị ảnh vào thẻ div có id là file-uploaded
                    $('#file-uploaded').html('<img src="{{ asset('/storage') }}/' + res.path + '">')
                }
            })
        })
    </script> --}}
</body>
</html>