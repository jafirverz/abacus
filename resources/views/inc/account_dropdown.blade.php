<?php
    $list = [
        [
            'title' => 'My Profile',
            'url' => url('my-profile'),
        ],
        [
            'title' => 'Enquiry History',
            'url' => url('enquiry-history'),
        ],
        [
            'title' => 'Transaction History',
            'url' => url('transaction-history'),
        ],
        [
            'title' => "‘Notify Me’ List",
            'url' => url('notify-list'),
        ],
        [
            'title' => 'Make & Model Preference',
            'url' => url('preference'),
        ],
    ]
?>
@if($list)
@foreach ($list as $item)
<li @if(stripos(url()->current(), $item['url'])!==false) class="active" @endif><a href="{{ $item['url'] }}">{{ $item['title'] }}</a></li>
@endforeach
@endif
