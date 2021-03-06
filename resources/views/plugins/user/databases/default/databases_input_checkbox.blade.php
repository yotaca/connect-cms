{{--
 * 登録画面(input checkbox)テンプレート。
 *
 * @author 永原　篤 <nagahara@opensource-workshop.jp>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category データベース・プラグイン
 --}}
@if (array_key_exists($database_obj->id, $databases_columns_id_select))
    @php
        // グループカラムの幅の計算
        $col_count = floor(12/count($databases_columns_id_select[$database_obj->id]));
        if ($col_count < 3) {
            $col_count = 3;
        }

	    // value 値の取得
	    $value_obj = (empty($input_cols)) ? null : $input_cols->where('databases_inputs_id', $id)->where('databases_columns_id', $database_obj->id)->first();
	    $value = '';
	    $values = array();
	    if (!empty($value_obj)) {
	        $value = $value_obj->value;
 		    $values = explode(',', $value);
	    }

    @endphp
    <div class="container-fluid row">
        @foreach($databases_columns_id_select[$database_obj->id] as $select)

            @php
            // チェック用変数
            $column_checkbox_checked = "";

            // old でチェックされていたもの
            if (!empty(old('databases_columns_value.'.$database_obj->id))) {
                foreach(old('databases_columns_value.'.$database_obj->id) as $old_value) {
                    if ( $old_value == $select['value'] ) {
                        $column_checkbox_checked = " checked";
                    }
                }
            }

            // 画面が戻ってきたもの
            if (isset($request->databases_columns_value) &&
                array_key_exists($database_obj->id, $request->databases_columns_value)) {

                foreach($request->databases_columns_value[$database_obj->id] as $request_value) {
                    if ( $request_value == $select['value'] ) {
                        $column_checkbox_checked = " checked";
                    }
                }
            }

            // 変更時のデータベースの値から
            if (!empty($values)) {

                foreach($values as $selected_value) {
                    if ( $selected_value == $select['value'] ) {
                        $column_checkbox_checked = " checked";
                    }
                }
            }
            @endphp

            <div class="custom-control custom-checkbox custom-control-inline">
                <input name="databases_columns_value[{{$database_obj->id}}][]" value="{{$select['value']}}" type="{{$database_obj->column_type}}" class="custom-control-input" id="databases_columns_value[{{$database_obj->id}}]_{{$loop->iteration}}"{{$column_checkbox_checked}}>
                <label class="custom-control-label" for="databases_columns_value[{{$database_obj->id}}]_{{$loop->iteration}}"> {{$select['value']}}</label>
            </div>

        @endforeach
    </div>
    @if ($errors && $errors->has("databases_columns_value.$database_obj->id"))
        <div class="d-block text-danger">
            <i class="fas fa-exclamation-circle"></i> {{$errors->first("databases_columns_value.$database_obj->id")}}
        </div>
    @endif
@endif
