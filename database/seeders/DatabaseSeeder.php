<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\SkillCategory;
use App\Models\Skill;
use App\Models\Technology;
use App\Models\SocialLink;
use App\Models\Project;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Certificate;
use App\Models\Testimonial;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::updateOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Portfolio Admin', 'username' => 'admin', 'password' => Hash::make('password'), 'role' => 'admin',
        ]);
        $profile = Profile::updateOrCreate(['user_id' => $admin->id], [
            'title' => 'Full-Stack Developer',
            'bio' => 'I build modern web applications, dependable APIs, and digital products that make complex work feel simple.',
            'location' => 'Phnom Penh, Cambodia', 'years_of_experience' => 5,
        ]);
        foreach ([['name' => 'GitHub', 'url' => 'https://github.com'], ['name' => 'LinkedIn', 'url' => 'https://linkedin.com']] as $index => $link) {
            SocialLink::updateOrCreate(['profile_id' => $profile->id, 'name' => $link['name']], $link + ['sort_order' => $index]);
        }
        foreach (['Frontend', 'Backend', 'Database', 'DevOps'] as $index => $name) {
            SkillCategory::firstOrCreate(['name' => $name], ['sort_order' => $index]);
        }
        foreach (['Laravel', 'PHP', 'Vue.js', 'MySQL', 'Docker', 'Git'] as $name) Technology::firstOrCreate(['name' => $name]);

        $categories = SkillCategory::pluck('id', 'name');
        foreach ([
            'Frontend' => ['Vue.js', 'JavaScript', 'Tailwind CSS'],
            'Backend' => ['PHP', 'Laravel', 'REST APIs'],
            'Database' => ['MySQL', 'PostgreSQL', 'Redis'],
            'DevOps' => ['Docker', 'Git', 'Linux'],
        ] as $category => $skills) {
            foreach ($skills as $index => $name) Skill::firstOrCreate(['skill_category_id' => $categories[$category], 'name' => $name], ['sort_order' => $index]);
        }

        $technologies = Technology::pluck('id', 'name');
        $project = Project::updateOrCreate(['slug' => 'classroom-management-platform'], [
            'user_id' => $admin->id, 'title' => 'Classroom Management Platform', 'short_description' => 'A practical platform for managing classes, attendance, and student progress.',
            'description' => 'A full-stack platform that brings daily education workflows into one clear workspace.', 'problem' => 'Scattered attendance and class records slowed down administrative work.', 'solution' => 'A role-aware Laravel application with focused dashboards and reliable records.', 'status' => 'completed', 'featured' => true, 'started_at' => '2025-01-01', 'completed_at' => '2025-06-01',
        ]);
        $project->technologies()->sync(array_values(array_intersect_key($technologies->toArray(), array_flip(['Laravel','Vue.js','MySQL','Docker']))));
        Project::updateOrCreate(['slug' => 'loyalty-rewards-engine'], [
            'user_id' => $admin->id, 'title' => 'Loyalty Rewards Engine', 'short_description' => 'Configurable reward rules and product redemption workflows for modern retail teams.',
            'description' => 'A modular service architecture for points, rewards, products, and customer eligibility.', 'status' => 'in_progress', 'featured' => true, 'started_at' => '2026-01-01',
        ])->technologies()->sync(array_values(array_intersect_key($technologies->toArray(), array_flip(['PHP','Laravel','MySQL','Redis']))));

        Experience::updateOrCreate(['user_id' => $admin->id, 'company' => 'Northstar Digital'], ['position' => 'Full-Stack Developer', 'location' => 'Phnom Penh', 'start_date' => '2023-01-01', 'is_current' => true, 'description' => 'Build and maintain business applications from product discovery through production.', 'responsibilities' => 'Architecture, implementation, code review, and delivery.']);
        Education::updateOrCreate(['user_id' => $admin->id, 'school' => 'Royal University of Phnom Penh'], ['degree' => 'Bachelor of Computer Science', 'major' => 'Software Engineering', 'start_date' => '2018-01-01', 'end_date' => '2022-01-01', 'description' => 'Focused on software design, databases, and web application development.']);
        Certificate::updateOrCreate(['user_id' => $admin->id, 'title' => 'Laravel Application Development'], ['issuer' => 'Laravel Community', 'issue_date' => '2024-05-01', 'credential_id' => 'DEV-LARAVEL-2024']);
        $blogCategory = BlogCategory::firstOrCreate(['slug' => 'engineering'], ['name' => 'Engineering', 'description' => 'Practical notes from building software.']);
        Blog::updateOrCreate(['slug' => 'building-maintainable-laravel-applications'], ['user_id' => $admin->id, 'title' => 'Building Maintainable Laravel Applications', 'excerpt' => 'A few principles that keep growing Laravel projects understandable.', 'content' => 'Good boundaries, explicit data flows, and small focused controllers make applications easier to evolve.', 'status' => 'published', 'published_at' => now()->subDays(3)])->categories()->sync([$blogCategory->id]);
        Testimonial::updateOrCreate(['name' => 'Sokha Chann'], ['position' => 'Product Manager', 'company' => 'Northstar Digital', 'message' => 'A thoughtful engineer who turns ambiguous requirements into dependable products.', 'is_approved' => true, 'sort_order' => 0]);
        foreach (['website_name' => 'Portfolio', 'website_title' => 'Full-Stack Developer Portfolio', 'meta_description' => 'A portfolio of web applications, APIs, and digital products.', 'footer_text' => 'Built with care and curiosity.'] as $key => $value) Setting::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
