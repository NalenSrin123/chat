<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($urls as $url)<url><loc>{{ $url }}</loc></url>@endforeach
@foreach($projects as $project)<url><loc>{{ route('projects.show',$project->slug) }}</loc><lastmod>{{ $project->updated_at->toAtomString() }}</lastmod></url>@endforeach
@foreach($blogs as $blog)<url><loc>{{ route('blog.show',$blog->slug) }}</loc><lastmod>{{ $blog->updated_at->toAtomString() }}</lastmod></url>@endforeach
</urlset>
