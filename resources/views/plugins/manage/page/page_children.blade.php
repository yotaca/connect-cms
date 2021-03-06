{{--
 * メニューの子要素表示画面
 *
 * @param obj $pages ページデータの配列
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category メニュープラグイン
--}}

@if ($children->display_flag == 1)

    @if ($children->id == $page_id)
    <a href="{{ url("$children->permanent_link") }}" class="list-group-item active">
    @else
    <a href="{{ url("$children->permanent_link") }}" class="list-group-item">
    @endif
        {{-- 各ページの深さをもとにインデントの表現 --}}
        @for ($i = 0; $i < $children->depth; $i++)
            <span @if ($i+1==$children->depth) class="glyphicon glyphicon-chevron-right" style="color: #c0c0c0;"@else style="padding-left:15px;"@endif></span>
        @endfor
        {{$children->page_name}}
    </a>

    @if ($children->children && count($children->children) > 0)
        @include('plugins.user.menus.default.menu_children',['children' => $children->children[0]])
    @endif
@endif
