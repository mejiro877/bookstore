@extends('layouts.app')

@section('title', '商品検索')

@section('content')
<div class="float-left">
	<label>検索条件を入力して下さい。</label>

		<!-- 注文者検索フォーム -->
		<form action="{{ route('ecsite.product') }}" method="GET">
			@csrf
			<table border="1">
				<tr>
					<th>カテゴリ</th>
					<td>
						<select name="categoryId">
							<option value="">全て</option>
							<!--  ControllerからcategoryListを受け取る -->
							@foreach($category as $cate)
							@if((!empty($request->categoryId) && $request->categoryId == $cate->CTGR_ID) || old('categoryId') == $cate->CTGR_ID )
							<option value = "{{ $cate->CTGR_ID }}" selected>{{ $cate->NAME }}</option>
							@else
							<option value = "{{ $cate->CTGR_ID }}">{{ $cate->NAME }}</option>
							@endif
							@endforeach
						</select>
					</td>
				</tr>
				<tr>
					<th>商品名</th>
					<td>
						<input type="text" name="productName" value="{{ $productName ?? old('productName') }}" />
					</td>
				</tr>
				<tr>
					<th>販売元</th>
					<td>
						<input type="text" name="maker" value="{{ $maker ?? old('maker') }}" />
					</td>
				</tr>
				<tr>
					<th>金額上限</th>
					<td>
						<input type="text" id="price_max" name="price_max" value="{{ $priceMax ?? old('price_max') }}" class="@error('price_max') is-invalid @enderror"/>
						@error('price_max')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
						<label><font color=#ff0000>{{ session('updown') }}</font></label>
					</td>
				</tr>
				<tr>
					<th>金額下限</th>
					<td>
						<input type="text" id="price_min" name="price_min" value="{{ $priceMin ?? old('price_min') }}" class="@error('price_min') is-invalid @enderror"/>
						@error('price_min')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
			</table>
			<div class="mt-2">
				<input type="submit" name="search" value="検索">
				<input type="button" value="戻る" onclick="location.href='{{ route('ecsite.menu') }}'">
				<input type="button" value="クリア" onclick="clearFormAll();">
			</div>
		</form>

		<!-- 注文者検索結果/選択フォーム -->
		<div class="mt-4">
			<label>●商品一覧</label>
		</div>
		@isset($no_product)
			{{ $no_product }}
		@endisset
		@isset($result)
			{{ $result->appends(request()->query())->links('vendor/pagination/pagination_view') }}
		@endisset
		<form action="{{ route('ecsite.addcart') }}" method="POST">
			@csrf
		@isset($result)
			<table border="1">
				<thead>
				<tr align="center">
					<th style="width: 50px;">選択</th>
					<th>商品コード</th>
					<th>商品名</th>
					<th>販売元</th>
					<th>金額(単価)</th>
					<th>メモ</th>
					<th>購入数</th>
				</tr>
				</thead>
				<tbody>
					<tr>
					@foreach($result as $rs)
						<td align="center"><input type="checkbox" name="selectProductCode[]" value="{{ $rs->PRODUCT_CODE }}"></td>
						<td align="center">{{ $rs->PRODUCT_CODE }}</td>
						<td><a href="{{ route('ecsite.productdetail', ['id' => $rs->PRODUCT_CODE]) }}">{{ $rs->PRODUCT_NAME }}</a></td>
						<td>{{ $rs->MAKER }}</td>
						<td align="right">￥{{ number_format($rs->UNIT_PRICE) }}</td>
						<td id="memo">{{ Str::limit($rs->MEMO, 20, '...') }}</td>
						<td><input type="text" name="{{ $rs->PRODUCT_CODE }}"></td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<label><font color=#ff0000>{{ session('cnt_ng') }}</font></label>
			<br>
			<input type="submit" value="お買い物かごに入れる">
		</form>
		@endisset
</div>
@endsection
