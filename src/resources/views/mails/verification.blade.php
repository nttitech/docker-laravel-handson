@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">メールアドレス認証</div>

                <div class="card-body">
                    <a href='{{$auth_url}}'>こちらのリンク</a>をクリックして、メールを認証してください。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
