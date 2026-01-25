<?php $pager->setSurroundCount(2) ?>

<nav>
    <ul class="pagination">
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item previous">
                <a href="<?= $pager->getFirst() ?>" class="page-link" aria-label="<?= lang('Pager.first') ?>">
                    <i class="ki-outline ki-double-left fs-2"></i>
                </a>
            </li>
            <li class="page-item previous">
                <a href="<?= $pager->getPrevious() ?>" class="page-link" aria-label="<?= lang('Pager.previous') ?>">
                    <i class="ki-outline ki-left fs-2"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <li class="page-item next">
                <a href="<?= $pager->getNext() ?>" class="page-link" aria-label="<?= lang('Pager.next') ?>">
                    <i class="ki-outline ki-right fs-2"></i>
                </a>
            </li>
            <li class="page-item next">
                <a href="<?= $pager->getLast() ?>" class="page-link" aria-label="<?= lang('Pager.last') ?>">
                    <i class="ki-outline ki-double-right fs-2"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>