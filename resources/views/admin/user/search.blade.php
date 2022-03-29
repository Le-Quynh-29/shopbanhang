<form action="" method="GET">
    <div class="form-group row">
        <div class="col-1 col-md-1 col-sm-12">
            <span class="badge badge-success">{{ __('Tìm kiếm theo') }}</span>
        </div>

        <div class="col-2 col-md-2 col-sm-12">
            <select class="form-control" name="search_by" id="search-by-keyword">
                @foreach ($fields as $key => $field)
                    <option value="{!! $key !!}" {!! app('request')->input('search_by') == $key ? 'selected="selected"' : '' !!}>{!! $field !!}</option>
                @endforeach
            </select>
        </div>
        <div class="col-3 col-md-3 col-sm-12">
            <div class="input-group">
                <input class="form-control"  name="search_text" id="search-text" placeholder="{{ __('Từ khóa') }}" value="{!! app('request')->input('search_text') !!}" />
                <select class="form-control" name="search_text" id="search-text-active" style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                    <option value="" {!! app('request')->input('search_text') == "" ? 'selected="selected"' : '' !!}>{{ __('Tất cả') }}</option>
                    <option value="1" {!! app('request')->input('search_text') == "1" ? 'selected="selected"' : '' !!}> {{ __('Đang hoạt động') }}</option>
                    <option value="0" {!! app('request')->input('search_text') == "0" ? 'selected="selected"' : '' !!}>{{ __('Vô hiệu hóa') }}</option>
                </select>
                <span class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="far fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>
