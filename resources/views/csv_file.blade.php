@extends('layouts.app')

@section('content')
    <h1>CSV File Challenge</h1>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
            <strong>{{ $message }}</strong>
        </div>
    @endif

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Alert!</strong> File Upload Failed.
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h4>No File to Upload?</h4>
    <a href="/csv/generate">Generate One Here!</a>

    <h4>Have a file to upload?</h4>
    <form action="/csv/upload" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" id="fileUpload" name="filename">
        <input type="submit">
    </form>
@endsection
