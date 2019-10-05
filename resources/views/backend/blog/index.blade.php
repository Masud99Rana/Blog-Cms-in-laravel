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
                  <a href="{{ route('backend.blog.create') }}" class="btn btn-success">Add new</a>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body ">

                @if ($posts->count())
                  <div class="alert alert-danger">
                    <strong>No record found</strong>
                  </div>
                @else
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <td width="80">Action</td>
                        <td>Title</td>
                        <td>Author</td>
                        <td>Category</td>
                        <td>Date</td>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)                    
                      <tr>
                        <td>
                          <a href="{{ route('backend.blog.edit',$post->id) }}" class="btn btn-xs btn-default">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a href="{{ route('backend.blog.destroy', $post->id) }}" class="btn btn-xs btn-danger">
                            <i class="fa fa-times"></i>
                          </a>
                        </td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->author->name }} </td>
                        <td>{{ $post->category->title }}</td>
                        <td width="170">
                          <abbr title="{{ $post->dateFormatted(true) }}">{{ $post->dateFormatted() }}</abbr>
                          {!! $post->publicationLabel() !!}
                        </td>
                      </tr>
                    @endforeach
                    </tbody>

                  </table>
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
