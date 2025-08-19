function confirmation($message) {
    if (confirm($message)) {
        return true;
    }
    return false;
}
window.addEventListener('showdeleteconfirmation', event => {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to remove this! ",
        icon: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            confirmButton: "btn btn-dark me-3",
            cancelButton: "btn btn-label-danger"
        },
        buttonsStyling: !1
    }).then(function (t) {
        if (t.value) {
            deleteConfirmation(event.detail.Id);
        }
    });
});

window.addEventListener('deletedRecords', event => {
    Swal.fire({
        icon: "success",
        title: "Deleted!",
        text: "Your record has been deleted.",
        customClass: {
            confirmButton: "btn btn-dark"
        }
    });
    // swsConfirm();
});

window.addEventListener('successtoaster', event => {
    $('.offcanvas').offcanvas('hide');
    $('.modal').modal('hide');
    Swal.fire({
        icon: "success",
        title: event.detail[0].title,
        text: event.detail[0].message,
        customClass: {
            confirmButton: "btn btn-dark"
        }
    });
    // swsConfirm();
});
window.addEventListener('errortoaster', event => {
    Swal.fire({
        icon: "error",
        title: event.detail[0].title,
        text: event.detail[0].message,
        customClass: {
            confirmButton: "btn btn-danger"
        }
    });
});

window.addEventListener('emptyEditor', event => {
    document.querySelectorAll('.summernote').forEach(editor => {
        $(editor).summernote('code', '');
    });
});
