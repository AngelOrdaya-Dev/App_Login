<?php
$content = file_get_contents('c:\\xampp\\htdocs\\App_Login\\resources\\views\\dashboard.blade.php');

$mainStart = strpos($content, '<main class="content">');
$mainEnd = strpos($content, '</main>');

$layoutTop = substr($content, 0, $mainStart + 22);
$dashboardContent = substr($content, $mainStart + 22, $mainEnd - ($mainStart + 22));
$layoutBottom = substr($content, $mainEnd);

// For layout top, we need to add @yield('content') where the main content used to be.
$layoutContent = $layoutTop . "\n            @yield('content')\n        " . $layoutBottom;

// For dashboard.blade.php, we need to wrap it in @extends and @section.
$newDashboardContent = "@extends('layouts.admin')\n\n@section('content')\n" . $dashboardContent . "\n@endsection\n";

// Write layout
file_put_contents('c:\\xampp\\htdocs\\App_Login\\resources\\views\\layouts\\admin.blade.php', $layoutContent);

// Write new dashboard
file_put_contents('c:\\xampp\\htdocs\\App_Login\\resources\\views\\dashboard.blade.php', $newDashboardContent);

echo "Layout extracted successfully.";
