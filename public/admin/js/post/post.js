$("input[name=generate_description]").on("click", function () {
    if ($(this).val() == "ai") {
        $("#aiTextGenerateModel").modal("show");
    } else {
        $("#aiTextGenerateModel").modal("hide");
    }
});

$("#ai_text").on("keyup", function () {
    var words = $(this).text().trim().split(" ");
    if (words.length > 2) {
        $(".textGenerate").removeClass("disabled");
        $(".textGenerate").addClass("show");
    } else {
        $(".textGenerate").removeClass("show");
        $(".textGenerate").addClass("disabled");
    }
});

$(".textGenerate").on("click", function () {
    $(".AIButton").show();
    $(".textGenerate").hide();
    $(".textGeneratelod").show();
    const csrfToken = $("meta[name=csrf-token]").attr("content");
    const data = { _token: csrfToken, text: $("#ai_text").text().trim() };
    const getResponse = ajaxUrl(AITextGenerate, "POST", data);
    getResponse.done(function (res) {
        tinymce.get("summernote").setContent(res?.results);
        // $('.textGenerate').html('AI TEXT REGENERATE');
        $(".textGenerate").show();
        $(".textGeneratelod").hide();
        $(".AIButton").hide();
        $("#aiTextGenerateModel").modal("hide");
        $("#ai_text").html("");
    });
});
$(document).on('click','#crossPreBtn',function(){
    const removeImage  = $(this).attr('data-remove-image');
    for (let i = 0; i < imagefiles.length; i++) {
        // Remove the file with the specified FID from the filesToUpload array
        if (i == removeImage) {
            imagefiles.splice(i, 1);
            break;
        }
    }
    $(this).parent('.prechoosimg').remove();
});
var imagesPreview = function (input, placeToInsertImagePreview) {
    if (input.files) {
        // console.warn('files',input.files);
        var filesAmount = input.files.length;
        var TotalImages = $('.preImageBox').length + filesAmount;
        if(TotalImages<11){
            for (A = 0; A < filesAmount; A++) {
                var reader = new FileReader();
                reader.i = A;
                let myFile = input.files[A];
                imagefiles.push(myFile);
               
                reader.onload = function (event){
                    
                    let Html='';
                    Html +='<div class="col-md-2 prechoosimg">';
                    Html +='<img class="defaultimg" src="'+event.target.result +'">';
                    Html +='<a href="javascript:void(0)" data-remove-image="'+this.i+'" class="crossbtn" id="crossPreBtn"><i class="fas fa-times"></i> </a>';
                        Html +='<div class="form-check">';
                            Html +='<input name="primary[]" class="form-check-input" value="'+this.i+'" type="radio" id="primaryPre'+this.i+'">';
                            Html +='<label class="form-check-label" for="primaryPre'+this.i+'"> Set Default </label>';
                        Html +='</div>';
                    Html +='</div>';
                    $( $.parseHTML(Html) ).appendTo(placeToInsertImagePreview);
                };
                reader.readAsDataURL(input.files[A]);
            }
        }else{
            alert('You can only upload up to 10 images.');
            $('#gallery-photo-add').val('');
        }
    }
};
$('#gallery-photo-add').on('change', function() {
    $('.prechoosimg').remove();
    imagesPreview(this, 'div.imgPreviewBox');
});

$(document).on("change", "#video", function(evt) {
    var $source = $('#video_here');
    $source[0].src = URL.createObjectURL(this.files[0]);
    $source.parent()[0].load();
});

function getCategoryTags(preCategoryId){
    const Url = CategoryTags;
    const getResponse = ajaxUrl(Url, 'Post', {
        category: preCategoryId,
        _token: $('meta[name=csrf-token]').attr('content')
    });
    getResponse.done(function(json) {
        let Html = '';
        Html += '<label class="form-label" for="country">Tags</label>';
        Html += '<select id="tags" class="select2 form-select" name="tags[]" multiple>';
        Html += '<option value="">Select Tags</option>';
        json?.forEach((items) => {
            let selected = '';
            Html += '<option value="' + items?.id + '" >' + items?.title +'</option>';
        });
        Html += '</select>';
        $('.tagBoxHere').html(Html);
        $('.select2').select2();
        if(json.length>0){
            $('.tagBoxHere').show();
        }else{
            $('.tagBoxHere').hide();
        }
        
    });
}

function postAjaxForm(Url,Method,formData){
    return $.ajax({
        url: Url,
        dataType: "Json",
        method: Method,
        data: formData,
        processData: false,
        contentType: false
    });
}