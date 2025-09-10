<?php
/**
 * Breadcrumbs Template Part
 * Displays breadcrumb navigation for any page
 */

// Don't show breadcrumbs on homepage
if (is_home() || is_front_page()) {
    return;
}

$breadcrumbs = nirup_get_breadcrumbs();

if (!empty($breadcrumbs)) : ?>
    <nav class="breadcrumbs" aria-label="Breadcrumb">
        <div class="breadcrumbs-container">
            <ol class="breadcrumbs-list">
                <?php foreach ($breadcrumbs as $index => $crumb) : ?>
                    <li class="breadcrumb-item">
                        <?php if ($crumb['url'] && $index < count($breadcrumbs) - 1) : ?>
                            <a href="<?php echo esc_url($crumb['url']); ?>" class="breadcrumb-link">
                                <?php echo esc_html($crumb['title']); ?>
                            </a>
                        <?php else : ?>
                            <span class="breadcrumb-current"><?php echo esc_html($crumb['title']); ?></span>
                        <?php endif; ?>
                        
                        <?php if ($index < count($breadcrumbs) - 1) : ?>
                            <span class="breadcrumb-separator">></span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </div>
    </nav>
<?php endif; ?>