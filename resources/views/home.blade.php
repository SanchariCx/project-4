@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
           <form action="/CreateAlbum/{{auth()->id()}}" method="post" id="albumcreate">
                {{ csrf_field()}}
                    @if ($errors->any())
                    @foreach ($errors as $error)
                    @endforeach
                    @endif    
                        <div class="form-group">
                                <label for="Album Name">Album Name:</label>
                                <input type="text" class="form-control" id="name" name='name'>
                        </div>
                        <div class="form-group">
                            <label for="Album Description">Album Description:</label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                        <button type="submit" class="btn btn-default" >Create Album</button>             
                    </form>
            </div>
    </div>
</div>
<div id="album-list">
</div>
<script>   
    $(document).ready(function(){
    fetchalbums();
    createalbums();
   
    });
    
    function createalbums()
    {
       $('#albumcreate').submit(function(e){
        e.preventDefault();
        var name = $("#name").val();
        var description = $("#description").val();           
        if(!name || !description)
        {
          alert("please enter the album details");
        }
        create({{auth()->id()}},name,description);
        $("#name").val("");
        $("#description").val("");
        fetchalbums();
       })
    }
    function fetchalbums()
    {
        $.ajax
            ({
            url: "FetchAlbum",
            type:"get",
            success:function(response)
            {   var html = "";
                console.log(response);
                for (let index = 0; index < response.length; index++) 
                {
                    const element = response[index];
                    html += '<div class="col-xs-18 col-sm-6 col-md-3">';
                    html += ' <div class="thumbnail">';
                    html += ' <img src=""class="img-responsive">';
                    html += '  <div class="caption">';
                    html += '  <h4>'+element.name+'</h4>';
                    html += '   <p>'+element.description+'</p>';
                    html += '   <p><a href="ViewAlbum/'+element.id+'" class="btn btn-info btn-xs" role="button">View ('+element.images_count+')</a></p>';
                    html += '  </div>\
                                </div>\
                            </div>';                                  
                }
                $('#album-list').html(html);
                
            },
            error: function(response)
            {
                console.log(response);
            }
            
            });
            
        
    }
</script>
@endsection
