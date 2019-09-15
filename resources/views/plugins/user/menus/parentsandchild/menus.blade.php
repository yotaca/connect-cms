{{--
 * メニュー表示画面
 *
 * @param obj $pages ページデータの配列
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category メニュープラグイン
--}}
@if ($ancestors)

    <div class="list-group" style="margin-bottom: 0;">
        @foreach($pages as $key => $page)
            @php
                if (isset($index)) {
                    break;
                }
                if ($ancestors[0]->id == $page->id) {
                    $index = $key;
                }
            @endphp
        @endforeach

        {{-- 子供のページがある場合 --}}
        @if (count($pages[$index]->children) > 0)
            @php
                $page = $pages[$index];
            @endphp

            {{-- リンク生成。メニュー項目全体をリンクにして階層はその中でインデント表記したいため、a タグから記載 --}}
            @if ($page->id == $page_id)
            <a href="{{ url("$page->permanent_link") }}" class="list-group-item active">
            @else
            <a href="{{ url("$page->permanent_link") }}" class="list-group-item">
            @endif
                {{-- 各ページの深さをもとにインデントの表現 --}}
                @for ($i = 0; $i < $page->depth; $i++)
                    @if ($i+1==$children->depth) <i class="fas fa-chevron-right"></i> @else <span class="px-2"></span>@endif
                @endfor
                {{$page->page_name}}
            </a>

            {{-- 子要素を再帰的に表示するため、別ファイルに分けてinclude --}}
            @foreach($page->children as $children)
                @include('plugins.user.menus.parentsandchild.menu_children',['children' => $children, 'page_id' => $page_id])
            @endforeach
        @endif

    </div>
@endif