<div class="modal fade" id="modal-add" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 2000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Thêm mới bài viết</h3>
			</div>
			<div class="modal-body" style="padding: 20px 100px">
				<form action="" method="POST" role="form" id="form-add">
					<div class="form-group">
						<label for="">Tiêu đề <span class="error">*</span></label>
						<input type="text" id="title" onkeyup="ChangeToSlug('title', 'slug');" class="form-control" name="title" placeholder="Tiêu đề">
						<p class="error" id="add-title-error"></p>
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
						<label for="">Nội dung <span class="error">*</span></label>
						<textarea name="content" id="add_content"></textarea>
						<p class="error" id="add-content-error"></p>
					</div>
					<div class="form-group">
						<label for="">Ảnh <span class="error">*</span></label>
						<input type="file" class="form-control" name="thumbnail" placeholder="Nội dung">
						<p class="error" id="add-thumbnail-error"></p>
					</div>
					<div class="form-group" >
						<label for="">Danh mục <span class="error">*</span></label><br>
						<select name="category" id="category" class="form-control"></select>
						<p class="error" id="add-category-error"></p>
					</div>
					<div class="form-group" >
						<label for="">Tag</label><br>
						<input class="form-control magicsearch" id="tag" name="tag">					
					</div>
					<button type="submit" class="btn btn-primary" style="margin: auto;">Lưu</button>
				</form>
			</div>
		</div>
	</div>
</div>