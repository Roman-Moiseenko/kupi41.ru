<h2>Документы</h2>
<?php $i = 0;foreach ($paydocs as $paydoc): ?>
 <div class="row p-2">
     <div class="col-lg-2 col-sm-3">
         #<?php echo ++$i; ?>. <?=Paydoc::$caption[$paydoc->typepaydoc]?>
     </div>
     <div class="col-lg-10 col-sm-9">
         <a href="/pay/paydoc/<?=$paydoc->productorder?>"> № <?=$paydoc->numberpaydoc?> от <?=_f::dateToHTML($paydoc->datepaydoc);?></a>
     </div>
 </div>

<?php endforeach; ?>
