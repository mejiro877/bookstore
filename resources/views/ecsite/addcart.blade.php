@extends('layouts.app')

@section('title', '商品登録完了')

@section('content')
<div class="float-left">
	<label>以下の商品をお買い物かごに登録しました。</label>
	<br>
	<!-- 注文内訳 -->
	<label>●商品一覧</label>
	<table border="1">
		<tr align="center">
			<th>商品コード</th>
			<th>商品名</th>
			<th>販売元</th>
			<th>価格</th>
			<th>購入数</th>
		</tr>
		@if(session()->has('array'))
			@foreach(session()->get('array') as $ar)
				<tr>
					<td align="center">{{ $ar['product_code'] }}</td>
					<td>{{ $ar['name'] }}</td>
					<td>{{ $ar['maker'] }}</td>
					<td align="right">￥{{ number_format($ar['unit']) }}</td>
					<td align="center">{{ $ar['count'] }}</td>
				</tr>
			@endforeach
		@endif
	</table>
	<br>
	<input type="button" value="お買いものかご" onclick="location.href='{{ route('ecsite.cart') }}'">
	<input type="button" value="戻る" onclick="location.href='{{ route('ecsite.product') }}'">
</div>
@endsection
