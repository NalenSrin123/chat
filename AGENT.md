Build a complete **Personal Portfolio Website using Laravel 12**.

The website should be modern, responsive, clean, easy to maintain, and suitable for a software developer / full-stack developer portfolio.

Use:

* Laravel 12
* Vue 3
* Tailwind CSS
* Alpine.js where needed
* MySQL
* Laravel Authentication
* Eloquent ORM
* Laravel validation
* Laravel file storage
* Laravel pagination
* Laravel middleware
* Laravel route model binding



The system should have two main parts:

1. Public portfolio website
2. Admin dashboard

---

# 1. PUBLIC WEBSITE

Create a professional public portfolio website.

Main navigation:

* Home
* About
* Skills
* Projects
* Experience
* Education
* Certificates
* Blog
* Contact
* Download CV

The header should be responsive and include a mobile menu.

The footer should include:

* Name
* Short introduction
* Social links
* Quick navigation
* Contact information
* Copyright

---

# 2. HOME PAGE

Create a modern landing page.

The hero section should include:

* Developer name
* Professional title
* Short introduction
* Profile image
* View Projects button
* Contact Me button
* Download CV button
* Social links

Example:

Hi, I'm [Name]

Full-Stack Developer

I build modern web applications, REST APIs, admin dashboards, and scalable backend systems.

Buttons:

* View My Work
* Download CV
* Contact Me

Below the hero section display:

* About preview
* Main technologies
* Featured projects
* Experience preview
* Latest blog posts
* Contact call-to-action

Also show summary information such as:

* Number of projects
* Years of experience
* Technologies used
* Certificates

These statistics should come from the database where possible.

---

# 3. ABOUT ME

Create a complete About page.

Information should include:

* Full name
* Job title
* Professional biography
* Profile image
* Location
* Phone number
* Website
* Years of experience
* Personal introduction
* Career goals
* Developer journey
* Languages
* Main interests
* CV download

Admin should be able to update this information.

---

# 4. SKILLS

Create a Skills page.

Skills should be grouped by category.

Example categories:

Frontend:

* HTML
* CSS
* JavaScript
* Tailwind CSS
* Vue.js
* React
* Nuxt

Backend:

* PHP
* Laravel
* Java
* Spring Boot
* REST API

Database:

* MySQL
* PostgreSQL
* Redis

DevOps:

* Linux
* AWS
* Nginx
* Docker
* Git
* GitHub
* Bitbucket

Tools:

* VS Code
* Postman
* DBeaver
* Figma

Each skill should contain:

* Name
* Category
* Icon
* Sort order

Do not use fake percentage progress bars.

Prefer clean technology cards or badges.

---

# 5. PROJECTS

Projects are one of the most important parts of the portfolio.

Create:

`/projects`

Show projects as responsive cards.

Each card should contain:

* Cover image
* Project title
* Short description
* Technologies
* Project status
* GitHub link
* Demo link
* View Details button

Support filters such as:

* All
* Featured
* Completed
* In Progress
* By technology

Support project search.

Use pagination when there are many projects.

---

# 6. PROJECT DETAIL PAGE

Route example:

`/projects/{slug}`

Display:

* Project name
* Cover image
* Project gallery
* Short description
* Full description
* Problem being solved
* Project objectives
* My responsibilities
* Main features
* Technologies
* Challenges
* Solutions
* Architecture explanation
* Development dates
* Project status
* GitHub link
* Live demo link

Example sections:

Overview

Problem

Solution

Key Features

Technologies

My Responsibilities

Challenges & Solutions

Screenshots

Links

Allow multiple images for each project.

Images should support captions and custom display order.

---

# 7. EXPERIENCE

Create an Experience page using a timeline design.

Each experience should include:

* Company name
* Position
* Location
* Start date
* End date
* Current position indicator
* Description
* Responsibilities

Admin should be able to add, edit, delete, reorder, and manage experience records.

If `is_current = true`, display:

Present

instead of an end date.

---

# 8. EDUCATION

Create an Education section.

Each education entry should contain:

* School / university
* Degree
* Major
* Start date
* End date
* Description

Display education using cards or a timeline.

---

# 9. CERTIFICATES

Create a Certificates page.

Each certificate should contain:

* Certificate title
* Issuer
* Issue date
* Credential ID
* Certificate image
* Credential URL

Allow users to click:

View Certificate

Admin should be able to upload certificate images.

---

# 10. RESUME / CV

Allow the admin to upload a CV PDF.

Public users should have:

* View CV
* Download CV

Store the file securely using Laravel storage.

Admin should be able to replace the CV.

---

# 11. BLOG

Create a complete blog module.

Routes:

`/blog`

`/blog/{slug}`

Each blog post should include:

* Title
* Slug
* Cover image
* Excerpt
* Content
* Categories
* Author
* Status
* Published date

Statuses:

* Draft
* Published

Only published posts should appear publicly.

Support:

* Blog search
* Category filtering
* Pagination
* Recent posts
* Related posts

Blog detail page should display:

* Cover image
* Title
* Published date
* Categories
* Main content
* Related posts

---

# 12. BLOG CATEGORIES

Admin should be able to manage blog categories.

Each category contains:

* Name
* Slug
* Description

Blog posts can belong to multiple categories.

Use a pivot table.

---

# 13. CONTACT PAGE

Create a Contact page.

Display:

* Email
* Phone
* Social links
* Location

Create a contact form with:

* Name
* Email
* Subject
* Message

Validation is required.

When submitted:

* Save the message to the database
* Show a success notification
* Prevent duplicate rapid submissions
* Protect against spam where possible

Admin dashboard should show incoming messages.

Message status:

* New
* Read
* Replied

Admin should be able to:

* View
* Mark as read
* Mark as replied
* Delete

---

# 14. SOCIAL LINKS

Create reusable social links.

Support:

* GitHub
* LinkedIn
* Telegram
* Facebook
* YouTube
* Email
* Personal website

Each record contains:

* Name
* URL
* Icon
* Sort order

Admin should be able to reorder links.

---

# 15. TESTIMONIALS

Create a testimonial section.

Each testimonial should contain:

* Name
* Position
* Company
* Message
* Avatar
* Approval status
* Sort order

Only approved testimonials should appear publicly.

Admin can:

* Add
* Edit
* Delete
* Approve
* Unapprove
* Reorder

---

# 16. ADMIN AUTHENTICATION

Create secure admin authentication.

Routes:

`/admin/login`

`/admin`

Only authenticated administrators can access the admin dashboard.

Use middleware.

Example:

`auth`

Optionally use an admin role.

Users table should contain:

* id
* name
* email
* password
* role

Roles:

* admin
* user

Public registration is not required unless needed.

---

# 17. ADMIN DASHBOARD

Create a professional admin dashboard.

Sidebar:

Dashboard

Profile

Projects

Skills

Skill Categories

Experience

Education

Certificates

Blog Posts

Blog Categories

Testimonials

Contact Messages

Social Links

Resume

Settings

Logout

Dashboard overview should show summary cards:

* Total Projects
* Featured Projects
* Total Skills
* Total Blog Posts
* Published Posts
* Certificates
* Contact Messages
* New Messages

Also show:

* Recent contact messages
* Recent projects
* Recent blog posts

---

# 18. PROFILE MANAGEMENT

Admin page:

`/admin/profile`

Allow admin to update:

* Name
* Job title
* Bio
* Avatar
* Location
* Phone
* Website
* Years of experience
* CV

Validate uploaded files.

Remove old images when a new image replaces them.

---

# 19. PROJECT MANAGEMENT

Create full CRUD for projects.

Admin can:

* Create project
* Edit project
* Delete project
* View project
* Upload cover image
* Upload multiple screenshots
* Attach technologies
* Mark featured
* Change project status
* Add GitHub URL
* Add demo URL
* Set start date
* Set completion date

Project statuses:

* Draft
* In Progress
* Completed
* Archived

Generate slug automatically from title.

Slug must be unique.

Allow manual slug editing if necessary.

---

# 20. PROJECT IMAGE MANAGEMENT

Each project can have multiple images.

Fields:

* Project
* Image
* Caption
* Sort order

Admin should be able to:

* Upload images
* Delete images
* Reorder images

---

# 21. TECHNOLOGY MANAGEMENT

Create a technology module.

Fields:

* Name
* Icon

Examples:

* Laravel
* PHP
* Vue
* React
* Java
* Spring Boot
* MySQL
* PostgreSQL
* Docker
* AWS

Projects have a many-to-many relationship with technologies.

---

# 22. SKILL CATEGORY MANAGEMENT

Admin can manage skill categories.

Fields:

* Name
* Description
* Sort order

Examples:

* Frontend
* Backend
* Database
* DevOps
* Tools

---

# 23. SKILL MANAGEMENT

Each skill belongs to a category.

Fields:

* Skill category
* Name
* Icon
* Sort order

Admin can:

* Create
* Edit
* Delete
* Reorder

---

# 24. EXPERIENCE MANAGEMENT

Full CRUD.

Fields:

* Company
* Position
* Location
* Start date
* End date
* Is current
* Description

If current is selected, end date should not be required.

---

# 25. EDUCATION MANAGEMENT

Full CRUD.

Fields:

* School
* Degree
* Major
* Start date
* End date
* Description

---

# 26. CERTIFICATE MANAGEMENT

Full CRUD.

Fields:

* Title
* Issuer
* Issue date
* Credential ID
* Certificate image
* Credential URL

---

# 27. BLOG MANAGEMENT

Admin can:

* Create posts
* Save drafts
* Publish posts
* Edit
* Delete
* Upload cover image
* Select multiple categories
* Schedule or set publish date

Use a good text editor.

Slug should automatically generate from title.

---

# 28. CONTACT MESSAGE MANAGEMENT

Create an admin inbox.

Table columns:

* Name
* Email
* Subject
* Status
* Date
* Actions

Statuses should have clear badges.

Admin can open a message and see the complete message.

Support:

* Mark read
* Mark replied
* Delete

---

# 29. SETTINGS

Create a general settings page.

Settings can include:

* Website name
* Website title
* Meta description
* Logo
* Favicon
* Contact email
* Contact phone
* Footer text
* Google Analytics ID
* SEO information

Use key-value storage.

---

# 30. DATABASE

Create migrations for:

users

profiles

social_links

skill_categories

skills

projects

project_images

technologies

project_technologies

experiences

educations

certificates

blogs

blog_categories

blog_category_post

contact_messages

testimonials

settings

---

# 31. DATABASE RELATIONSHIPS

User:

* hasOne Profile
* hasMany Projects
* hasMany Experiences
* hasMany Educations
* hasMany Certificates
* hasMany Blogs

Profile:

* belongsTo User
* hasMany SocialLinks

SkillCategory:

* hasMany Skills

Skill:

* belongsTo SkillCategory

Project:

* belongsTo User
* hasMany ProjectImages
* belongsToMany Technologies

ProjectImage:

* belongsTo Project

Technology:

* belongsToMany Projects

Experience:

* belongsTo User

Education:

* belongsTo User

Certificate:

* belongsTo User

Blog:

* belongsTo User
* belongsToMany BlogCategories

BlogCategory:

* belongsToMany Blogs

---

# 32. SEO

Add basic SEO support.

Each public page should support:

* Page title
* Meta description
* Canonical URL

Project and blog detail pages should have dynamic meta information.

Add Open Graph metadata for social sharing.

Add:

* sitemap.xml
* robots.txt

Use meaningful URLs.

Example:

`/projects/attendance-management-system`

instead of:

`/projects/15`

---

# 33. RESPONSIVE DESIGN

The website must work well on:

* Desktop
* Laptop
* Tablet
* Mobile

Test:

* Navbar
* Cards
* Images
* Forms
* Tables
* Admin sidebar

Use Tailwind responsive utilities.

---

# 34. DARK MODE

Add optional dark mode.

Support:

* Light
* Dark

Save user's preference in local storage.

The portfolio should look professional in both modes.

---

# 35. UI / UX STYLE

Use a clean developer portfolio style.

Avoid overly complicated animation.

Design requirements:

* Large clean typography
* Good spacing
* Rounded cards
* Consistent buttons
* Responsive grid
* Clear hierarchy
* Modern navbar
* Professional project cards
* Clean admin tables
* Status badges
* Loading indicators
* Empty states
* Confirmation dialogs

Avoid excessive gradients and unnecessary visual effects.

---

# 36. ALERTS AND NOTIFICATIONS

For admin actions show notifications:

* Created successfully
* Updated successfully
* Deleted successfully
* Upload successful
* Error message

For deletion, ask for confirmation first.

---

# 37. VALIDATION

Use Laravel Form Request validation.

Examples:

Project:

* title required
* slug unique
* description required
* URLs must be valid
* cover image must be an image

Contact:

* name required
* email required and valid
* subject required
* message required

Certificate:

* title required
* issuer required
* issue date valid

Show validation errors near corresponding inputs.

---

# 38. FILE UPLOADS

Use Laravel Storage.

Structure files logically.

Example:

storage/app/public/

profiles/

projects/

certificates/

blog/

resume/

Use:

`php artisan storage:link`

Validate:

* File type
* File size
* Image type

Delete unused files when records are deleted.

---

# 39. SECURITY

Implement standard Laravel security practices.

Include:

* CSRF protection
* XSS prevention
* Validation
* Authorization
* Authentication
* Password hashing
* Secure file upload
* Rate limiting for contact form
* Protection against mass assignment

Do not store plain-text passwords.

---

# 40. PERFORMANCE

Use:

* Eager loading
* Pagination
* Database indexes
* Optimized images
* Laravel caching where useful

Avoid N+1 database queries.

Example:

Projects should eager-load technologies and images.

---

# 41. SEARCH

Add search to:

Projects

Blog

Admin projects

Admin blog posts

Contact messages

Search relevant columns such as:

* Title
* Description
* Name
* Email
* Subject

---

# 42. FILTERING

Projects can filter by:

* Status
* Featured
* Technology

Blogs can filter by:

* Category
* Status
* Publish date

Contact messages can filter by:

* New
* Read
* Replied

---

# 43. SORTING

Admin should support useful ordering.

Examples:

Projects:

* Newest
* Oldest
* Title

Messages:

* Newest
* Oldest

Skills:

* Custom sort order

Social links:

* Custom sort order

---

# 44. PAGINATION

Use server-side pagination.

Do not fetch everything at once.

Example:

Admin tables:

10 or 20 records per page.

Public project page:

6-12 projects per page.

Public blog:

6-10 posts per page.

Pagination must be based on backend pagination metadata.

---

# 45. EMPTY STATES

If no data exists, show friendly empty states.

Examples:

No projects available yet.

No blog posts published yet.

No contact messages.

No certificates available.

Do not show broken layouts.

---

# 46. ERROR PAGES

Create custom pages for:

403

404

419

500

404 should include a button:

Back to Home

---

# 47. SEEDERS

Create seeders for development.

Seed:

* Admin user
* Profile
* Skills
* Skill categories
* Technologies
* Sample projects
* Sample experience
* Sample education
* Sample certificates
* Blog categories
* Sample blog posts
* Settings

Example admin credentials should only be used for local development and must be changed before production.

---

# 48. ADMIN USER

Create a default development admin.

Example:

Email:

[admin@example.com](mailto:admin@example.com)

Password:

password

Clearly document that this must be changed in production.

---

# 49. CODE STRUCTURE

Keep code organized.

Use:

Controllers

Models

Form Requests

Policies where needed

Services only when business logic becomes complex

Blade Components

Layouts

Middleware

Avoid putting large amounts of logic directly inside Blade files.

---

# 50. BLADE COMPONENTS

Create reusable components.

Examples:

Navbar

Footer

Button

Project Card

Skill Card

Blog Card

Certificate Card

Alert

Modal

Pagination

Admin Sidebar

Admin Header

Form Input

Textarea

Select

Status Badge

Empty State

---

# 51. ROUTE STRUCTURE

Public routes:

`/`

`/about`

`/skills`

`/projects`

`/projects/{project:slug}`

`/experience`

`/education`

`/certificates`

`/blog`

`/blog/{blog:slug}`

`/contact`

Admin:

`/admin`

`/admin/profile`

`/admin/projects`

`/admin/skills`

`/admin/skill-categories`

`/admin/technologies`

`/admin/experience`

`/admin/education`

`/admin/certificates`

`/admin/blog`

`/admin/blog-categories`

`/admin/testimonials`

`/admin/messages`

`/admin/social-links`

`/admin/settings`

---

# 52. HOME PAGE FEATURED DATA

Display only important content.

Featured projects:

Only projects where:

`featured = true`

Latest blog posts:

Only published posts.

Skills:

Display selected or ordered skills.

Testimonials:

Only approved testimonials.

---

# 53. PROJECT STATUS

Use enum-like values:

draft

in_progress

completed

archived

Show clean status badges.

---

# 54. BLOG STATUS

Use:

draft

published

Only published articles should be visible publicly.

---

# 55. CONTACT MESSAGE STATUS

Use:

new

read

replied

New messages should be highlighted in admin.

---

# 56. TESTIMONIAL APPROVAL

Use:

`is_approved`

Only show approved testimonials to public visitors.

---

# 57. ADMIN DASHBOARD DESIGN

Use a sidebar layout.

Desktop:

Sidebar + content.

Mobile:

Collapsible sidebar.

Topbar:

* Page title
* Admin profile
* Logout

Dashboard cards should be simple and professional.

Avoid making the dashboard too crowded.

---

# 58. PROJECT SCREENSHOT GALLERY

Create a gallery on project details.

Support:

* Multiple screenshots
* Thumbnail view
* Click to enlarge
* Caption
* Sort order

Use Alpine.js for modal/lightbox behavior if needed.

---

# 59. TECHNOLOGY BADGES

Project cards and detail pages should show technology badges.

Example:

Laravel

Vue

MySQL

AWS

Docker

Clicking a technology may filter projects using that technology.

---

# 60. ACCESSIBILITY

Follow basic accessibility requirements.

Use:

* Semantic HTML
* Alt text
* Proper labels
* Keyboard-friendly buttons
* Good contrast
* Visible focus states

---

# 61. DEPLOYMENT READY

Prepare the Laravel project for production.

Include instructions for:

Clone repository

Install Composer dependencies

Install Node dependencies

Configure `.env`

Generate app key

Configure MySQL

Run migrations

Run seeders

Create storage link

Build frontend assets

Set correct permissions

Configure Nginx

Configure PHP-FPM

Configure SSL

Use production settings.

Typical commands:

composer install

npm install

npm run build

php artisan key:generate

php artisan migrate --force

php artisan storage:link

php artisan optimize

---

# 62. README

Create a detailed README.md.

Include:

Project overview

Features

Technology stack

Requirements

Installation

Environment configuration

Database setup

Admin login

Development commands

Production deployment

Folder structure

Screenshots section

---

# 63. FINAL EXPECTED RESULT

The finished system should provide:

A professional public developer portfolio.

A secure Laravel admin dashboard.

Dynamic profile management.

Project management.

Project screenshot gallery.

Skill and technology management.

Experience management.

Education management.

Certificate management.

Blog system.

Contact system.

Testimonials.

Social links.

Resume management.

SEO support.

Responsive design.

Dark mode.

Search.

Filtering.

Pagination.

Validation.

File uploads.

Secure authentication.

Clean Laravel architecture.

The website should feel like a real professional software developer portfolio and not like a basic student CRUD project.

Prioritize these sections:

1. Projects
2. About Me
3. Experience
4. Skills
5. Contact
6. Blog
7. Certificates

The project section should be especially detailed because it is the strongest proof of the developer's skills and experience.

Build the system step by step using Laravel best practices, clean database relationships, maintainable Blade components, and a professional UI.
