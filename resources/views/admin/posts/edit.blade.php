<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 2000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Chỉnh sửa bài viết</h3>
			</div>
			<div class="modal-body" style="padding: 20px 100px">
				<form action="" method="POST" role="form" id="form-edit" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Tiêu đề <span class="error">*</span></label>
						<input type="text" id="edit_title" onkeyup="ChangeToSlug('edit_title', 'edit_slug');" class="form-control" name="title" placeholder="Tiêu đề">
						<p class="error" id="edit-title-error"></p>
					</div>
					<div class="form-group">
						<label for="">Slug <span class="error">*</span></label>
						<input type="text" class="form-control" id="edit_slug" name="slug" placeholder="Slug">
						<p class="error" id="edit-slug-error"></p>
					</div>
					<div class="form-group">
						<label for="">Mô tả <span class="error">*</span></label>
						<textarea class="form-control" id="edit_description" name="description" placeholder="Mô tả"></textarea>
						<p class="error" id="edit-description-error"></p>
					</div>
					<div class="form-group">
						<label for="">Nội dung <span class="error">*</span></label>
						<textarea name="content" id="edit_content"></textarea>
						<p class="error" id="edit-content-error"></p>
					</div>
					<div class="form-group">
						<label for="">Ảnh <span class="error">*</span></label> 
						<div id="edit_thumbnail_div"></div>
						<br>
						<input type="file" class="form-control" id="edit_thumbnail" name="edit_thumbnail" placeholder="Nội dung">
						<p class="error" id="edit-thumbnail-error"></p>
					</div>
					<div class="form-group" >
						<label for="">Danh mục <span class="error">*</span></label><br>
						<select name="category" id="edit_category" class="form-control">
							<option value="0">Chọn</option>
						</select>
						<p class="error" id="edit-category-error"></p>
					</div>
					<div class="form-group" >
						<label for="">Tag</label><br>
						<input class="form-control magicsearch" id="edit_tag" name="tag">
					</div>
					<button type="submit" class="btn btn-primary" style="margin: auto;">Lưu</button>
				</form>
			</div>
		</div>
	</div>
</div>