@if(session()->has('status'))
<div class="alert alert-{{session('status')}} alert-dismissible fade show" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </button>
    {{session('message')}}
</div>
@endif