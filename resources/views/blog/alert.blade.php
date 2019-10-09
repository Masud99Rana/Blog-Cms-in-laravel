@isset ($categoryName)
    <div class="alert alert-info">
        <p>Category: <strong> {{$categoryName}} </strong></p>
    </div>
@endisset

@isset ($authorName)
    <div class="alert alert-info">
        <p>Author Name: <strong> {{$authorName}} </strong></p>
    </div>
@endisset

@if ($term= request('term'))
    <div class="alert alert-info">
        <p>Search Results for: <strong> {{$term}} </strong></p>
    </div>
@endisset