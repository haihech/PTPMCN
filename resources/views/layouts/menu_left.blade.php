<div class="col">
	<div class="danhmuc">
		<div class="top">Thương Hiệu</div>
		<div class="element"><form action=""><input type="text" name="" id="mySearchT" placeholder=" search .." onkeyup="searchT({{$thuonghieu}})"></form></div>
		<div id="resultSearch"></div>
		<div id="defaultT">
		@for($i=0,$n=$thuonghieu->count()>8?8:$thuonghieu->count();$i<$n;$i++)
			<div class="element"><a href="{{ route('thuonghieu',$thuonghieu[$i]->id)}}">{{$thuonghieu[$i]->ten}}</a></div>
		@endfor
		</div>
	</div>
	<div class="danhmuc">
		<div class="top">Nhóm Tuổi</div>
		@foreach ($tuoi as $t)
			<div class="element"><a href="{{ route('nhomtuoi',$t->id)}}">{{$t->tuoi}}</a></div>
		@endforeach
	</div>
</div>
<script>
function searchT (data) {
	var input, output, filter, x, i,defaultT;
	input = document.getElementById("mySearchT");
	output = document.getElementById("resultSearch");
	defaultT=document.getElementById('defaultT');
	output.innerHTML='';
	filter = input.value.toUpperCase();
	if(filter!=''){
		defaultT.style.display='none';
		output.style.display='block';
		for(i=0 ;i<data.length;i++){
			x=data[i].ten;
			if(x){
				if(x.toUpperCase().indexOf(filter) > -1)
				{
					output.innerHTML+="<div class='element'><a href='{{ url('thuonghieu/') }}"+"/"+x+"'>"+x+"</a></div>";
				}
			}
		}
	}
	else{
		output.style.display='none';
		defaultT.style.display='';
	}
}
	
</script>
