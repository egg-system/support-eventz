<h3>現時点報酬金額合計</h3>
<?php echo number_format($detail->totalPrice) . "円"; ?><br>
<?php echo "(" . date("Y年m月d日") . "時点)"; ?>

<h3>過去の履歴参照</h3>
<form class="form-inline" action="<?php echo Reward\Constant::DETAIL_PAGE_URL; ?>" method="get">
  <select class="form-control col-3" name="start" value="<?php echo $detail->start; ?>">
    <?php foreach ($detail->selectTerm as $key => $month) { ?>
      <?php $selected = ($month === $detail->start) ? "selected" : ""; ?>
      <option <?php echo $selected; ?>><?php echo $month; ?></option>
    <?php } ?>
  </select>&nbsp;〜&nbsp;
  <select class="form-control col-3" name="end">
    <?php foreach ($detail->selectTerm as $key => $month) { ?>
      <?php $selected = ($month === $detail->end) ? "selected" : ""; ?>
      <option <?php echo $selected; ?>><?php echo $month; ?></option>
    <?php } ?>
  </select>
  <button type="submit" class="btn btn-primary btn-sm">表示期間変更</button>
</form>
<?php if (!empty($detail->error)) { ?>
  <div class="alert alert-danger" role="alert"><?php echo $detail->error; ?></div>
<?php } ?>

<?php if (!empty($detail->results)) { ?>
<div class="table-responsive">
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>No</th>
                <th>会員名</th>
                <th>登録日</th>
                <th>会員レベル</th>
                <?php foreach ($detail->allMonth as $month) { ?>
                    <th><?php echo $month; ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php $number = 1; ?>
            <?php foreach ($detail->inputData as $id => $data) { ?>
                <tr>
                    <td><?php echo $number; ?></td>
                    <td>
                    <?php 
                        if (($data[0]['first_name'] === '' || $data[0]['first_name'] === null) &&
                            ($data[0]['member_id'] === '' || $data[0]['member_id'] === null)) {
                            // 紹介者の名前とIDがない場合は過去分の累計報酬として扱う
                            echo '過去の累計報酬額';
                        } else {
                            echo $data[0]['first_name'];
                        }
                    ?>
                    </td>
                    <td><?php echo $data[0]['date']; ?></td>
                    <td><?php echo $data[0]['alias']; ?></td>
                    <?php foreach ($detail->allMonth as $month) { ?>
                        <td class="text-right"><?php echo isset($data[$month]['price']) ? '¥' . number_format($data[$month]['price']) : '¥0'; ?></td>
                    <?php } ?>
                </tr>
                <?php $number++ ; ?>
            <?php } ?>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <?php foreach ($detail->allMonth as $month) { ?>
                    <th></th>
                <?php } ?>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>月間報酬額</td>
                <?php foreach ($detail->allMonth as $month) { ?>
                    <?php $sum = 0 ; ?>
                    <?php foreach ($detail->inputData as $id => $data) {
                        $price = isset($data[$month]['price']) ? $data[$month]['price'] : 0;
                        $sum += $price;
                    } ?>
                    <td class="text-right"><?php echo '¥' . number_format($sum); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>出金申請額</td>
                <?php foreach ($detail->allMonth as $month) { ?>
                    <?php $price = isset($detail->outputData[$month]) ? abs($detail->outputData[$month]) : 0; ?>
                    <td class="text-right"><?php echo '¥' . number_format($price); ?></td>
                <?php } ?>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>累計報酬額</td>
                <?php $sum = $detail->pastTotalPrice ; ?>
                <?php foreach ($detail->allMonth as $month) { ?>
                <?php 
                    foreach ($detail->inputData as $id => $data) {
                        $price = isset($data[$month]['price']) ? $data[$month]['price'] : 0;
                        $sum += $price;
                    }

                    // 出金分をマイナスする
                    $output = isset($detail->outputData[$month]) ? abs($detail->outputData[$month]) : 0;
                    $sum -= $output;
                ?>
                    <td class="text-right"><?php echo '¥' . number_format($sum); ?></td>
                <?php } ?>
            </tr>
        </tbody>
    </table>
</div>

<h3>出金申請</h3>
<div class="card bg-light mb-3">
  <div class="card-body">
    <form class="form-inline" action="<?php echo Reward\Constant::CONFIRM_PAGE_URL; ?>" method="post">
      <input type="number" class="form-control col-4" placeholder="¥30,000" name="price" value="">
      <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(Reward\Constant::NONCE_DETAIL_PAGE);?>">
      &nbsp;/&nbsp;<?php echo number_format($detail->totalPrice); ?>
      <?php if ($detail->totalPrice < Reward\Constant::MINIMUM_OUTPUT_PRICE) { ?>
        <button type="submit" class="btn btn-secondary" disabled>申請</button>
      <?php } else { ?>
        <button type="submit" class="btn btn-success">申請</button>
      <?php } ?>
    </form>
    <div>※出金は<?php echo number_format(Reward\Constant::OUTPUT_UNIT); ?>円単位で申請できます</div>
    <div>※出金は<?php echo number_format(Reward\Constant::MINIMUM_OUTPUT_PRICE); ?>円以上から申請できます</div>
  </div>
</div>
                    
<script type="text/javascript">
// 画面いっぱいにする
document.getElementById('main').style.width = '100%';
</script>
<?php } else { ?>
  <div class="alert alert-warning" role="alert">指定された期間の報酬はありません。</div>
<?php } ?>
