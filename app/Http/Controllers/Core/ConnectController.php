<?php

namespace App\Http\Controllers\Core;

use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Configs;
use App\Frame;
use App\Page;


/**
 * コア用の基底クラス
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category ユーザープラグイン
 * @package Contoroller
 */
class ConnectController extends Controller
{

    /**
     *  カレントページ
     */
    public $current_page = null;

    /**
     *  コンストラクタ
     */
    function __construct()
    {
        $this->current_page = $this->getCurrentPage();
    }

    /**
     *  ページのレイアウト情報
     */
    public function getLayoutsInfo()
    {
        if (empty($this->current_page)) {
            return null;
        }

        // ページの系統取得
        $page_tree = $this->getPageTree($this->current_page->id);

        // ページのレイアウト取得
        $layout_array = explode('|',$this->getLayout($page_tree));

        // 現ページの表示エリアの有無と幅の設定
        $layouts_info = array();
        $layouts_info[0]['exists'] = $layout_array[0];
        $layouts_info[0]['col'] = 'col-sm-12';

        $layouts_info[1]['exists'] = $layout_array[1];
        if ($layout_array[2]) {
            $layouts_info[1]['col'] = ($layout_array[1] == '1' ? 'col-sm-3 col-sm-pull-6' : '' );
        }
        else {
            $layouts_info[1]['col'] = ($layout_array[1] == '1' ? 'col-sm-3 col-sm-pull-9' : '' );
        }

        $layouts_info[2]['exists'] = '1';
        if (!$layout_array[1] && !$layout_array[2]) {
            $layouts_info[2]['col'] = 'col-sm-12';
        }
        else if ($layout_array[1] && !$layout_array[2]) {
            $layouts_info[2]['col'] = 'col-sm-9 col-sm-push-3';
        }
        else if (!$layout_array[1] && $layout_array[2]) {
            $layouts_info[2]['col'] = 'col-sm-9';
        }
        else if ($layout_array[1] && $layout_array[2]) {
            $layouts_info[2]['col'] = 'col-sm-6 col-sm-push-3';
        }

        $layouts_info[3]['exists'] = $layout_array[2];
        $layouts_info[3]['col'] = ($layout_array[2] == '1' ? 'col-sm-3' : '' );

        $layouts_info[4]['exists'] = $layout_array[3];
        $layouts_info[4]['col'] = 'col-sm-12';

        // 共通エリアのフレーム取得

        // フレームを取得するページID
        $page_ins = array();
        foreach($page_tree as $page) {
            $page_ins[] = $page->id;
        }

        // メインエリア以外のフレームの取得
        $frames = Frame::where('area_id', '!=', 2)
                       ->select('frames.*', 'frames.id as frame_id')
                       ->whereIn('page_id', $page_ins)
                       ->orderBy('area_id', 'asc')
                       ->orderBy('page_id', 'desc')
                       ->orderBy('display_sequence', 'asc')
                       ->get();

        // 共通エリアの継承処理
        foreach($frames as $frame) {

            // すでに子の設定で共通エリアにフレームがある場合は、対象外。
            if (array_key_exists($frame['area_id'], $layouts_info) && array_key_exists('frames', $layouts_info[$frame['area_id']]) && !empty($layouts_info[$frame['area_id']]['frames']) ) {

                // 同じページの複数フレームは使用する。
                if ($layouts_info[$frame['area_id']]['frames'][0]['page_id'] == $frame['page_id']) {
                    $layouts_info[$frame['area_id']]['frames'][] = $frame;
                }
            }
            // 子から遡って最初に出てきた共通エリアのフレーム
            else {
                $layouts_info[$frame['area_id']]['frames'][] = $frame;
            }
        }
        //print_r($layouts_info);

        return $layouts_info;
    }

    /**
     *  ページの系統取得
     */
    public function getPageTree($page_id)
    {
        // トップページを取得
        $top_page = Page::orderBy('_lft', 'asc')->first();

        // 自分のページから親を遡って取得
        $page_tree = Page::reversed()->ancestorsAndSelf($page_id);

        // 自分のページツリーの最後（root）にトップが入っていなければ、トップページをページツリーの最後に追加する
        if ($page_tree[count($page_tree)-1]->id != $top_page->id) {
            $page_tree->push($top_page);
        }
        return $page_tree;
    }

    /**
     *  ページのレイアウト取得
     */
    public function getLayout($page_tree)
    {
        // レイアウトの初期値
        $layout_defalt = '1|1|0|1';

        if (empty($this->current_page)) {
            return $layout_defalt;
        }

        // レイアウト
        $layout = null;

        foreach ( $page_tree as $page ) {

            // レイアウト
            if (empty($layout) && $page->layout) {
                $layout = $page->layout;
            }
        }
        // 親も含めて空の場合は、初期値を返却
        if (empty($layout)) {
            $layout = $layout_defalt;
        }
        return $layout;
    }

    /**
     *  表示しているページのオブジェクトを取得
     */
    public function getCurrentPage()
    {
        // ページデータ取得のため、URL から現在のURL パスを判定する。
        $current_url = url()->current();
        $base_url = url('/');
        $current_permanent_link = str_replace( $base_url, '', $current_url);

        // トップページの判定
        if (empty($current_permanent_link)) {
            $current_permanent_link = "/";
        }

        // URL パスでPage テーブル検索
        $current_page = Page::where('permanent_link', '=', $current_permanent_link)->first();
        if (empty($current_page)) {
            return view('404_not_found');
        }

        return $current_page;
    }

    /**
     *  ページに関する情報取得
     */
    public function getPageList()
    {
        // ページ一覧の取得
        return Page::defaultOrderWithDepth();
    }

    /**
     *  表示しているページに関する情報取得
     */
    public function getPageConfig($page_id)
    {
    }

    /**
     *  画面表示
     *  ページ共通で必要な値をココで取得、viewに渡す。
     */
    public function view($blade_path, $args)
    {
        // 一般設定の取得
        $configs = Configs::where('category', 'general')->get();
        $configs_array = array();
        foreach ($configs as $config) {
            $configs_array[$config['name']] = $config['value'];
        }
        $args["configs"] = $configs_array;

        // ハンバーガーメニューで使用するページの一覧
        $args["page_list"] = $this->getPageList();

        return view($blade_path, $args);
    }
}
