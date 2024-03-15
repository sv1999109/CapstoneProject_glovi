<div class="col-md-4 sidebar blog">
    <div id="floating-side">

        <aside id="custom_html-5" class="widget_text widget widget_custom_html">
            <div class="textwidget custom-html-widget">
                <h3 class="">
                    @lang('messages.Track_Shipment')
                </h3>
                <div class="search">
                    <form method="get" action="{{ route('tracking') }}">
                        <div class="mb-3">
                            <input type="text" name="code" placeholder="@lang('messages.Code')">
                        </div>

                        <button class="button" type="submit">@lang('messages.Track')</button>
                    </form>
                </div>
            </div>
        </aside>
        @if ($post_type == 'blog')
            <aside id="categories-2" class="widget widget_categories">
                <h4 class="sidebar-header">{{ trans_choice('messages.Category', 2) }}</h4>
                <form action="{{ route('blog') }}" method="get">
                    <select name="cat" id="cat" class="postform" onchange="this.form.submit();">
                        <option value="-1">{{ trans_choice('messages.Choose_Category', 1) }}</option>
                        @foreach (DB::table('categories')->where('status', 1)->get() as $item)
                            <option value="{{ $item->id }}">
                                {{ get_content_locale($item->name) }}
                            </option>
                        @endforeach

                    </select>
                </form>
            </aside>
        @endif
    </div>
</div>
