// Stops 'Are you sure you want to resubmit form?'
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

$(document).ready(function() {
    $(document).on('change', '#photo_upload', function() {
        // Bind the FormData object and the form element
        const FD = new FormData($('#image_select_container')[0]);

        $.ajax({
            url: "http://localhost:8000/php/load_image.php",
            type: "POST",
            data: FD,
            success: function(res) {
                if (res == "N/A") return;
                var container = $("#image_select_container")
                if (!container.find("label").hasClass("hide")) {
                    container.find("label").addClass("hide");
                    container.append(`<img src=\"../imgs/${res}\"/>`)
                    container.addClass('content');
                    container.find("img").on("click", function() {
                        container.find("label").trigger('click');
                    });
                } else {
                    container.find("img").attr('src', `../imgs/${res}?t=${new Date().getTime()}`);

                    // Finding the input with the type of 'file' to remove it.
                    let otherInputs = container.parent().find("form").last().find("input");
                    let otherFileInput;
                    for (let i = 0; i < otherInputs.length; i++) {
                        if (otherInputs[i].type == 'file') {
                            otherFileInput = $(otherInputs[i]);
                        }
                    }

                    otherFileInput.remove();
                }

                // Finding the input with the type of 'file'
                let inputs = container.find("input");
                var fileInput;
                for (let i = 0; i < inputs.length; i++) {
                    if (inputs[i].type == 'file') {
                        fileInput = $(inputs[i]);
                    }
                }

                var clone = fileInput.clone();
                clone.appendTo(container.parent().find("form").last());
                clone.addClass('hide');
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Gets rid of drop downs if user clicks elsewhere
    $(document).on("click", function(e) {
        if (e.target.id != "account" && e.target.parentNode.id != "account") {
            $("#userDropdown").addClass('hide');
        }
        if (!$(e.target).hasClass("sort")) {
            $("#sortByDropdown").addClass('hide');
        }
    });

    $('#latest').click(function() {
        $('#latest').parent()
            .find('.selected')
            .removeClass('selected')
            .find("img")
            .remove();
        $('#latest').addClass('selected');

        $('#latest').prepend("<img src=\"../imgs/tick.png\" class=\"marker sort\">");

        $.ajax({
            method: "POST",
            url: "php/fetch_posts.php",
            success: function(res) {
                $('#posts').empty();
                $('#posts').append(res);
                $("#sortOpenBtn").html("Latest");
            },
            data: { s: 'l' }
        })
    });

    $('#rating').click(function() {
        $('#rating').parent()
            .find('.selected')
            .removeClass('selected')
            .find("img")
            .remove();
        $('#rating').addClass('selected');

        $('#rating').prepend("<img src=\"../imgs/tick.png\" class=\"marker sort\">");

        $.ajax({
            method: "POST",
            url: "php/fetch_posts.php",
            success: function(res) {
                $('#posts').empty();
                $('#posts').append(res);
                $("#sortOpenBtn").html("Rating");
            },
            data: { s: 'r' }
        })
    });
});

function toggleUserDropdown() {
    $("#userDropdown").toggleClass("hide");
}

function toggleSortDropdown() {
    $("#sortByDropdown").toggleClass("hide");
}

function up(btn, id) {
    $.ajax({
        method: "POST",
        url: "php/vote.php",
        success: function(res) {
            $(btn).parent().find("p").text(res);
        },
        data: { post: id, val: 1 }
    })
}

function down(btn, id) {
    $.ajax({
        method: "POST",
        url: "php/vote.php",
        success: function(res) {
            $(btn).parent().find("p").text(res);
        },
        data: { post: id, val: 0 }
    })
}

// For programming