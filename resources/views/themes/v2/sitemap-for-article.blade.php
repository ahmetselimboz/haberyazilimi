{!! $xmlDeclaration !!}
{!! $xmlStylesheet !!}

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($articles as $article)
        <url>
            <loc>{{ route('article', ['slug' => $article->slug, 'id' => $article->id]) }}</loc>
            <title><![CDATA[{{ $article->title }}]]></title>
            <language>tr</language>
            <genres></genres>
            <keywords></keywords>
            <publishedDate>{{ \Carbon\Carbon::parse($article->created_at)->format('Y-m-d H:i:s') }}</publishedDate>
        </url>
    @endforeach
</urlset>