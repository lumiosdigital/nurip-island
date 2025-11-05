# Quick Fix for "Cannot Redeclare" Error

## Problem
You're getting a "Cannot redeclare nirup_custom_image_sizes()" error because the function exists in both:
- Original `functions.php` (line 1044)
- New `inc/theme-setup.php` (line 68)

## Cause
The modular files are being loaded while the original functions.php still contains all the same functions.

## Solution

### If you manually added `require_once` statements to functions.php:

**REMOVE or COMMENT OUT these lines from your functions.php:**

```php
// Comment out or remove these:
// require_once get_template_directory() . '/inc/theme-setup.php';
// require_once get_template_directory() . '/inc/post-types.php';
// require_once get_template_directory() . '/inc/helper-functions.php';
// require_once get_template_directory() . '/inc/enqueue-scripts.php';
```

### Where did you add the includes?

Please let me know where you added the `require_once` statements so I can help you fix it properly.

## Important Note

The modular files (`inc/post-types.php`, `inc/theme-setup.php`, etc.) are **ready but not yet integrated**. They're meant to REPLACE parts of the original functions.php, not run alongside it.

## Next Steps

1. **For now**: Remove any `require_once` statements you added
2. **To fully implement**: We need to create a new functions.php that uses the modular files

Would you like me to create a complete, ready-to-use functions.php that properly integrates the modular files?
