{{--
 * ログインがまだの場合テンプレート。
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category Opacプラグイン
 --}}
@extends('core.cms_frame_base')

@section("plugin_contents_$frame->id")
    <div class="alert alert-warning text-center">
        <i class="fas fa-exclamation-circle"></i>
        My Opac はログインしてから使用してください。
    </div>
@endsection
