<h1>{{$data['title']}}</h1>
<h3>By {{$data['creator']}}</h3>

<img style="width:100%;" src="{{$data['filepath'].'/'.$data['filename']}}">
<h4>Category: {{$data['category']}}</h4>
<h4>Deadline: {{$data['deadline']}}</h4
<h4>Funded {{$data['funded']}} coins from {{$data['targetsum']}} coins</h4>
<hr>
<p>{{$data['content']}}</p>

