$(".onlyAplha").on("keydown", function (event) {
    let value = event.value;
    value = value.replace(/\s+/g, " ").trim();
    event.value = value;
    return /[a-z A-Z]/i.test(event.key);
});

$(".onlyEmail").on("keydown", function (event) {
    return /[a-zA-z0-9@_.-]/i.test(event.key);
});

$(".onlyNumber").on("keypress", function (event) {
    return event.charCode >= 48 && event.charCode <= 57;
});

$(".otherValidation").on("keyup", function (event) {
    let string = event.target.value;
    var reg = new RegExp("^\\d+$");
    var test = reg.test(string);
    // $(".OthErr").remove();
    // $(this)
    //   .parent("div")
    //   .parent("form")
    //   .find("button[name=submit]")
    //   .removeClass("disabled");

    // if (string.length > 1) {
    //   var regex = /^[^a-zA-Z0-9]+$/;
    //   var matchedAuthors = regex.test(string);
    //   if (matchedAuthors == true) {
    //     // $(this).after(
    //     //   '<small class="error text-danger d-block OthErr">You can`t add wrong format in this field.</small>'
    //     // );
    //     // $(this)
    //     //   .parent("div")
    //     //   .parent("form")
    //     //   .find("button[name=submit]")
    //     //   .addClass("disabled");
    //   } else if (test == true) {
    //     $(this).after(
    //       // '<small class="error text-danger d-block OthErr">The numeric value are not accepted.</small>'
    //     );
    //     // $(this)
    //     //   .parent("div")
    //     //   .parent("form")
    //     //   .find("button[name=submit]")
    //     //   .addClass("disabled");
    //   }
    // }

    // event.target.value = event.target.value.replace(
    //   /(\b\S+\b)(($|\s+)\1)+/g,
    //   "$1"
    // );
    // event.target.value = event.target.value.replace("  ", " ").trimStart();
});

function removeExtraSpaces(str) {
    return str.replace(/\s+/g, " ").trim();
}

$(".pastNone").on("paste", function (e) {
    e.preventDefault();
    return false;
});
$(".copyNone").on("copy", function (e) {
    e.preventDefault();
    return false;
});
$(".cutNone").on("cut", function (e) {
    e.preventDefault();
    return false;
});
