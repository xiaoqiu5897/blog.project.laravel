<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 3000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Thêm mới danh mục</h3>
			</div>
			<div class="modal-body" style="padding: 20px 100px">
				<form action="" method="POST" role="form" id="form-add">
					<div class="form-group">
						<label for="">Tên <span class="error">*</span></label>
						<input type="text" id="name" onkeyup="ChangeToSlug('name', 'slug');" class="form-control" name="name" placeholder="Tên">
						<p class="error" id="add-name-error"></p>
					</div>
					<div class="form-group">
						<label for="">Slug <span class="error">*</span></label>
						<input type="text" class="form-control" id="slug" name="slug" placeholder="Slug">
						<p class="error" id="add-slug-error"></p>
					</div>
					<div class="form-group">
						<label for="">Mô tả <span class="error">*</span></label>
						<textarea class="form-control" name="description" placeholder="Mô tả"></textarea>
						<p class="error" id="add-description-error"></p>
					</div>
					<div class="form-group">
						<label for="">Loại danh mục <span class="error">*</span></label>
						<select name="" class="form-control is_parent">
							<option value="0">Danh mục cha</option>
							<option value="1">Danh mục con</option>
						</select>
						<p class="error" id="add-parent_id-error"></p>
					</div>
					<div class="form-group parent_category_div">
						<label for="">Danh mục cha <span class="error">*</span></label>
						<select name="parent_id" class="form-control parent_id" disabled>
						</select>
					</div>
					<div class="form-group">
						<label for="">Ảnh <span class="error">*</span></label>
						<input type="file" name="thumbnail" placeholder="Nội dung">
						<p class="error" id="add-thumbnail-error"></p>
					</div>
					<button type="submit" class="btn btn-primary" style="margin: auto;">Lưu</button>
				</form>
			</div>
		</div>
	</div>
</div>