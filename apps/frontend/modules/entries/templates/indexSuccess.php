<? use_javascript('entry') ?>
<h2>Lista wpisów dla miesiąca <?php echo include_component('entries', 'monthChoose', array('month' => $month, 'year' => $year)) ?></h2>

<?php if ($form): ?>
  <?php echo $form->renderFormTag('/entries/add', array('id' => 'entryAdd')) ?>
    <table cellspacing="0">
      <thead>
        <tr>
          <th colspan="2">Nowy wpis czasu pracy</th>
        </tr>
      </thead>
      <tbody>
        <?php echo $form ?>
        <tr>
          <td>&nbsp;</td>
          <td><input class="submit" type="submit" value="Dodaj" /></td>
        </tr>
      </tbody>
    </table>
  </form>
<?php endif ?>

<table id="entries" cellspacing="0">
  <thead>
    <tr>
      <th class="day">Dzień</th>
      <th class="dayLiteral">Słownie</th>
      <th class="workingTime">Czas pracy</th>
      <th class="delta">Odchylenie</th>
      <th class="occurences">Wpisów</th>
    </tr>
  </thead>
  <tfoot>
    <tr class="<?php echo ($summary['delta'] < 0) ? 'minus' : '' ?>">
      <th colspan="2"></th>
      <th class="sum"><?php echo TimeHelper::formatTime($summary['sum']) ?></th>
      <th class="delta"><?php echo TimeHelper::formatTime($summary['delta']) ?></th>
      <th class="occurences"><?php echo $summary['occurences'] ?></th>
    </tr>
  </tfoot>
  <tbody>
    <?php if(count($entries) > 0): ?>
      <?php foreach($entries as $day => $entry): ?>
        <tr id="entry-<?php echo $day ?>" class="<?php echo $entry->isDeltaNegative() ? 'minus' : '' ?>">
          <td class="day"><?php echo $day ?></td>
          <td class="dayLiteral"><?php echo $entry->getDayLiteral() ?></td>
          <td class="workingTime"><?php echo TimeHelper::formatTime($entry->getWorkingTime()) ?></td>
          <td class="delta"><?php echo TimeHelper::formatTime($entry->getDelta()) ?></td>
          <td class="occurences"><?php echo $entry->occurences ?></td>
        </tr>
      <?php endforeach ?>
    <?php else: ?>
      <tr class="empty">
        <td colspan="5">Brak wpisów</td>
      </tr>
    <?php endif ?>
  </tbody>
</table>
