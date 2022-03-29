<form action="" method="GET">
    <div class="form-group row">
        <div class="col-1 col-md-1 col-sm-12">
            <span class="badge badge-success">{{ __('Tìm kiếm theo') }}</span>
        </div>

        <div class="col-2 col-md-2 col-sm-12">
            <select class="form-control" name="search_by">
                @foreach ($fields as $key => $field)
                    <option value="{!! $key !!}" {!! app('request')->input('search_by') == $key ? 'selected="selected"' : '' !!}>{!! $field !!}</option>
                @endforeach
            </select>
        </div>

        <div class="col-3 col-md-3 col-sm-12">
            <div class="input-group">
                <input class="form-control" name="search_text" placeholder="{{ __('Từ khóa') }}" value="{!! app('request')->input('search_text') !!}" />
                <span class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <i class="far fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </div>
</form>
