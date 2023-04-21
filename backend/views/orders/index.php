<?php

use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Html;

?>
<div style="display:flex; flex-direction:row; justify-content:space-between;">
    <h2>Orders</h2>
    <a href="/products/create" class="btn btn-primary" style="height:fit-content;"><i class="bi bi-plus"> </i>Create</a>
</div>
<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
    <li class="page-item active" aria-current="page">
      <a class="page-link" href="#">1</a>
    </li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav>