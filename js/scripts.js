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
            alert(res);
        });
    });

    $('#startproject').click(() => {
        $.post('ajax/createproject.php', { name: $('#projectname').val() }, () => {

        });
    });
});