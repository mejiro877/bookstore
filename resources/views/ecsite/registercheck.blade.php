@extends('layouts.app')

@section('title', '会員登録確認')

@section('content')
<style>
		th {
			text-align: right;
		}
</style>
<div class="float-left">
	<div class="row">
		<label>この内容で登録しますか？</label>
	</div>
	<div class="row">
		<label>●会員情報</label>
	</div>
	<div class="row">
		<form action="{{ route('ecsite.registercheck') }}" method="POST">
			@csrf
			<div>
				<input type="hidden" name="member_no" value="${registerFormModel.member_no}">
				<input type="hidden" value="${registerFormModel.password}" name="password" />
			</div>
			<table border="1">
				<tr>
					<th><label for="name">氏名</label></th>
					<td>
						{{ $input["name"] }}
					</td>
				</tr>
				<tr>
					<th><label for="age">年齢</label></th>
					<td>
						{{ $input["age"] }}
					</td>
				</tr>
				<tr>
					<th><label for="sex">性別</label></th>
					<td>
						@if($input["sex"] === 'M')
						男性
						@else
						女性
						@endif
					</td>
				</tr>
				<tr>
					<th><label for="zip">郵便番号</label></th>
					<td>
						{{ $input["zip"] }}
					</td>
				</tr>
				<tr>
					<th><label for="address">住所</label></th>
					<td>
						{{ $input["address"] }}
					</td>
				</tr>
				<tr>
					<th><label for="tel">電話番号</label></th>
					<td>
						{{ $input["tel"] }}
					</td>
				</tr>
			</table>
			<div class="mt-2">
				<input type="submit" value="登録">
				<input type="button" value="戻る" onclick="history.back()">
			</div>
		</form>
	</div>
</div>
@endsection
