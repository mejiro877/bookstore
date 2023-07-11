<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        return view('ecsite.cart');
    }

    public function cartlist()
    {
        return view('ecsite.addcart');
    }

    public function check(Request $request)
    {
        if ($request->input('remove')) {
            $array = session('array');
            $selectlist = $request->input('selectProductCode');
            // チェックボックスにチェックが入っているか確認
            if (!isset($selectlist)) {
                return redirect()->back()->with('cnt_ng', '取り消し対象の商品を選択してください。');
            }
            foreach ($selectlist as $select) {
                unset($array[$select]);
            }
            session(['array' => $array]);
            return redirect()->back();
        } elseif ($request->input('delete')) {
            session()->forget('array');
            return view('ecsite.menu');
        }

        $array = session('array');
        $sum = 0;
        foreach ($array as $key => $value) {
            if (is_null($request->input($key)) || $request->input($key) < 1 || $request->input($key) > 999) {
                return redirect()->back()->with('cnt_ng', '購入数は1～999の数値で入力してください。');
            }

            $cnt = DB::table('online_product')->select('STOCK_COUNT')->where('PRODUCT_CODE', '=', $key)->first()->STOCK_COUNT;

            $array[$key]['count'] = $request->input($key);
            if ($array[$key]['count'] > $cnt) {
                return redirect()->back()->with('cnt_ng', '在庫が足りません。購入数を変更してください。');
            }

            $price = $array[$key]['unit'];
            $count = $array[$key]['count'];
            $sum = $sum + $price * $count;
        }

        $tax = $sum * 0.10;
        $total = $sum + $tax;
        session(['sum' => $sum]);
        session(['tax' => $tax]);
        session(['total' => $total]);
        session(['array' => $array]);
        return redirect('ecsite/buycheck');
    }

    public function addcart(Request $request)
    {
        // チェックボックスにチェックを入れた商品コードの配列
        $selectlist = $request->input('selectProductCode');
        $selectcnt = array();

        // チェックボックスにチェックが入っているか確認
        if (!isset($selectlist)) {
            return redirect()->back()->with('cnt_ng', '商品を選択してください。');
        }

        // key:商品コード、value:個数の連想配列を作成して、個数のバリデーションチェック
        foreach ($selectlist as $select) {
            $selectcnt[$select] = $request->input($select);
            $cnt = DB::table('online_product')->select('STOCK_COUNT')->where('PRODUCT_CODE', '=', $select)->first()->STOCK_COUNT;

            if (is_null($selectcnt[$select]) || $selectcnt[$select] < 1 || $selectcnt[$select] > 999) {
                return redirect()->back()->with('cnt_ng', '購入数は1～999の数値で入力してください。');
            }
            if (isset(session('array')[$select])) {
                if (session('array')[$select]['count'] + $selectcnt[$select] > $cnt) {
                    return redirect()->back()->with('cnt_ng', '在庫が足りません。購入数を変更してください。');
                }
            }
            if ($selectcnt[$select] > $cnt) {
                return redirect()->back()->with('cnt_ng', '在庫が足りません。購入数を変更してください。');
            }
        }

        $cn = 0;
        foreach ($selectcnt as $key => $value) {
            $pro = DB::table('online_product')
                ->where('PRODUCT_CODE', '=', $key)
                ->first();
            if (session()->has('array')) {
                $array = session('array');
            }
            $array[$key]['product_code'] = $pro->PRODUCT_CODE;
            $array[$key]['name'] = $pro->PRODUCT_NAME;
            $array[$key]['maker'] = $pro->MAKER;
            $array[$key]['unit'] = $pro->UNIT_PRICE;
            if (isset(session('array')[$key])) {
                if (session('array')[$key] = $pro->PRODUCT_CODE) {

                    $array[$key]['count'] = $value + session('array')[$key]['count'];
                } else {
                    $array[$key]['count'] = $value;
                }
            } else {
                $array[$key]['count'] = $value;
            }
            session(['array' => $array]);
        }

        // カートに必要な情報をセッションに保存
        ksort($array);
        session(['array' => $array]);
        return view('ecsite.addcart');
    }

    public function buycheck()
    {
        return view('ecsite.buycheck');
    }

    public function buyend()
    {
        if (!session()->has('member_no')) {
            return redirect('ecsite/error');
        }
        return view('ecsite.buyend');
    }

    public function buy(Request $request)
    {
        if ($request->input('delete')) {
            session()->forget('array');
            return view('ecsite.menu');
        }

        if (!session()->has('member_no')) {
            return redirect('ecsite/login');
        }

        $array = session('array');
        foreach ($array as $key => $value) {
            $delete_flg = DB::table('online_product')->select('DELETE_FLG')->where('PRODUCT_CODE', '=', $key)->first()->DELETE_FLG;

            if ($delete_flg != 0) {
                $cnt_ng = $key . 'の取り扱いは終了されたため購入できません。';
                return view('ecsite.buycheck', compact('cnt_ng'));
            }
        }

        try {
            DB::transaction(function () {
                $member_no = session('member_no');
                $total = session('total');
                $tax = session('tax');
                $ndate = now()->format('Y-m-d');

                $array = session('array');

                $list_no = DB::table('online_order_list')->max('LIST_NO');
                $collect_no = DB::table('online_order')->max('COLLECT_NO');
                $order_no = DB::table('online_order')->max('ORDER_NO');
                if (is_null($collect_no)) {
                    $collect_no = 0;
                }
                if (is_null($order_no)) {
                    $order_no = 0;
                }
                if (is_null($list_no)) {
                    $list_no = 0;
                }
                $collect_no = $collect_no + 1;
                $order_no = $order_no + 1;

                foreach ($array as $key => $value) {
                    $list_no = $list_no + 1;
                    DB::table('online_order_list')
                        ->insert(['LIST_NO' => $list_no, 'COLLECT_NO' => $collect_no, 'PRODUCT_CODE' => $key, 'ORDER_COUNT' => $value['count'], 'ORDER_PRICE' => $value['unit']]);

                    $cnt = DB::table('online_product')
                        ->where('PRODUCT_CODE', '=', $key)
                        ->first()->STOCK_COUNT;

                    $cnt = $cnt - $value['count'];

                    DB::table('online_product')
                        ->where('PRODUCT_CODE', $key)
                        ->update(['STOCK_COUNT' => $cnt]);
                }

                DB::table('online_order')
                    ->insert(['ORDER_NO' => $order_no, 'MEMBER_NO' => $member_no, 'TOTAL_MONEY' => $total, 'TOTAL_TAX' => $tax, 'ORDER_DATE' => $ndate, 'COLLECT_NO' => $collect_no]);

            });
        } catch (Throwable $e) {
            DB::rollBack();
        }

        session()->forget('array');
        return redirect('ecsite/buyend');
    }
}
