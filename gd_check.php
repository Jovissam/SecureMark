<?php
if (extension_loaded('gd')) {
    echo "✅ GD is enabled<br>";
    print_r(gd_info());
} else {
    echo "❌ GD is NOT enabled";
}
?>
