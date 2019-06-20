<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 2000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Chỉnh sửa tag</h3>
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
					<button type="submit" class="btn btn-primary" style="margin: auto;">Lưu</button>
				</form>
			</div>
		</div>
	</div>
</div>