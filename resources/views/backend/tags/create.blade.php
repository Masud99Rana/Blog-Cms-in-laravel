@extends('layouts.backend.main')

@section('title', 'MyBlog | Add new tag')

@section('content')

    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          tags
          <small>Add new tag</small>
        </h1>
        <ol class="breadcrumb">
          <li>
              <a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Dashboard</a>
          </li>
          <li><a href="{{ route('backend.tags.index') }}">Tags</a></li>
          <li class="active">Add new</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="row">
              {!! Form::model($tag, [
                  'method' => 'POST',
                  'route'  => 'backend.tags.store',
                  'id' => 'tag-form'
              ]) !!}

              @include('backend.tags.form')

            {!! Form::close() !!}
          </div>
        <!-- ./row -->
      </section>
      <!-- /.content -->
    </div>

@endsection

@include('backend.tags.script')
