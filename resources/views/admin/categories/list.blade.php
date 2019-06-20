@extends('admin.layouts.master')

@section('header')
<style type="text/css">
	.error {
		color: red;
	}
	.multi-item {
		background-color: #ffcf83 !important;
	}
	.magicsearch-wrapper .multi-item-close:before, .magicsearch-wrapper .multi-item-close:after {
		background-color: #ff9c00 !important;
	}
	.parent_category_div {
		display: none;
	}
</style>
@endsection 

@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			Data Tables
			<small>advanced tables</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Bảng điều khiển</a></li>
			<li><a href="#">Quản lý danh mục</a></li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
						<h3 class="box-title">Data Table With Full Features</h3>
					</div>
					<div>
						<button data-url="{{route('posts.create')}}" class="btn btn-primary btn-add" style="margin-left: 20px">Thêm mới</button>
					</div>
					<!-- /.box-header -->
					<div class="box-body ">
						<table id="categories-table"  class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>STT</th>
									<th>Tên</th>
									<th>Hình ảnh</th>
									<th>Danh mục cha</th>
									<th>Mô tả</th>
									<th>Chức năng</th>
								</tr>
							</thead>
						</table>
					</div>
					<!-- /.box-body -->
				</div>
				<!-- /.box -->
			</div>
			<!-- /.col -->
		</div>
		<!-- /.row -->
	</section>
	<!-- /.content -->
</div>

@include('admin.categories.create')
@include('admin.categories.edit')
@include('admin.categories.show')


@endsection

@section('footer')
<script type="text/javascript" src="{{ asset('admin_assets/js/custom_category.js') }}"></script>
@endsection