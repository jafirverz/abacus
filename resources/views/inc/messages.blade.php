@if (session('success'))
<div class="alert alert-success alert-dismissible show fade">
    <div class="alert-title">Success</div>
    <div class="alert-body">
        {{ session('success') }}
    </div>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-title">Error</div>
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ session('error') }}
    </div>
</div>
@endif
@if(session('info'))
<div class="alert alert-info alert-dismissible show fade">
    <div class="alert-title">Info</div>
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ session('info') }}
    </div>
</div>
@endif
@if(session('warning'))
<div class="alert alert-warning alert-dismissible show fade">
    <div class="alert-title">Warning</div>
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ session('warning') }}
    </div>
</div>
@endif
