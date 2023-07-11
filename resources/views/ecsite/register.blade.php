@extends('layouts.app')

@section('title', '会員登録')

@section('content')
<style>
		th {
			text-align: right;
		}
</style>
<div class="float-left">
	<div class="row">
		<label>会員情報を入力して下さい。</label>
	</div>
	<div class="row">
		<label>●会員情報</label>
	</div>
	<div class="row">
		<form action="{{ route('ecsite.register') }}" method="POST">
			@csrf
			<table border="1">
				<tr>
					<th><label for="name">氏名</label></th>
					<td>
						<input type="text" name="name" id="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror">
						@error('name')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
				<tr>
					<th><label for="password">パスワード</label></th>
					<td>
						<input type="password" name="password" id="password" value="{{ old('password') }}" class="@error('password') is-invalid @enderror">
						@error('password')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
				<tr>
					<th><label for="password_confirmation">パスワード<br>(確認用)
					</label></th>
					<td>
						<input type="password" name="password_confirmation" id="password_confirmation" value="{{ old('password_confirmation') }}" class="@error('password_confirmation') is-invalid @enderror">
						@error('password_confirmation')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
				<tr>
					<th><label for="age">年齢</label></th>
					<td>
						<input type="text" name="age" id="age" value="{{ old('age') }}" class="@error('age') is-invalid @enderror">
						@error('age')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
				<tr>
					<th><label for="sex">性別</label></th>
					<td><select name="sex" id="sex">
							<option value="M"  @if(old('sex') == "M") selected @endif>男性</option>
							<option value="F" @if(old('sex') == "F") selected @endif>女性</option>
					</select> <form:errors cssClass="check" path="registerFormModel.sex" id="sex" /></td>
				</tr>
				<tr>
					<th><label for="zip">郵便番号</label></th>
					<td>
						<input type="text" name="zip" id="zip" value="{{ old('zip') }}" class="@error('zip') is-invalid @enderror">
						@error('zip')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
				<tr>
					<th><label for="address">住所</label></th>
					<td>
						<textarea cols="50" name="address" id="address" class="@error('address') is-invalid @enderror">{{ old('address') }}</textarea>
						@error('address')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
				<tr>
					<th><label for="tel">電話番号</label></th>
					<td>
						<input type="text" name="tel" id="tel" value="{{ old('tel') }}" class="@error('tel') is-invalid @enderror">
						@error('tel')
							<span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
							</span>
						@enderror
					</td>
				</tr>
			</table>
			<div class="mt-2">
				<input type="submit" value="確認">
				<input type="button" value="戻る" onclick="location.href='{{ route('ecsite.menu') }}'">
				<input type="button" value="クリア" onClick="clearFormAll(); " />
			</div>
		</form>
	</div>
</div>
@endsection
