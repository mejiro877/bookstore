@extends('layouts.app')

@section('title', '商品詳細')

@section('content')
<style>
		th {
			text-align: center;
		}
</style>
<div class="float-left">
	<label>●商品詳細</label>

	<!-- 注文者検索フォーム -->
	<form action="{{ route('ecsite.productdetail', ['id' => $id]) }}" method="POST">
		@csrf
		<div class="container">
			<table border="1">
				<tr>
					<th>商品名</th>
					<td>{{ $name }}</td>
				</tr>
				<tr>
					<th>画像</th>
					<td align="center"><img src="/img/{{ $picture_name }}.png"></td>
				</tr>
				<tr>
					<th>商品説明</th>
					<td id="memo">{{ $memo }}</td>
				</tr>
				<tr>
					<th>価格</th>
					<td align="right">￥{{ number_format($price) }}</td>
				</tr>
				<tr>
					<th>購入数</th>
					<td align="right"><input type="text" name="count" />個</td>
				</tr>
			</table>
			<label><font color=#ff0000>{{ session('cnt_ng') }}</font></label>
		</div>
		<div style="float: right;">
			<input type="submit" value="お買い物かごに入れる">
			<input type="button" value="戻る" onclick="location.href='{{ route('ecsite.product') }}'">
		</div>
	</form>
</div>
@endsection
