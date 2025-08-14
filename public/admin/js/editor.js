$(document).ready(function () {
    $(".summernote").each(function () {
        let editorId = $(this).attr("id");

        let wireModel = $(this).attr("wire:model");
        $(this).summernote({
            placeholder: "Write something here...",
            cleanPaste: true,
            callbacks: {
                onChange: function (contents, $editable2) {
                    contents = contents.replace(
                        /<script.*?>.*?<\/script>/g,
                        ""
                    );
                    contents = contents.replace(/<p><br><\/p>/g, "");

                    contents = contents.replace(/<style.*?>.*?<\/style>/g, "");
                    contents = contents.replace(
                        /<iframe.*?>.*?<\/iframe>/g,
                        ""
                    );
                    Livewire.dispatch("updateEditorValue", {
                        modelId: wireModel,
                        content: contents,
                    });
                },
                onImageUpload: function (files, editor, welEditable) {
                    sendFile(files[0], editorId);
                },
                onInit: function () {
                    cleanEmptyParagraphs(editorId);
                },
                onKeyup: function (e) {
                    cleanEmptyParagraphs(editorId);
                },
            },
        });
    });
});

function sendFile(file, editorBox) {
    data = new FormData();
    data.append("file", file);
    data.append("_token", XCSRF_Token);
    $.ajax({
        data: data,
        type: "POST",
        url: CkeditorImageUpload,
        cache: false,
        contentType: false,
        processData: false,
        success: function (url) {
            var image = $("<img>").attr("src", url?.url);
            $("#" + editorBox).summernote("insertNode", image[0]);
        },
    });
}

function cleanEmptyParagraphs(editorId) {
    var content = $("#" + editorId).summernote("code");
    var cleanedContent = $(content)
        .find("p")
        .filter(function () {
            return $(this).text().trim() === "";
        })
        .remove()
        .end()
        .html();
}
