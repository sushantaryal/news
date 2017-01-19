@extends('admin.layouts.master')

@section('title', 'News Category')

@section('page-title', 'News Category')

@section('breadcrumb')
<li><a href="{{ route('news.index') }}">News</a></li>
<li class="active">News Category</a></li>
@endsection

@section('content')

<div class="row">
    
    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add news category</h3>
            </div>

            {!! Form::open(['route' => 'newscategories.store', 'class' => 'news-category-form']) !!}
                <div class="box-body">
                    <div class="form-group">
                        {!! Form::label('title', 'Title') !!}
                        {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title here']) !!}
                    </div>
                </div>
                <div class="box-footer">
                    {!! Form::submit('Save', ['class' => 'btn btn-info pull-right']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Categories</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="col-sm-4 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td class="text-center">
                                    {!! Form::open(['route' => ['newscategories.destroy', $category->id], 'method' => 'DELETE', 'data-confirm' => 'Are you sure you want to delete this news category?']) !!}
                                        <button type="button" class="btn btn-primary btn-sm category-edit" data-toggle="modal" data-target-id="{{ $category->id }}" data-target="#edit-modal"><i class="fa fa-edit "></i></button>

                                        <button data-toggle="tooltip" title="Delete" type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Category</h4>
				</div>
				<div class="modal-body">					
				</div>
			</div>
		</div>
	</div>

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(".table").DataTable();

        $('.news-category-form').validate({
            rules: {
                title: 'required'
            }
        });

        $("#edit-modal").on("show.bs.modal", function(e) {
			var id = $(e.relatedTarget).data('target-id');
			// $('.category-modal').modal('hide');
			$.get('{{ url('admin/newscategories') }}/' + id + '/edit', function( data ) {
				$("#edit-modal .modal-body").html(data);
			});
		});

    });
</script>
@endsection