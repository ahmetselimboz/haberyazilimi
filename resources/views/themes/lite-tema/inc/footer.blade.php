@if (\Illuminate\Support\Facades\Storage::disk('public')->exists('main/sortable_list.json'))
@foreach (\Illuminate\Support\Facades\Storage::disk('public')->json('main/sortable_list.json') as $block)
    @if ($block['type'] == 'menu' and ($block['design'] == 1 or $block['design'] == 2))
        @include($theme_path . '.main.block_main_menu', [
            'menu_id' => $block['menu'],
            'design' => $block['design'],
        ])
    @endif
@endforeach
@endif