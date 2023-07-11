@extends('layouts.app')

@section('title', 'メニュー')

@section('content')
<div class="mx-auto" style="background-color: pink;width:480px;">
	@unless(session()->has('member_no'))
		<div class="row">
			<div class="col-5 text-right">
				<a href="{{ route('ecsite.register') }}">新規会員登録</a>
			</div>
			<div class="col-6">
				会員情報の登録を行います。
			</div>
		</div>
	@endunless
	<div class="row">
		<div class="col-5 text-right">
			<a href="{{ route('ecsite.product') }}">商品検索</a>
		</div>
		<div class="col-6">
			購入する商品の検索を行います。
		</div>
	</div>
	<div class="row">
		<div class="col-5 text-right">
			<a href="{{ route('ecsite.cart') }}">お買い物かご</a>
		</div>
		<div class="col-6">
			商品の注文を行います。
		</div>
	</div>
</div>
</div>
<br>
<div class="row">
	<div class="mx-auto">
		@if(session()->has('member_no'))
			<input type="button" name="logout" value="ログアウト" onclick="location.href='{{ route('ecsite.logout') }}'">
		@else
			<input type="button" name="login" value="ログイン" onclick="location.href='{{ route('ecsite.login') }}'">
		@endif
	</div>
</div>
@endsection
