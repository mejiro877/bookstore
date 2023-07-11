@extends('layouts.app')

@section('title', 'お買い物確認')

@section('content')
<div class="float-left">
	<label>●商品一覧</label>
	<form action="{{ route('ecsite.buycheck') }}" method="POST">
		@csrf
		<table border="1">
			<tr align="center">
				<th>商品コード</th>
				<th>商品名</th>
				<th>販売元</th>
				<th>価格</th>
				<th>購入数</th>
			</tr>
			@foreach(session()->get('array') as $ar)
				<tr>
					<td align="center">{{ $ar['product_code'] }}</td>
					<td>{{ $ar['name'] }}</td>
					<td>{{ $ar['maker'] }}</td>
					<td align="right">￥{{ number_format($ar['unit']) }}</td>
					<td align="center">{{ $ar['count'] }}</td>
				</tr>
			@endforeach
		</table>
		<br>
		<label>●料金</label>
		<table border="1" style="width: 300px;">
			<tr align="right">
				<th>小計</th>
				<td>￥{{ number_format(session()->get('sum')) }}</td>
			</tr>
			<tr align="right">
				<th>消費税</th>
				<td>￥{{ number_format(session()->get('tax')) }}</td>
			</tr>
			<tr align="right">
				<th>合計金額</th>
				<td>￥{{ number_format(session()->get('total')) }}</td>
			</tr>
		</table>
		@if(isset($cnt_ng))
		<label><font color=#ff0000>{{ $cnt_ng }}</font></label>
		@endif(isset($cnt_ng))
		<br>
		<input type="submit" name="delete" value="買い物をやめる">
		<input type="submit" name="order" value="注文する">
		<input type="button" value="戻る" onclick="location.href=' {{ route('ecsite.cart') }}'">
	</form>
</div>
@endsection
