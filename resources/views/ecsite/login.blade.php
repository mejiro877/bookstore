@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="mx-auto">
  <div class="row text-center">
    <div class="mx-auto">
      <a href="{{ route('ecsite.register') }}">新規会員の方はこちら</a>
    </div>
  </div>
  <div class="row">
    <form action="{{ route('ecsite.login') }}" method="POST">
      @csrf
      @isset($loginFail)
        <lavel><font color=#ff0000>{{ $loginFail }}</font></lavel>
      @endisset
      <div class="py-2" style="background-color: pink;width:350px;">
        <div class="row">
          <div class="col-4 text-right">
            <label for="member_no">会員NO</label>
          </div>
          <div class="col-6">
            <input type="text" name="member_no" id="member_no" class="@error('member_no') is-invalid @enderror">
            @error('member_no')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>

        <div class="row">
          <div class="col-4 text-right">
            <label for="password">パスワード</label>
          </div>
          <div class="col-6">
            <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror">
            @error('password')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </div>
        </div>
      </div>
      <div class="row">
        <div class="mx-auto" style="margin-top: 5px;">
          <input type="submit" value="ログイン"> <input type="reset" value="クリア">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
