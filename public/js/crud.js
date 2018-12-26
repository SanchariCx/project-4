
function create(id,name,description)
{ var created_status;
//    console.log(id);
//    console.log(name);
//    console.log(description);
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax
({
    url: "CreateAlbum",
    type:"post",
    data :
    {
    status:1,
    "name":name,
    "description":description,
    "user_id":id

    },
    success:function(response)
    {
    if(response)
    {
        console.log(response);
        

    }
    },
    error:function(response)
    {
        created_status = 0;
    }

});

}
function retrive()
{
    $.ajax
    ({
    url: "FetchAlbum",
    type:"get",
    success:function(response)
    { 
        console.log(response);
        return response;
    },
    error: function(response)
    {
        console.log(response);
        return response;
    }
    
    });
    
}
function upload(formdata,callback)
{
  $.ajax({
           type:'POST',
             url:"/imageUpload",
            data:formdata,
            cache:false,
            contentType:false,
            processData:false,
            success:function(data)
            {
                if(data)
                {   
                    console.log(data);
                    callback(true)
                }
               console.log(data); 
            },
            error:function(data){
               console.log(data);
               callback(false)
            }
        });
}

 