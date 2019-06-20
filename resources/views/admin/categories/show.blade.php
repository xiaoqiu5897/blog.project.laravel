<div class="modal fade" id="modal-show" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="z-index: 2000">
	<div class="modal-dialog modal-lg" role="document" style="max-width: 80%">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" align="center" id="exampleModalCenterTitle">Xem chi tiết danh mục</h3>
			</div>
			<div class="modal-body" style="padding: 20px 100px">
				<div>
					<button data-url="{{route('posts.create')}}" class="btn btn-primary btn-add" style="margin-left: 20px">Thêm mới</button>
				</div>
				<br>
				<table class="table table-hover" id="show-category-table">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên</th>
							<th>Ảnh</th>
							<th>Mô tả</th>
							<th>Chức năng</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>


