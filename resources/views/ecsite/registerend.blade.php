@extends('layouts.app')

@section('title', '会員登録完了')

@section('content')
<div class="mx-auto">
	<div class="row">
			<label>会員登録が完了しました。<br>
			あなたの会員NOは {{ session()->get('members') }}です。
			</label>
	</div>
	<div class="row">
			<div class="mx-auto">
				<input type="button" value="メニューへ" onClick="location.href='{{ route('ecsite.menu') }}'">
			</div>
	</div>
</div>
@endsection
