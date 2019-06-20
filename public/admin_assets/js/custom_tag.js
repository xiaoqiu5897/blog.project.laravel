$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function ChangeToSlug(_title, _slug) {
	var title, slug;

	//Lấy text từ thẻ input title 
	title = document.getElementById(_title).value;

	//Đổi chữ hoa thành chữ thường
	slug = title.toLowerCase();

	//Đổi ký tự có dấu thành không dấu
	slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
	slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
	slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
	slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
	slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
	slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
	slug = slug.replace(/đ/gi, 'd');
	//Xóa các ký tự đặt biệt
	slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
	//Đổi khoảng trắng thành ký tự gạch ngang
	slug = slug.replace(/ /gi, "-");
	//Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
	//Phòng trường hợp người nhập vào quá nhiều ký tự trắng
	slug = slug.replace(/\-\-\-\-\-/gi, '-');
	slug = slug.replace(/\-\-\-\-/gi, '-');
	slug = slug.replace(/\-\-\-/gi, '-');
	slug = slug.replace(/\-\-/gi, '-');
	//Xóa các ký tự gạch ngang ở đầu và cuối
	slug = '@' + slug + '@';
	slug = slug.replace(/\@\-|\-\@|\@/gi, '');
	//In slug ra textbox có id “slug”
	document.getElementById(_slug).value = slug;
}

$(document).ready(function () {
	//Đổ dữ liệu lên bảng có id là categories-table
	$('#tags-table').DataTable({
		/*hiển thị trạng thái 'đang xử lý' khi bảng đang được xử lý dữ liệu 
		(hữu ích với các bảng có dữ liệu lớn)*/
		processing: true,
		//xử lý dữ liệu theo kiểu Server Side
		serverSide: true,
		//route dùng để lấy dữ liệu
		ajax: '/admin/getlisttags',
		//chú ý các cột viết theo đúng thứ tự theo các cột phía trên thẻ <thead>
		columns: [
			//DT_RowIndex là cột để tự tăng stt
			{ data: 'DT_RowIndex', name: 'DT_RowIndex', width: '100px' },
			{ data: 'name', name: 'name'},
			{ data: 'slug', name: 'slug'},
			{ data: 'action', name: 'action', width: '100px'}
			]
		});

	//Sự kiện click vào nút thêm mới
	$('#btn-add').on('click', function () {
		$('#modal-add').modal('show');
		$('#form-add')[0].reset();
		$('#add-name-error').html('');
		$('#add-slug-error').html('');
	})

	//Sự kiện submit form thêm mới
	$('#form-add').on('submit', function (e) {
		e.preventDefault();
		var form = $(this)[0]; 
		var formData = new FormData(form);
		$.ajax({
			cache: false,
			contentType: false,
			processData: false,
			type: 'post',
			url: '/admin/tags',
			data: formData,
			success: function (res) {
				toastr.success(res.success)
				$('#modal-add').modal('hide');
				$('#tags-table').DataTable().ajax.reload();
			},
			error: function (error) {
				if(error.status === 422) {
					$.each(error.responseJSON.errors, function (key, value) {
						$('#add-'+key+'-error').html(value);
					});
				}
			}
		})
	})

})


//Sự kiện click vào nút xem chi tiết
$(document).on('click', '.btn-show', function () {
	$('#modal-show').modal('show')
	url = $(this).data('url');
	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$('#show_name').val(response.tag.name)
			$('#show_slug').val(response.tag.slug)
			$('#show_created_at').val(response.tag.created_at)
		}
	})
})

//Sự kiện click vào nút sửa
$(document).on('click', '.btn-edit', function () {
	$('#modal-edit').modal('show');
	$('#form-edit')[0].reset();
	var url = $(this).attr('data-url')
	$('#edit-name-error').html('');
	$('#edit-slug-error').html('');
	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$('#edit_name').val(response.tag.name)
			$('#edit_slug').val(response.tag.slug)
			$('#form-edit').attr('data-url', '/admin/tags/' + response.tag.id)
		}
	})
})

//Sự kiện submit form sửa
$(document).on('submit', '#form-edit', function (e) {
	e.preventDefault();
	var form = $(this)[0]; 
	var formData = new FormData(form);
	var url = $(this).data('url');
	formData.append('id', $(this).data('id'));
	$.ajax({
		cache: false,
		contentType: false,
		processData: false,
		type: 'post',
		url: url + '?_method=PUT',
		data: formData,
		success: function (res) {
			toastr.success(res.success)
			$('#modal-edit').modal('hide');
			$('#tags-table').DataTable().ajax.reload();
		},
		error: function (error) {
			if(error.status === 422) {
				$.each(error.responseJSON.errors, function (key, value) {
					$('#edit-'+key+'-error').html(value);
				});
			}
		}
	})
})

//Sự kiện click vào nút xóa
$(document).on('click', '.btn-delete', function (e) {
	var url = $(this).data('url');
	swal({
		title: "Bạn có chắc chắn xóa bài viết này không?",
		icon: "warning",
		buttons: true,
		dangerMode: true,
	})
	.then((willDelete) => {
		if (willDelete) {
			$.ajax({
				type: 'delete',
				url: url,
				success: function () {
					swal("Bài viết đã bị xóa!", {
						icon: "success",
					});
					$('#tags-table').DataTable().ajax.reload();
				}
			})
		}
	});
})