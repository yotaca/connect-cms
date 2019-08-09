{{--
 * フォーム編集画面テンプレート。
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category フォームプラグイン
 --}}

<ul class="nav nav-tabs">
    {{-- プラグイン側のフレームメニュー --}}
    @include('plugins.user.forms.forms_frame_edit_tab')

    {{-- コア側のフレームメニュー --}}
    @include('core.cms_frame_edit_tab')
</ul>

@if (!$form->id && !$create_flag)
    <div class="alert alert-warning" style="margin-top: 10px;">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        フォーム選択画面から選択するか、フォーム新規作成で作成してください。
    </div>
@else
    <div class="alert alert-info" style="margin-top: 10px;">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>

        @if ($message)
            {!!$message!!}
        @else
            @if (empty($form) || $create_flag)
                新しいフォーム設定を登録します。
            @else
                フォーム設定を変更します。
            @endif
        @endif
    </div>
@endif

@if (!$form->id && !$create_flag)
@else
<form action="/plugin/forms/savePlugin/{{$page->id}}/{{$frame_id}}" method="POST" class="">
    {{ csrf_field() }}

    {{-- create_flag がtrue の場合、新規作成するためにforms_id を空にする --}}
    @if ($create_flag)
        <input type="hidden" name="forms_id" value="">
    @else
        <input type="hidden" name="forms_id" value="{{$form->id}}">
    @endif

    <div class="form-group">
        <label class="control-label">フォーム名 <span class="label label-danger">必須</span></label>
        <input type="text" name="forms_name" value="{{old('forms_name', $form->forms_name)}}" class="form-control">
        @if ($errors && $errors->has('forms_name')) <div class="text-danger">{{$errors->first('forms_name')}}</div> @endif
    </div>

    {{-- Submitボタン --}}
    <div class="form-group text-center">
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary form-horizontal"><span class="glyphicon glyphicon-ok"></span> 
                @if (empty($form) || $create_flag)
                    登録確定
                @else
                    変更確定
                @endif
                </button>
                <button type="button" class="btn btn-default" style="margin-left: 10px;" onclick="location.href='{{URL::to($page->permanent_link)}}'">
                    <span class="glyphicon glyphicon-remove"></span> キャンセル
                </button>
            </div>

            {{-- 既存フォームの場合は削除処理のボタンも表示 --}}
            @if ($create_flag)
            @else
            <div class="col-sm-3 pull-right text-right">
                <a data-toggle="collapse" href="#collapse{{$form_frame->id}}">
                    <span class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> <span class="hidden-xs">削除</span></span>
                </a>
            </div>
            @endif
        </div>
    </div>
</form>

<div id="collapse{{$form_frame->id}}" class="collapse" style="margin-top: 8px;">
    <div class="panel panel-danger">
        <div class="panel-body">
            <span class="text-danger">フォームを削除します。<br>このフームに登録された内容も削除され、元に戻すことはできないため、よく確認して実行してください。</span>

            <div class="text-center">
                {{-- 削除ボタン --}}
                <form action="{{url('/')}}/redirect/plugin/forms/destroyPlugin/{{$page->id}}/{{$frame_id}}/{{$form_frame->forms_id}}" method="POST">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-danger" onclick="javascript:return confirm('データを削除します。\nよろしいですか？')"><span class="glyphicon glyphicon-ok"></span> 本当に削除する</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endif