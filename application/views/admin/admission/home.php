<div class="row">
  <div class="col-md-2">
    <div class="row">
      <!-- MESSENGER -->

      <?php foreach ($classes as $class) { ?>
        <div class="col-md-12">
          <h3><?php echo $class->Class_title; ?></h3>
          <div class="list-group">
            <?php foreach ($class->sections as $section) { ?>
              <a class="list-group-item" href="<?php echo site_url(ADMIN_DIR . "admission/view_students") . "/$class->class_id/$section->section_id"; ?>">
                <?php echo $section->section_title; ?></a>
            <?php } ?>

          </div>
        </div>
      <?php } ?>

    </div>

  </div>
</div>