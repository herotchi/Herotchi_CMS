@extends('admin.layouts.app')
@section('title', '管理画面/TOP')

@section('content')
test
{{ var_dump(Auth::user()); }}
@endsection