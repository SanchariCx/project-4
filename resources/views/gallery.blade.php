@extends('layouts.app')
@section('content')

<form  class="form-group" action="/uploadImage/{{$id}}" enctype="multipart/form-data" method="post" id="ImageUploadForm" name="ImageUploadForm">
    {{csrf_field()}}

    <div class="form-group">
        <label class="btn btn-default btn-file">
                upload Image <input type="file" style="display: none;"  name="image" id="album-image">
        </label>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="caption">Caption</label>
            <input type="text" class="form-control" name="caption" id="caption">
            <input type="hidden" class="form-control" name="album_id" id="album_id" value={{$id}}>
        </div>
        <div class="form-group">
        <select name="view_status" id="input" class="form-control" id="view_status">
                <option value="">-- Privacy --</option>
                <option value="1">public</option>
                <option value="0">private</option>
        </select>
        <div class="form-group">
                <input type="submit" value="Save" name="image-upload">
             </div>
    </div>
    <img src="" alt="" >
    </div>

 </form>
  <div id="image-list"></div>  
  <script>   
    $(document).ready(function(){
    viewImages();
    imageUpload();
    });
    function imageUpload()
    {
        $('#ImageUploadForm').submit(function(e){
        e.preventDefault();
        var formdata  = new FormData(this);
        upload(formdata, function(status){
            if(status){
                $("#caption").val("");
                $("#view_status").val("");
                viewImages();  
                return;
            }
            alert("error");
        });
         
    });
    }
    function viewImages()
    {
        var album_id = document.forms["ImageUploadForm"]["album_id"].value;
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
           });
        $.ajax({
                url:"/retrieve",
                type:'post',
                data:{
                    status:1,
                    'album_id':album_id,
                },
                success:function(response)
                {
                    console.log(response);
                    var html = "";
                    
                for (let index = 0; index < response.length; index++) 
                {       
                        const element = response[index];
                        html += '<div class="col-xs-18 col-sm-6 col-md-1">';
                        html += ' <div class="thumbnail" id="'+element.id+'-div">';
                        html += ' <img src="'+element.img_url+'"class="img-responsive">';
                        html += '  <div class="caption">';
                            html += '   <p>Album: '+element.album.name+'</p>';
                        html += '   <p>'+element.caption+'</p>';
                        html += '   <button type="submit" class="btn btn-info" name="delete-image" onclick ="deleteimage('+element.id+')">Delete</button>';
                        html += '  </div>\
                                </div>\
                            </div>';          
                }
                $('#image-list').html(html);                            
                },
                error:function(response)
                { 
                    console.log(response);
                }
    
            });
            
    }
    function deleteimage(imageid)
    {
        $.ajax({
            url:"/delete",
            type:'post',
            data:{
                status:1,
                'image_id':imageid,
            },
            success:function(response)
            {   
                var imagediv = $('#'+imageid+'-div');
               if(response.status)
               {
                  imagediv.remove();
               }
            }

        })
    }

    </script>
@endsection
