<link rel="stylesheet" href="../../../css/templates/breadCrumb.css">
<nav aria-label="breadcrumb" class="breadcrumb">
  <?php if (isset($links) && is_array($links)): ?>
    <?php foreach ($links as $index => $link): ?>
      <?php if ($index > 0): ?>
        <span class="breadcrumb-separator">></span>
      <?php endif; ?>
      
      <?php if (!empty($link['url'])): ?>
        <a href="<?php echo htmlspecialchars($link['url']); ?>" 
           class="breadcrumb-item <?php echo $index === array_key_last($links) ? 'active' : ''; ?>">
          <?php echo htmlspecialchars($link['title']); ?>
        </a>
      <?php else: ?>
        <span class="breadcrumb-item active"><?php echo htmlspecialchars($link['title']); ?></span>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php endif; ?>
</nav>

