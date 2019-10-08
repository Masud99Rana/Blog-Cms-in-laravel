@extends('layouts.backend.main')



@section('title','MyBlog | Dashboard')

@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Display All blog posts
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Dashboard</a> 
        </li>
        <li><a href="{{ route('backend.blog.index') }}">Blog</a></li>
        <li class="active">All Posts</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <div class="pull-left">
                  <a href="{{ route('backend.blog.create') }}" class="btn btn-success"> <i class="fa fa-plus"></i> Add new</a>
                </div>
                <div class="pull-right" style="padding: 7px 0">
                  <a href="?status=all">All</a>|
                  <a href="?status=trash">Trash</a>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body ">

                @include('backend.blog.message')

                @if (! $posts->count())
                  <div class="alert alert-danger">
                    <strong>No record found</strong>
                  </div>
                @else
                  @if($onlyTrashed)
                    @include('backend.blog.table-trash')
                  @else
                    @include('backend.blog.table')
                  @endif
                @endif
              </div>
              <div class="box-footer clearfix">
                <div class="pull-left">
                  <ul class="pagination no-margin">
                    {{ $posts->render() }}
                  </ul>
                </div>
                <div class="pull-right">
                  @php
                    $postCount = $posts->count();
                  @endphp
                  <small>{{ $postCount }} of {{ $allPostCount }} {{ str_plural('Item', $allPostCount) }}</small>
                </div>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
        </div>
      <!-- ./row -->
    </section>
    <!-- /.content -->
  </div>
@endsection

@section('script')
  <script type="text/javascript">
      $('ul.pagination').addClass('no-margin pagination-sm');
  </script>
@endsection
