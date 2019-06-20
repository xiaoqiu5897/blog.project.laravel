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
	$('#categories-table').DataTable({
		/*hiển thị trạng thái 'đang xử lý' khi bảng đang được xử lý dữ liệu 
		(hữu ích với các bảng có dữ liệu lớn)*/
		processing: true,
		//xử lý dữ liệu theo kiểu Server Side
		serverSide: true,
		//route dùng để lấy dữ liệu
		ajax: '/admin/getlistcategories',
		//chú ý các cột viết theo đúng thứ tự theo các cột phía trên thẻ <thead>
		columns: [
			//DT_RowIndex là cột để tự tăng stt
			{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
			{ data: 'name', name: 'name'},
			{ data: 'thumbnail', name: 'thumbnail', width: '100px' },
			{ data: 'parent', name: 'parent', width: '100px' },
			{ data: 'description', name: 'description' },
			{ data: 'action', name: 'action', width: '100px'}
			]
		});

})

$(document).on('change', '.is_parent', function () {
	var status = $(this).val();
	
	if (status == 0) {
		$('.parent_category_div').css('display', 'none')
		$('.parent_id').attr('disabled', true)
	} else {
		$('.parent_category_div').css('display', 'block')
		$('.parent_id').attr('disabled', false)
	}
})

$(document).on('click', '.btn-add', function () {
	$('#modal-add').modal('show');
	$('#form-add')[0].reset();
	$('#add-name-error').html('');
	$('#add-slug-error').html('');
	$('#add-description-error').html('');
	$('#add-thumbnail-error').html('');
	$.ajax({
		type: 'get',
		url: '/admin/categories/create',
		success: function (res) {
			$.each(res.categories, function (key, value) {
				$('#form-add .parent_id').append('<option value="' + value.id + '">' + value.name + '</option>')
			})
		}
	})
})

$(document).on('submit', '#form-add', function (e) {
	e.preventDefault();
	var form = $(this)[0]; 
	var formData = new FormData(form);
	var status = $('#form-add .is_parent').val();
	if (status == 0) {
		formData.append('parent_id', null)
	} else {
		formData.append('parent_id', $('#form-add .parent_id').val())
	}
	$.ajax({
		cache: false,
		contentType: false,
		processData: false,
		type: 'post',
		url: '/admin/categories',
		data: formData,
		success: function (res) {
			toastr.success(res.success)
			$('#modal-add').modal('hide');
			$('#categories-table').DataTable().ajax.reload();
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

//Sự kiện click vào nút sửa
$(document).on('click', '.btn-edit', function () {
	$('#modal-edit').modal('show');
	$('#form-edit')[0].reset();
	var url = $(this).attr('data-url')
	$('#edit_thumbnail_div').html('');
	$('#edit-name-error').html('');
	$('#edit-slug-error').html('');
	$('#edit-description-error').html('');
	$('#edit-thumbnail-error').html('');
	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$('#edit_name').val(response.category.name)
			$('#edit_slug').val(response.category.slug)
			$('#edit_description').val(response.category.description)
			$('#edit_thumbnail_div').prepend('<img src="'+response.category.thumbnail+'" width="250px" height="250px">')
			$('#edit_thumbnail').attr('value', response.category.thumbnail)
			$('#form-edit').attr('data-url', '/admin/categories/' + response.category.id)
			$('#form-edit').attr('data-id', response.category.id)
			if (response.category.parent_id == null) {
				$('#form-edit .is_parent').val(0)
				$('#form-edit .parent_category_div').css('display', 'none')
				$('#form-edit .parent_id').attr('disabled', true)
			} else {
				$('#form-edit .is_parent').val(1)
				$('#form-edit .parent_category_div').css('display', 'block')
				$('#form-edit .parent_id').attr('disabled', false)
				$('#form-edit .parent_id').val(response.category.parent_id)
			}
			$.each(response.categories, function (key, value) {
				$('#form-edit .parent_id').append('<option value="' + value.id + '">' + value.name + '</option>')
			})
		}
	})
})

//Sự kiện submit form sửa
$(document).on('submit', '#form-edit', function (e) {
	e.preventDefault();
	var form = $(this)[0]; 
	var formData = new FormData(form);
	var url = $(this).data('url');
	formData.append('thumbnail', $('#edit_thumbnail').attr('value'));
	formData.append('id', $(this).data('id'));
	var status = $('#form-edit .is_parent').val();
	if (status == 0) {
		formData.append('parent_id', null)
	} else {
		formData.append('parent_id', $('#form-edit .parent_id').val())
	}
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
			$('#categories-table').DataTable().ajax.reload();
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
					$('#categories-table').DataTable().ajax.reload();
				}
			})
		}
	});
})