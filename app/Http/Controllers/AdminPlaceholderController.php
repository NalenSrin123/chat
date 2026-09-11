<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class AdminPlaceholderController extends Controller
{
    public function __invoke(string $module): View
    {
        abort_unless(in_array($module, ['projects', 'skills', 'experience', 'education', 'certificates', 'blog', 'testimonials', 'messages', 'social-links', 'settings']), 404);
        return view('admin.placeholder', ['module' => $module]);
    }
}
