@extends('layouts.app')

@section('title', 'メニュー')

@section('content')
<div class="mx-auto">
	<div class="row">
		<label>予期せぬエラーが発生しました。管理者にお問合せください。</label>
	</div>
	<div class="row">
		<div class="mx-auto">
			<input type="button" name="error" value="メニューへ" onclick="location.href='{{ route('ecsite.menu') }}'">
		</div>
	</div>
</div>
@endsection
