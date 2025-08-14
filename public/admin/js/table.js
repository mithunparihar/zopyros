let table = "";
function generateTable() {
    let  saveState = false;
    if(localStorage?.getItem('paginateState')=='true'){
        saveState=true;
    }
    table = $("#datatable1").DataTable({
        ajax: tableListUrl,
        searching: searching,
        paging: true,
        ordering:false,
        stateSave: true,
        processing: true,
        aaSorting: [[0, "asc"]],
        columns: columns,
        // pageLength: 15,
        serverSide:serverSide,
        language: {
            searchPlaceholder: "Search Records",
        },
        stateSaveParams: function (settings, data) {
            data.search.search = '';
            if(saveState==false){
                data.start = 0;
            }
        },
        stateLoadParams:function (settings, data){
        },
        createdRow: function(row, data, dataIndex) {
            // Add the class from the row_class data
            $(row).addClass(data.row_class);
        }
    });
    table.on('page.dt',function () {
        localStorage.clear();
        localStorage.setItem('paginateState',true);
    });
    table.on("draw", function () {
        sequenceTable();
    });
    // table.state.clear();
}


$("#checkAll").change(function () {
    $(".dt-checkboxes[type=checkbox]").prop('checked', $(this).prop("checked"));
});


$(document).on("click", "[data-delete-id]", function (e) {
    if (confirm("If you remove this record, all the data associated with it will also be deleted.")) {
        $.ajax({
            url: removeRecordUrl,
            dataType: "Json",
            method: "Post",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: $(this).attr("data-delete-id"),
            },
            success: (res) => {
                $(this).parent("div").remove();
                var event = new Event("deletedRecords");
                dispatchEvent(event);
                table?.ajax?.reload();
            },
            error: (err) => {
                var evt = new CustomEvent("errortoaster", {
                    detail: [
                        {
                            title: "Sorry!",
                            message: err?.responseJSON?.message,
                        },
                    ],
                });
                window.dispatchEvent(evt);
            },
        });
    } else {
        return false;
    }
});

$(document).on("click", "[data-publish]", function (e) {
    let status = "";
    let publish = 0;

    let statusType = $(this).attr('data-type');
    let confirmationMsg = "";

    if ($(this).prop("checked") == true) {
        status = "publish";
        confirmationMsg = "Are you sure! You want to " + status + " this record?";
        if(statusType=='featured'){ confirmationMsg = 'Are you sure you want to mark this data as featured?' }
        if(statusType=='sell'){ confirmationMsg = 'Please confirm if you`d like to move forward with selling this lead. Once confirmed, the sale will be processed and cannot be undone.' }
        publish = 1;
    } else {
        status = "un-publish";
        confirmationMsg = "Are you sure! You want to " + status + " this record?";
        if(statusType=='featured'){ confirmationMsg = 'Are you sure you want to unmark this data as featured?' }
        if(statusType=='sell'){ confirmationMsg = 'Are you sure you want to unmark this data as featured?' }
        publish = 0;
    }

    if (confirm(confirmationMsg)) {
        $.ajax({
            url: $(this).attr("data-publish"),
            dataType: "Json",
            method: "Post",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: $(this).attr("value"),
                publish: publish,
            },
            success: (res) => {
                table.ajax.reload(null, false);
                Livewire.dispatch(["freeItemLeftBarRefresh"]);
            },
            error: (err) => {
                var evt = new CustomEvent("errortoaster", {
                    detail: [
                        {
                            title: "Sorry!",
                            message: err?.responseJSON?.message,
                        },
                    ],
                });
                window.dispatchEvent(evt);
                $(this).prop(
                    "checked",
                    $(this).prop("checked") == true ? false : true
                );
            },
        });
    } else {
        return false;
    }
});

$(document).on("click", "[data-publish2]", function (e) {
    let status = "";
    if ($(this).prop("checked") == true) {
        status = "set";
    } else {
        status = "un-set";
    }
    if (confirm("Are you sure! You want to " + status + " this record?")) {
        $.ajax({
            url: publichUrl2,
            dataType: "Json",
            method: "Post",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                id: $(this).attr("data-publish2"),
                publish: $(this).prop("checked"),
            },
            success: (res) => {

                table.ajax.reload(null, false);
                Livewire.dispatch(["freeItemLeftBarRefresh"]);
            },
            error: (err) => {},
        });
    } else {
        return false;
    }
});

function ajaxForm(updateUrl, formdata, method, formId) {
    $(formId + " .error").html("");
    $(formId + " .sbtn").hide();
    $(formId + " .pbtn").show();
    $.ajax({
        url: updateUrl,
        dataType: "Json",
        method: method,
        data: formdata,
        processData: false,
        contentType: false,
        success: (res) => {
            table?.ajax?.reload();
            $(formId).trigger("reset");
            $(formId + " .sbtn").show();
            $(formId + " .pbtn").hide();
            var event = new CustomEvent("successtoaster", {
                detail: { 0: { title: res?.title, message: res?.message } },
            });
            dispatchEvent(event);
        },
        error: (err) => {
            let Errors = err?.responseJSON?.errors;
            Object.keys(Errors).forEach((key) => {
                $(formId + " ." + key + "Err").html(Errors[key]);
            });
            $(formId + " .sbtn").show();
            $(formId + " .pbtn").hide();
        },
    });
}

function ajaxUrl(Url, method, data) {
    return $.ajax({
        url: Url,
        dataType: "Json",
        method: method,
        data: data,
        success: (res) => {
            return res;
        },
        error: (err) => {
            let Errors = err?.responseJSON?.errors;
            return Errors;
        },
    });
}

function sequenceTable() {
    $(".sequenceForm").on("submit", function (e) {
        const formId = $(this).attr("id");
        e.preventDefault();
        const formData = new FormData(this);
        formData.append("_token", $("meta[name=csrf-token]").attr("content"));
        const Url = sequenceUrl;
        $.ajax({
            url: Url,
            dataType: "Json",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: (res) => {
                var event = new CustomEvent("successtoaster", {
                    detail: { 0: { title: res?.title, message: res?.message } },
                });
                dispatchEvent(event);
                table?.ajax?.reload();
                $("#" + formId + " .Err").html("");
            },
            error: (err) => {
                let Errors = err?.responseJSON?.errors;
                Object.keys(Errors).forEach((key) => {
                    $("#" + formId + " .Err").html(Errors[key][0]);
                });
            },
        });
    });
}
