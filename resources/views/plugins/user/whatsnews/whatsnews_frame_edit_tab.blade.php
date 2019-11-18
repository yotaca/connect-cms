{{--
 * 編集画面tabテンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 新着情報プラグイン
 --}}
@if ($action == 'editBuckets')
    <li role="presentation" class="nav-item">
        <a href="{{url('/')}}/plugin/whatsnews/editBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">設定変更</a>
    </li>
@else
    <li role="presentation" class="nav-item">
        <a href="{{url('/')}}/plugin/whatsnews/editBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">設定変更</a>
    </li>
@endif
@if ($action == 'createBuckets')
    <li role="presentation" class="nav-item">
        <a href="{{url('/')}}/plugin/whatsnews/createBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">新規作成</a>
    </li>
@else
    <li role="presentation" class="nav-item">
        <a href="{{url('/')}}/plugin/whatsnews/createBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">新規作成</a>
    </li>
@endif
@if ($action == 'listBuckets')
    <li role="presentation" class="nav-item">
        <a href="{{url('/')}}/plugin/whatsnews/listBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link active">選択</a>
    </li>
@else
    <li role="presentation" class="nav-item">
        <a href="{{url('/')}}/plugin/whatsnews/listBuckets/{{$page->id}}/{{$frame->id}}#{{$frame->id}}" class="nav-link">選択</a>
    </li>
@endif