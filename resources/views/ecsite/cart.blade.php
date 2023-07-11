@extends('layouts.app')

@section('title', 'お買い物かご')

@section('content')
<div class="float-left">
	<label>●商品一覧</label>
	<form action="{{ route('ecsite.cart') }}" method="POST">
		@csrf
		<table border="1">
			<tr align="center">
				<th style="width: 50px;">選択</th>
				<th>商品コード</th>
				<th>商品名</th>
				<th>販売元</th>
				<th>価格</th>
				<th>購入数</th>
			</tr>
			@if(session()->has('array'))
				@foreach(session()->get('array') as $ar)
						<tr>
							<td align="center"><input type="checkbox" name="selectProductCode[]" value="{{ $ar['product_code'] }}"></td>
							<td align="center">{{ $ar['product_code'] }}</td>
							<td>{{ $ar['name'] }}</td>
							<td>{{ $ar['maker'] }}</td>
							<td align="right">￥{{ number_format($ar['unit']) }}</td>
							<td><input type="text" name="{{ $ar['product_code'] }}" value="{{ $ar['count'] }}"></td>
						</tr>
				@endforeach
			@endif
		</table>
		<label><font color=#ff0000>{{ session('cnt_ng') }}</font></label>
		<br>
		@if(session()->has('array'))
		<input type="submit" name="remove" value="取り消し">
		<input type="submit" name="delete" value="買い物をやめる">
		<input type="submit" name="order" value="注文する" onclick="goShopping();">
		@endif
		<input type="button" value="メニューへ" onclick="location.href='{{ route('ecsite.menu') }}'">
	</form>
</div>
@endsection
