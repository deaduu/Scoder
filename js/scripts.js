$(document).ready(() => {
    $.post('ajax/ajax.php', { method: 'checkConnection' }, (res) => {
        res = JSON.parse(res);

        if (res == false) {
            $('#dbModal').modal('toggle');
        }
    });

    $('#dbform').submit((e) => {
        e.preventDefault();
        $.post('ajax/ajax.php', $('#dbform').serializeArray(), (res) => {
            res = JSON.parse(res);
            if (res) {
                $('#dbModal').modal('toggle');
            } else {
                alert('Something went wrong');
            }
        });
    });

    $('#startproject').click(() => {
        $.post('ajax/createproject.php', { name: $('#projectname').val() }, () => {

        });
    });
});