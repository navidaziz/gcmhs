<div class="col-sm-3 wow slideInUp" data-wow-delay="0.3s">
  <div class="sidebar-container">
    <div>
      <ul class="styled">
        <?php foreach($menu_pages as $menu_page){ ?>
        <?php if(count($menu_page->menu_sub_pages)>0){ ?>
        <li> <a href="<?php echo base_url("page/view_page/".$menu_page->page_id); ?>"><?php echo $menu_page->page_name; ?></a>
          <ul>
           <?php foreach($menu_page->menu_sub_pages as $menu_sub_page){ ?>
             <li> <a href="<?php echo base_url("page/view_page/".$menu_sub_page->page_id); ?>"><?php echo $menu_page->page_name; ?></a>
             <?php } ?>
          </ul>
        </li>
        <?php }else{?>
         <li> <a href="<?php echo base_url("page/view_page/".$menu_page->page_id); ?>"><?php echo $menu_page->page_name; ?></a>
        <?php } ?>
        
      <?php } ?>
      </ul>
    </div>
  </div>
</div>
  