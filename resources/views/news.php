<?php require_once('partials/header.php'); ?>

<div class="container">
    <div class="row">
        <h2 class="display-2">News Report</h2>
        <div id="news" class="d-flex justify-content-start mr-2">
        <?php if (!empty($result)): ?>
            <?php foreach ($result as $key => $value): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="<?= !empty($result[$key]['image']) ? $result[$key]['image'] : 'public/images/default.png'; ?>">
                        <div class="card-block">
                            <h4 class="card-title mt-3"><?= $result[$key]['title']; ?></h4>
                            <div class="meta">
                                <a href="<?= $result[$key]['url']; ?>"><?= $result[$key]['source']; ?></a>
                            </div>
                            <div class="card-text">
                                <?= $result[$key]['description']; ?>
                            </div>
                        </div>
                        <div class="card-footer">
                            <small><?=  $result[$key]['created_at']; ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center"><br />No Data</h2>
        </div>
    </div>
    <?php endif; ?>
        
    <div class="d-flex align-items-end">
        <a class="btn btn-primary" href="index.php?action=news-add">Add News</a>
    </div>
</div>

<?php require_once('partials/footer.php'); ?>