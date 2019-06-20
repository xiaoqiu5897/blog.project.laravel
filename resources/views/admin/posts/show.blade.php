<div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 2000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Xem chi tiết bài viết</h3>
			</div>
			<div class="modal-body" style="padding: 20px 100px">
				<form action="" method="POST" role="form"s>
					<div class="form-group">
						<label for="">Tiêu đề </label>
						<input type="text" id="show_title" class="form-control" >
					</div>
					<div class="form-group">
						<label for="">Slug </label>
						<input type="text" class="form-control" id="show_slug" >
					</div>
					<div class="form-group">
						<label for="">Mô tả </label>
						<textarea class="form-control" id="show_description"></textarea>
					</div>
					<div class="form-group">
						<label for="">Nội dung </label>
						<textarea name="content" id="show_content"></textarea>
					</div>
					<div class="form-group">
						<label for="">Ảnh </label><br>
						<img src="" id="show_thumbnail" width="70%" height="400px">
					</div>
					<div class="form-group" >
						<label for="">Danh mục </label>
						<input id="show_category" class="form-control">
					</div>
					<div class="form-group" >
						<label for="">Tag </label>
						<input class="form-control" id="show_tag" nam="tag[]" multiple>
					</div>
					<div class="form-group" >
						<label for="">Người tạo </label>
						<input id="show_user" class="form-control">					
					</div>
					<div class="form-group" >
						<label for="">Ngày tạo </label>
						<input id="show_created_at" class="form-control">					
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


