@extends('admin.layout.app')

@section('content')
<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $title ?? '-' }}</h1>
            {{-- @include('admin.inc.breadcrumb', ['breadcrumbs' => Breadcrumbs::generate('system_settings')]) --}}
        </div>

        <div class="section-body">
            @include('admin.inc.messages')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.system-settings.update') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <?php
                                $errorKeys = array_keys($errors->getMessages());
                                ?>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-4">
                                                @if($setting_fields)
                                                <ul class="nav nav-pills flex-column" role="tablist">
                                                    @foreach ($setting_fields as $key => $item)
                                                    <?php
                                                    $itemKeys = array_keys($item['key']);
                                                    ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($key==0) active @endif @if($errors->hasAny($itemKeys)) bg-danger text-white @endif"
                                                            id="home-tab{{ ($key+1) }}" data-toggle="tab"
                                                            href="{{ '#'.\Str::slug($item['title']) }}" role="tab"
                                                            aria-controls="{{ \Str::slug($item['title']) }}"
                                                            aria-selected="true">{{ $item['title'] }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </div>
                                            <div class="col-12 col-sm-12 col-md-8">
                                                <div class="tab-content no-padding" id="myTab2Content">
                                                    @if($setting_fields)
                                                    @foreach ($setting_fields as $key => $item)
                                                    <div class="tab-pane fade show @if($key==0) active @endif"
                                                        id="{{ \Str::slug($item['title']) }}" role="tabpanel"
                                                        aria-labelledby="{{ $item['title'] }}-tab4">
                                                        @if($item['key'])
                                                        @foreach ($item['key'] as $key1 => $item1)
                                                        @if ($item1['input']=='text')
                                                        <div class="form-group">
                                                            <label for="">{{ $item1['label'] }}</label>
                                                            <input type="{{ $item1['input'] }}"
                                                                class="{{ $item1['class'] }}" name="{{ $key1 }}"
                                                                @if(isset($item1['required']) && $item1['required'])
                                                                required @endif
                                                                value="{{ old($key1) ?? $system_setting[$key1] ?? $item1['title'] ?? '' }}">
                                                            @if ($errors->has($key1))
                                                            <span class="text-danger d-block">
                                                                <strong>{{ $errors->first($key1) }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        @elseif($item1['input']=='textarea')
                                                        <div class="form-group">
                                                            <label for="">{{ $item1['label'] }}</label>
                                                            <textarea class="{{ $item1['class'] }}" name="{{ $key1 }}"
                                                                @if(isset($item1['required']) && $item1['required'])
                                                                required
                                                                @endif>{!! old($key1) ?? $system_setting[$key1] ?? '' !!}</textarea>
                                                            @if ($errors->has($key1))
                                                            <span class="text-danger d-block">
                                                                <strong>{{ $errors->first($key1) }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        @elseif($item1['input']=='number')
                                                        <div class="form-group">
                                                            <label for="">{{ $item1['label'] }}</label>
                                                            <input type="{{ $item1['input'] }}"
                                                                class="{{ $item1['class'] }}" name="{{ $key1 }}"
                                                                @if(isset($item1['required']) && $item1['required'])
                                                                required @endif @if(isset($item1['min']) &&
                                                                $item1['min']) min="{{ $item1['min'] }}" @endif
                                                                @if(isset($item1['max']) && $item1['max'])
                                                                max="{{ $item1['max'] }}" @endif
                                                                value="{{ old($key1) ?? $system_setting[$key1] ?? $item1['title'] ?? '' }}">
                                                            @if ($errors->has($key1))
                                                            <span class="text-danger d-block">
                                                                <strong>{{ $errors->first($key1) }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                        @elseif($item1['input']=='file')
                                                        <div class="form-group">
                                                            <label for="">{{ $item1['label'] }}</label>
                                                            <input type="{{ $item1['input'] }}"
                                                                class="{{ $item1['class'] }}" name="{{ $key1 }}"
                                                                @if(isset($item1['required']) && $item1['required'])
                                                                required @endif @if(isset($item1['accept']) &&
                                                                $item1['accept']) accept="{{ $item1['accept'] ?? '' }}"
                                                                @endif>
                                                            @if(isset($item1['format']) && isset($item1['pixel']))
                                                            <span
                                                                class="text-muted">{{ fileReadText([$item1['format'] ?? ''], $item1['size'] ?? '', $item1['pixel'] ?? '') }}</span><br />
                                                            @endif
                                                            @if ($errors->has($key1))
                                                            <span class="text-danger d-block">
                                                                <strong>{{ $errors->first($key1) }}</strong>
                                                            </span>
                                                            @endif
                                                            @if($system_setting)
                                                            @if (isset($system_setting[$key1]))
                                                            <img src="{{ asset($system_setting[$key1]) }}"
                                                                alt="{{ $system_setting[$key1] ?? '' }}"
                                                                width="100px" style=" @if(in_array($key1,['footer_logo','managed_by_logo'])) background: #000000; padding:10px; @endif" />
                                                            @endif
                                                            @endif
                                                        </div>
                                                        @endif
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                                Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(function() {
        $('.positive-integer').numeric(
            {negative: false}
        );
    })
</script>
@endsection
