<script type="text/javascript">
//get name of model (event or folder) from id of form 
if(document.getElementById("news")){
var model= 'news'
}else{
var model= 'folder'
}
//------------------------------------------------
  Dropzone.autoDiscover = false;
  var uploadedFiles = {}
  let fileDropzone = new Dropzone('#file-drop', {
    url: `{{url('${model}/file')}}`,
    maxThumbnailFilesize: 1, // MB
    acceptedFiles: ".pdf,.xlsx",
    addRemoveLinks: true,
    headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
    success: function (file, response) {
        console.log(response);
      $('form').append('<input id="my" type="hidden" name="file[]" value="' + response.id + '">')
      uploadedFiles[file.name] = response.id
     },
    removedfile: function (file) {
                file.previewElement.remove()
                let id = '';
                    id = uploadedFiles[file.name];
                    $.ajax({
                      type:"GET",
                      url:'/delete-file/'+id ,
                    });
                $('form').find('input[name="file[]"][value="'+ id +'"]').remove()
     },
    init:function(){
        @if(isset($news))
        var Id = $('#objId').val();  
        myDropzonefile = this;
        $.ajax({
        type:"POST",
        headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
        url:`{{url('${model}/get-files')}}?id=`+Id,    //use ${model-name} in url 
        success: function(data){
          if(data){
            data.forEach(myFunction);
            function myFunction(item, index) {
            var ext = item.file.split('.').pop();
            var mockFile = {name: item.file};
            myDropzonefile.options.addedfile.call(myDropzonefile, mockFile)
            myDropzonefile.options.thumbnail.call(myDropzonefile, mockFile,`{{ Storage::url('${mockFile.name}') }}`)
            if (ext == "pdf") {
              $(mockFile.previewElement).find(".dz-image img").attr("src", "{{ Storage::url('pdf.png') }}")
            }else if(ext == "xlsx"){
              $(mockFile.previewElement).find(".dz-image img").attr("src", "{{ Storage::url('excel.png') }}")
            }
            $('form').append('<input id="my" type="hidden" name="file[]" value="' + item.id + '">')
            uploadedFiles[mockFile.name]=item.id
          }   
        }else{ 
          $("#form").empty()
        }  
       }
      });
      @endif
    },           
  })
</script>