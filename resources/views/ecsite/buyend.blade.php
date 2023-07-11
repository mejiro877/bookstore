@extends('layouts.app')

@section('title', '注文結果')

@section('content')
<div class="container">
	<div class="row">
		<div class="mx-auto">
			<label>注文が完了しました。</label>
			<br>
			<input type="button" value="メニューへ戻る" onclick="location.href='{{ route('ecsite.menu') }}'">
		</div>
	</div>
</div>
@endsection
