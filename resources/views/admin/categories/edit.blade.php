<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 3000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Chỉnh sửa danh mục</h3>
			</div>
			<div class="modal-body" style="padding: 20px 100px">
				<form action="" method="POST" role="form" id="form-edit" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Tên <span class="error">*</span></label>
						<input type="text" id="edit_name" onkeyup="ChangeToSlug('edit_name', 'edit_slug');" class="form-control" name="name" placeholder="Tên">
						<p class="error" id="edit-name-error"></p>
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
						<label for="">Loại danh mục <span class="error">*</span></label>
						<select name="" class="form-control is_parent">
							<option value="0">Danh mục cha</option>
							<option value="1">Danh mục con</option>
						</select>
						<p class="error" id="edit-parent_id-error"></p>
					</div>
					<div class="form-group parent_category_div">
						<label for="">Danh mục cha <span class="error">*</span></label>
						<select name="parent_id" class="form-control parent_id" disabled>
						</select>
					</div>
					<div class="form-group">
						<label for="">Ảnh <span class="error">*</span></label> 
						<div id="edit_thumbnail_div"></div>
						<br>
						<input type="file" class="form-control" id="edit_thumbnail" name="edit_thumbnail" placeholder="Nội dung">
						<p class="error" id="edit-thumbnail-error"></p>
					</div>
					<button type="submit" class="btn btn-primary" style="margin: auto;">Lưu</button>
				</form>
			</div>
		</div>
	</div>
</div>