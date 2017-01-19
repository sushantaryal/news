@extends('admin.layouts.master')

@section('title', 'Add News')

@section('page-title', 'Add News')

@section('breadcrumb')
<li><a href="{{ route('news.index') }}">News</a></li>
<li class="active">Add News</a></li>
@endsection

@section('content')

<div class="row">
    {!! Form::open(['route' => 'news.store', 'class' => 'news-form', 'files' => true]) !!}
    <div class="col-sm-12 col-md-8">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">New news</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('title', 'Title') !!}
                    {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter title here']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('description', 'Description') !!}
                    {!! Form::textarea('description', null, ['class' => 'form-control summernote', 'placeholder' => 'Enter title here']) !!}
                </div>
            </div>
            <div class="box-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-info pull-right']) !!}
            </div>
        </div>

    </div>

    <div class="col-sm-12 col-md-4">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Categories</h3>
            </div>

            <div class="box-body">
                {!! Form::select('categories[]', $categories, null, ['id' => 'categories', 'class' => 'form-control', 'multiple' => true, 'data-placeholder' => 'Select categories']) !!}
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Image</h3>
            </div>

            <div class="box-body">
                <div id="image-preview">
                    {!! Form::label('image-upload', 'Choose Image', ['id' => 'image-label']) !!}
                    {!! Form::file('image', ['id' => 'image-upload']) !!}
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Publish</h3>
            </div>

            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('status', 'Status', ['class' => 'col-md-2 contol-label']) !!}

                    <div class="col-md-10">
                        <label class="radio-inline">
                            {!! Form::radio('status', 1, true) !!} Publish
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('status', 0) !!} Unpublish
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {!! Form::close() !!}

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#categories").select2();

        $('.news-form').validate({
            rules: {
                title: 'required'
            }
        });
    });
</script>
@endsection