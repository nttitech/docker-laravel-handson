@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">パスワード再設定url</div>

                <div class="card-body">
                    <a href='{{$reset_url}}'>こちらのリンク</a>をクリックして、パスワードを再設定してください。
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
