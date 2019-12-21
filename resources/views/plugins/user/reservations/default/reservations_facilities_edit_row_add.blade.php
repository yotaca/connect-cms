{{--
 * 施設の追加行
 *
 * @author 井上 雅人 <inoue@opensource-workshop.jp / masamasamasato0216@gmail.com>
 * @copyright OpenSource-WorkShop Co.,Ltd. All Rights Reserved
 * @category 施設予約プラグイン
 --}}
<tr id="column_add_tr">
    <td style="vertical-align: middle;" nowrap><br /></td>
    <td>
        {{-- 施設名 --}}
        <input class="form-control" type="text" name="facility_name" placeholder="施設名">
    </td>
    <td style="vertical-align: middle;">
        {{-- ＋ボタン --}}
        <button class="btn btn-primary cc-font-90 text-nowrap" onclick="javascript:submit_add_facility(this);"><i class="fas fa-plus"></i> <span class="d-sm-none">追加</span></button>
    </td>
</tr>
