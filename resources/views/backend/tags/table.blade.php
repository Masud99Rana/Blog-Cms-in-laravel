<table class="table table-bordered">
    <thead>
        <tr>
            <td width="80">Action</td>
            <td>Tag Name</td>
            <td width="120">Post Count</td>
        </tr>
    </thead>
    <tbody>
        @foreach($tags as $tag)

            <tr>
                <td>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['backend.tags.destroy', $tag->id]]) !!}
                        <a href="{{ route('backend.tags.edit', $tag->id) }}" class="btn btn-xs btn-default">
                            <i class="fa fa-edit"></i>
                        </a>
                        {{-- @if($tag->id == config('cms.default_tag_id')) --}}
                            {{-- <button onclick="return false" type="submit" class="btn btn-xs btn-danger disabled">
                                <i class="fa fa-times"></i>
                            </button>
                        @else --}}
                            <button onclick="return confirm('Are you sure?');" type="submit" class="btn btn-xs btn-danger">
                                <i class="fa fa-times"></i>
                            </button>
                        {{-- @endif --}}
                    {!! Form::close() !!}
                </td>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->posts->count() }}</td>
            </tr>

        @endforeach
    </tbody>
</table>
