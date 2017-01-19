@extends('admin.layouts.master')

@section('title', 'List All News')

@section('page-title', 'List All News')

@section('breadcrumb')
<li><a href="{{ route('news.index') }}">News</a></li>
<li class="active">All News</a></li>
@endsection

@section('content')

<div class="row">
    <div class="col-xs-12">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">List of all news</h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th class="col-sm-2 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $snews)
                            <tr>
                                <td>{{ $snews->title }}</td>
                                <td>{{ $snews->categoryString() }}</td>
                                <td>{!! $snews->statusString() !!}</td>
                                <td class="text-center">
                                    {!! Form::open(['route' => ['news.destroy', $snews->id], 'method' => 'DELETE', 'data-confirm' => 'Are you sure you want to delete this news?']) !!}
                                        <a data-toggle="tooltip" title="Edit" href="{{ route('news.edit', $snews->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
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
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $(".table").DataTable();
    });
</script>
@endsection