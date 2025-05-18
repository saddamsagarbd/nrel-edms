$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function printErrorMsg(msg) {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-right"
    };
    var error_html = '';
    for (var count = 0; count < msg.length; count++) {
        error_html += '<p>' + msg[count] + '</p>';
    }
    toastr.error(error_html);
}
function printSuccessMsg(msg) {
    toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "positionClass": "toast-top-right"
    };
    toastr.success(msg);
}
function uuidv4() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

$(document).on('click', '.modal', function (e) {
    if ($(e.target).hasClass('modal')) {
        e.stopPropagation();  // Prevent closing the modal if clicking on it
    }
});

// $('#myModal').on('mousedown', function (e) {
$(document).on('mousedown', '.modal', function (e) {
    console.log("drag");
    e.stopPropagation();
});
$(document).on('hide.bs.modal', '.modal', function (e) {
    if ($(document).find('.select2-container--open').length) {
        e.preventDefault();  // Prevent the modal from closing if the Select2 dropdown is open
    }
});

// $("#resetCriteria").hide();

$(document).on("click", "#resetCriteria", function(){
    location.reload();
});



