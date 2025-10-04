{!! $xmlDeclaration !!}
{!! $xmlStylesheet !!}

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($posts as $post)
    @php
        $slug =  $post->slug ? $post->slug : slug_format($post->title);
        dump($slug,$post->id);
    @endphp
        <url>
            <loc>{{ url('/' . $post->category->slug . '/' . $slug) }}</loc>
            <loc>{{ route('post', ['slug' => $slug, 'id' => $post->id]) }}</loc>
            <title><![CDATA[{!! $post->title !!} ]]></title>
            <language>{{app()->getLocale()}}</language>
            <genres></genres>
            <keywords><![CDATA[{{ $post->keywords }}]]></keywords>
            <publishedDate>{{ \Carbon\Carbon::parse($post->created_at)->format('Y-m-d H:i:s') }}</publishedDate>
        </url>
    @endforeach
</urlset>
