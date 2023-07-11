<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->input('search')) {
            $this->validate($request, [
                // 'price_max' => 'nullable|numeric|positive_integer|gt:price_min',//price_minがnullの時もチェック
                'price_max' => 'nullable|numeric|positive_integer',
                'price_min' => 'nullable|numeric|positive_integer',
            ]);

            //検索フォーム
            $category = DB::table('online_category')
                ->select('CTGR_ID', 'NAME')
                ->get();

            $categoryId = $request->input('categoryId');
            $productName = $request->input('productName');
            $maker = $request->input('maker');
            $priceMax = $request->input('price_max');
            $priceMin = $request->input('price_min');

            if (isset($priceMax) && isset($priceMin)) {
                if ($priceMax < $priceMin) {
                    $no_product = '金額上限は金額下限より大きい値を入力してください。';
                    return redirect()->back()->with('updown', '金額上限は金額下限より大きい値を入力してください。');
                }
            }

            $query = DB::table('online_product')
                ->where('DELETE_FLG', '=', 0);

            if (!empty($categoryId)) {
                $query->where('CATEGORY_ID', '=', $categoryId);
            }
            if (!empty($productName)) {
                $query->where('PRODUCT_NAME', 'like', '%' . $productName . '%');
            }
            if (!empty($maker)) {
                $query->where('MAKER', 'like', '%' . $maker . '%');
            }

            if (!empty($priceMax) && !empty($priceMin)) {
                $query->whereBetween('UNIT_PRICE', [$priceMin, $priceMax]);
            } elseif (!empty($priceMax)) {
                $query->where('UNIT_PRICE', '<=', $priceMax);
            } elseif (!empty($priceMin)) {
                $query->where('UNIT_PRICE', '>=', $priceMin);
            }

            if (is_null($query->first())) {
                $no_product = '条件に該当する商品は０件です。';
                return view('ecsite.product', compact('category', 'no_product', 'productName', 'maker', 'priceMax', 'priceMin', 'request'));
            }

            $result = $query->paginate(10);
            return view('ecsite.product', compact('category', 'result', 'productName', 'maker', 'priceMax', 'priceMin', 'request'));
        }
        //検索フォーム
        $category = DB::table('online_category')
            ->select('CTGR_ID', 'NAME')
            ->get();

        return view('ecsite.product', compact('category'));
    }

    public function detail($id)
    {
        $pro = DB::table('online_product')
            ->where('PRODUCT_CODE', '=', $id)
            ->first();
        $name = $pro->PRODUCT_NAME;
        $picture_name = $pro->PICTURE_NAME;
        $memo = $pro->MEMO;
        $price = $pro->UNIT_PRICE;
        return view('ecsite.productdetail', compact('id', 'name', 'picture_name', 'memo', 'price'));
    }

    public function detailbuy(Request $request)
    {
        // key:商品コード、value:個数の連想配列を作成して、個数のバリデーションチェック
        $select_cnt = $request->input('count');
        $keys = parse_url(url()->previous());
        $path = explode("/", $keys['path']);
        $id = end($path);
        $cnt = DB::table('online_product')->select('STOCK_COUNT')->where('PRODUCT_CODE', '=', $id)->first()->STOCK_COUNT;

        if (is_null($select_cnt) || $select_cnt < 1 || $select_cnt > 999) {
            return redirect()->back()->with('cnt_ng', '購入数は1～999の数値で入力してください。');
        }
        if (isset(session('array')[$id])) {
            if (session('array')[$id]['count'] + $select_cnt > $cnt) {
                return redirect()->back()->with('cnt_ng', '在庫が足りません。購入数を変更してください。');
            }
        }
        if ($select_cnt > $cnt) {
            return redirect()->back()->with('cnt_ng', '在庫が足りません。購入数を変更してください。');
        }

        $cn = 0;

        $pro = DB::table('online_product')
            ->where('PRODUCT_CODE', '=', $id)
            ->first();
        if (session()->has('array')) {
            $array = session('array');
        }
        $array[$id]['product_code'] = $pro->PRODUCT_CODE;
        $array[$id]['name'] = $pro->PRODUCT_NAME;
        $array[$id]['maker'] = $pro->MAKER;
        $array[$id]['unit'] = $pro->UNIT_PRICE;
        if (isset(session('array')[$id])) {
            if (session('array')[$id] = $pro->PRODUCT_CODE) {

                $array[$id]['count'] = $select_cnt + session('array')[$id]['count'];
            } else {
                $array[$id]['count'] = $select_cnt;
            }
        } else {
            $array[$id]['count'] = $select_cnt;

        }
        // カートに必要な情報をセッションに保存
        ksort($array);
        session(['array' => $array]);
        return redirect('ecsite/addcart');
    }
}
