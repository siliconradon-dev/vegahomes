@if (session('status'))
    <div id="flash-status" style="position:fixed;top:90px;right:20px;z-index:9999999;max-width:360px;background:#1b7f3b;color:#fff;padding:14px 18px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.25);font-size:15px;">
        {{ session('status') }}
    </div>
    <script>setTimeout(function(){var e=document.getElementById('flash-status');if(e){e.style.display='none';}},5000);</script>
@endif
@if ($errors->any())
    <div style="position:fixed;top:90px;right:20px;z-index:9999999;max-width:360px;background:#b3261e;color:#fff;padding:14px 18px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.25);font-size:15px;">
        {{ $errors->first() }}
    </div>
@endif
