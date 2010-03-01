<h2>Lista wpisów na miesiąc <?php echo $month ?></h2>

<table>
  <thead>
    <tr>
      <th>Dzień</th>
      <th>Słownie</th>
      <th>Czas pracy</th>
      <th>Odchylenie</th>
      <th>Ilość wpisów</th>
    </tr>
  </thead>
  <tfoot>
    <tr>
      <th colspan="2"></th>
      <th id="sum"><?php echo TimeHelper::formatTime($summary['sum']) ?></th>
      <th id="delta"><?php echo TimeHelper::formatTime($summary['delta']) ?></th>
      <th id="occurences"><?php echo $summary['occurences'] ?></th>
    </tr>
  </tfoot>
  <tbody>
    <?php if(count($entries) > 0): ?>
      <?php foreach($entries as $day => $entry): ?>
        <tr class="<?php echo $entry->isDeltaNegative() ? 'minus' : '' ?>">
          <td><?php echo $day ?></td>
          <td><?php echo $entry->getDayLiteral() ?></td>
          <td><?php echo TimeHelper::formatTime($entry->getWorkingTime()) ?></td>
          <td><?php echo TimeHelper::formatTime($entry->getDelta()) ?></td>
          <td><?php echo $entry->occurences ?></td>
        </tr>
      <?php endforeach ?>
    <?php else: ?>
      <tr>
        <td colspan="5">Brak wpisów</td>
      </tr>
    <?php endif ?>
  </tbody>
</table>
