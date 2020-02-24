<?php require_once('partials/header.php'); ?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form name="form-add" method="POST" action="" id="form-add" enctype="multipart/form-data">
                <input type="hidden" name="max_file_size" value="16777216">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="source">Source</label>
                    <input type="text" class="form-control" id="source" name="source" placeholder="Enter source" required>
                </div>
                <div class="form-group">
                    <label for="url">Link</label>
                    <input type="url" class="form-control" id="url" name="url" placeholder="Enter link">
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control" id="image" name="image" />
                </div>
                <button type="submit" class="btn btn-primary" name="add">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php require_once('partials/footer.php'); ?>