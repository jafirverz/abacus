<a class="btn-control-notext show-991" href="#nav">Select</a>
<ul id="nav" class="nav-1 hide-991">
	<?php
    $list = [
        [
            'title' => '<i class="fas fa-user"></i> My profile</a>',
            'url' => url('my-profile'),
        ],
        [
            'title' => '<i class="fas fa-credit-card"></i> S&P Agreement',
            'url' => url('my-forms'),
        ],
		[
            'title' => '<i class="fas fa-credit-card"></i> Loan Applications',
            'url' => url('loan-applications'),
        ],
		[
            'title' => '<i class="fas fa-shield-alt"></i> Insurance Applications',
            'url' => url('insurance-applications'),
        ],
        [
            'title' => '<i class="fas fa-file-alt"></i>Archived Forms</a>',
            'url'   =>  url('my-forms/archived'),
			'sub_menu' => [
                            [
                                'title' =>  'S&P Agreement',
                                'url'   =>  url('my-forms/archived'),
                            ],
							[
								'title' =>  'Loan',
								'url'   =>  url('loan-archived'),
							],
                            [
								'title' =>  'Insurance',
								'url'   =>  url('insurance-applications/archived/show'),
							],
                            
                         ]
        ],
		[
            'title' => '<i class="fas fa-car"></i>My Car Listing</a>',
            'url' => url('my-cars'),
        ],
        [
            'title' => '<i class="fas fa-car"></i>My Quote Requests</a>',
            'url' => url('my-quote-requests'),
        ],
        [
            'title' => '<i class="fas fa-car"></i>My Invoices</a>',
            'url' => url('my-invoices'),
        ],
        /*[
            'title' => '<i class="fas fa-question-circle"></i> Enquiries</a>',
            'url' => url('enquiries'),
        ],
        [
            'title' => '<i class="fas fa-retweet"></i> Transactions</a>',
            'url' => url('transaction'),
        ],
        [
            'title' => '<i class="fas fa-comment-dots"></i> Messages</a>',
            'url' => url('messages'),
        ],*/
        [
            'title' => '<i class="fas fa-comment-alt-lines"></i> My Chats</a>',
            'url' => url('my-chats'),
        ],
        [
            'title' => '<i class="fas fa-power-off"></i> Logout</a>',
            'url' => url('logout'),
        ],
    ]

?>
@if($list)
@foreach ($list as $item)
<li @if(stripos(url()->current(), $item['url'])!==false) class="active" @endif>
<a href="{{ $item['url'] }}">{!! $item['title'] !!}</a>
				@if(Arr::has($item, 'sub_menu'))
                <ul class="active opened">
                    @if($item['sub_menu'])
                    @foreach ($item['sub_menu'] as $subitem)
                    <li @if(Str::contains(url()->current(), $subitem['url'])!==false) class="active" @endif><a
                            href="{{ url($subitem['url']) }}">{{ $subitem['title'] }}</a></li>
                    @endforeach
                    @endif
                </ul>
                @endif
</li>
@endforeach
@endif

							</ul>
