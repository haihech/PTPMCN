@foreach($news as $e)
<a href=""><img src="{{ asset('upload/logo/'.$e->anh) }}" alt=""><span class="tintuc_title">{{$e->tieude}}</span></a>
@endforeach