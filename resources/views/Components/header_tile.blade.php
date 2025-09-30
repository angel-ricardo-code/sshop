
@props(['active' => false])

<li class="{{$active ? 'active tile' : 'tile'}} ">
    <a href="{{$link}}">
      {{$svg}}
    </a>
</li>
