{{--
 * テーマ名編集テンプレート
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category テーマ管理
 --}}
{{-- 管理画面ベース画面 --}}
@extends('plugins.manage.manage')

{{-- 管理画面メイン部分のコンテンツ section:manage_content で作ること --}}
@section('manage_content')

    <script type="text/javascript">
        function delete_theme(dir_name)
        {
            if (confirm('テーマを削除します。\nよろしいですか？')) {
                foem_delete_theme.dir_name.value = dir_name;
                foem_delete_theme.submit();
                return true;
            }
            else {
                return false;
            }
        }
    </script>


<div class="card mb-3">
    <div class="card-header p-0">
        {{-- 機能選択タブ --}}
        @include('plugins.manage.theme.theme_manage_tab')
    </div>

    <div class="card-body">

        <form action="{{url('/')}}/manage/theme/saveName" method="POST">
            {{csrf_field()}}
            <input name="dir_name" type="hidden" value="{{$dir_name}}" />

            <div class="form-group row">
                <label for="theme_name" class="col-md-3 col-form-label text-md-right">テーマ名</label>
                <div class="col-md-9">
                    <input type="text" name="theme_name" id="theme_name" value="{{old('theme_name', $theme_name)}}" class="form-control">
                    @if ($errors && $errors->has('theme_name')) <div class="text-danger">{{$errors->first('theme_name')}}</div> @endif
                </div>
            </div>

            <div class="offset-sm-3 col-sm-6">
                <div class="form-group mt-3">
                    <button type="button" class="btn btn-secondary mr-2" onclick="location.href='{{url('/')}}/manage/theme/'"><i class="fas fa-times"></i> キャンセル</button>
                    <button type="submit" class="btn btn-primary form-horizontal">
                        <i class="fas fa-check"></i> テーマ名保存
                    </button>
                </div>
            </div>
        </form>

        <form action="{{url('/')}}/manage/theme/deleteTheme" method="POST" class="mt-5" name="foem_delete_theme">
            {{csrf_field()}}
            <input name="dir_name" type="hidden" value="{{$dir_name}}" />

            <div class="offset-sm-3 col-sm-6">
                <div class="form-group mt-3">
                    <button type="button" class="btn btn-danger form-horizontal" onclick="javascript:return delete_theme('{{$dir_name}}');">
                        <i class="fas fa-check"></i> テーマの削除
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
