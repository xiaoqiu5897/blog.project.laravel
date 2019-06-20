$(document).ready(function () {
	CKEDITOR.replace('add_content');
	CKEDITOR.replace('edit_content');
	CKEDITOR.replace('show_content');
})

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
	//Đổ dữ liệu lên bảng có id là posts-table
	$('#posts-table').DataTable({
		/*hiển thị trạng thái 'đang xử lý' khi bảng đang được xử lý dữ liệu 
		(hữu ích với các bảng có dữ liệu lớn)*/
		processing: true,
		//xử lý dữ liệu theo kiểu Server Side
		serverSide: true,
		//route dùng để lấy dữ liệu
		ajax: '/admin/posts/getlistposts',
		//chú ý các cột viết theo đúng thứ tự theo các cột phía trên thẻ <thead>
		columns: [
			//DT_RowIndex là cột để tự tăng stt
			{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
			{ data: 'title', name: 'title'},
			{ data: 'thumbnail', name: 'thumbnail', width: '100px' },
			{ data: 'description', name: 'description' },
			{ data: 'action', name: 'action', width: '100px'}
			]
		});
	//Sự kiện click vào nút thêm mới
	$('#btn-add').on('click', function () {
		$('#modal-add').modal('show');
		$('#form-add')[0].reset();
		$('#add-title-error').html('');
		$('#add-slug-error').html('');
		$('#add-description-error').html('');
		$('#add-thumbnail-error').html('');
		$('#add-content-error').html('');
		$('#add-category-error').html('');
		$.ajax({
			type: 'get',
			url: '/admin/posts/create',
			success: function (response) {
				$.each(response.categories, function(i, item) {
					$('#category').append('<option value="'+item.id+'">'+item.name+'</option>')
				});
				$('#tag').magicsearch({
					dataSource: response.tags,
					fields: ['name'],
					id: 'id',
					format: '%name%',
					multiple: true,
					focusShow: true,
					showSelected: false,
					multiField: 'name',
					multiStyle: {
						space: 5,
						width: 100
					},
					noResult: 'Không tìm thấy tag này'
				});
			}
		})
	})
	//Sự kiện submit form thêm mới
	$('#form-add').on('submit', function (e) {
		e.preventDefault();
		var form = $(this)[0]; 
		var formData = new FormData(form);
		var dataList = $(".multi-item").map(function() {
			return $(this).data("id");
		}).get();
		formData.append('post_tag', dataList.join(','))
		formData.append('content', CKEDITOR.instances.add_content.getData());
		$.ajax({
			cache: false,
			contentType: false,
			processData: false,
			type: 'post',
			url: '/admin/posts',
			data: formData,
			success: function (res) {
				toastr.success(res.success)
				$('#modal-add').modal('hide');
				$('#posts-table').DataTable().ajax.reload();
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
	$('#show_tag').trigger('destroy');
	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$('#show_title').val(response.post.title)
			$('#show_slug').val(response.post.slug)
			$('#show_description').val(response.post.description)
			$('#show_created_at').val(response.post.created_at)
			$('#show_user').val(response.user)
			$('#show_category').val(response.category.name)
			$.each(response.post_tags, function(i, item) {
				var tag = [];
				tag.push(item.name);
				$('#show_tag').val(tag.join(","));
			});
			$('#show_thumbnail').attr('src', response.post.thumbnail)
			CKEDITOR.instances.show_content.setData(response.post.content)
		}
	})
})
//Sự kiện click vào nút sửa
$(document).on('click', '.btn-edit', function () {
	$('#modal-edit').modal('show');
	$('#form-edit')[0].reset();
	var url = $(this).attr('data-url')
	$('#edit_thumbnail_div').html('');
	$('#edit_tag').trigger('destroy');
	$('#edit-title-error').html('');
	$('#edit-slug-error').html('');
	$('#edit-description-error').html('');
	$('#edit-thumbnail-error').html('');
	$('#edit-content-error').html('');
	$('#edit-category-error').html('');
	$.ajax({
		type: 'get',
		url: url,
		success: function (response) {
			$.each(response.categories, function(i, item) {
				$('#edit_category').append('<option value="'+item.id+'">'+item.name+'</option>')
			});
			var tag = [];
			$.each(response.post_tags, function(i, item) {
				tag.push(item.tag_id);
			});
			$('#edit_tag').attr('data-id', tag.join(","))
			$('#edit_tag').magicsearch({
				dataSource: response.tags,
				fields: ['name'],
				id: 'id',
				format: '%name%',
				multiple: true,
				focusShow: true,
				showSelected: false,
				multiField: 'name',
				multiStyle: {
					space: 5,
					width: 100
				},
				noResult: 'Không tìm thấy tag này'
			});
			$('#edit_title').val(response.post.title)
			$('#edit_slug').val(response.post.slug)
			$('#edit_description').val(response.post.description)
			CKEDITOR.instances.edit_content.setData(response.post.content);
			$('#edit_thumbnail_div').prepend('<img src="'+response.post.thumbnail+'" width="250px" height="250px">')
			$('#edit_category').val(response.post.category_id)
			$('#edit_thumbnail').attr('value', response.post.thumbnail)
			$('#form-edit').attr('data-url', '/admin/posts/' + response.post.id)
			$('#form-edit').attr('data-id', response.post.id)
			$('.multi-item-close').attr('data-post-id', response.post.id)
		}
	})
})
//Sự kiện submit form sửa
$(document).on('submit', '#form-edit', function (e) {
	e.preventDefault();
	var form = $(this)[0]; 
	var formData = new FormData(form);
	var url = $(this).data('url');
	var dataList = $(".multi-item").map(function() {
		return $(this).data("id");
	}).get();
	formData.append('post_tag', dataList.join(','));
	formData.append('content', CKEDITOR.instances.edit_content.getData());
	formData.append('thumbnail', $('#edit_thumbnail').attr('value'));
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
			$('#posts-table').DataTable().ajax.reload();
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
					$('#posts-table').DataTable().ajax.reload();
				}
			})
		}
	});
})
//Sự kiện xóa tag của bài viết trong modal sửa bài viết
$(document).on('click', '.multi-item-close', function () {
	var id = $(this).data('id')
	var post_id = $(this).attr('data-post-id')
	$.ajax({
		type: 'delete',
		url: 'posts/removetag/' + id,
		data: {
			post_id: post_id
		},
		success: function (res) {

		}
	})
}) 