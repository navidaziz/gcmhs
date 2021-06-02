
<div class="row">
<!-- MESSENGER -->

 <?php foreach($classes as $class){ ?>
<div class="col-md-3">
<h3><?php echo $class->Class_title; ?></h3>
<div class="list-group">
 <?php foreach($class->sections as $section){ ?>
<a class="list-group-item" href="<?php echo site_url("student/students_list")."/$class->class_id/$section->section_id"; ?>" ><?php echo $section->section_title; ?></a>
  <?php } ?>
  <a class="list-group-item" href="<?php echo site_url("student/edit_students")."/$class->class_id/$section->section_id"; ?>" >Edit Students</a>
</div>
</div>
 <?php } ?>

</div>



