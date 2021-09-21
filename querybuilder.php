<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CodePen - jQuery Query Builder</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/jquery.query-builder/2.3.3/css/query-builder.default.min.css'>

</head>

<body>
    <!-- partial:index.partial.html -->
    <html>

    <head>
        <title></title>
    </head>

    <body>
        <div id="selectcolumn"></div>
        <div id="builder"></div>
        <button class="btn btn-success" id="btn-set">Set Rules</button>
        <button class="btn btn-primary" id="btn-get">Get Rules</button>
        <button class="btn btn-warning" id="btn-reset">Reset</button>
    </body>

    </html>
    <!-- partial -->
    <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/jQuery-QueryBuilder/dist/js/query-builder.standalone.min.js'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
    <script>
        $(document).ready(() => {
            var db = '<?php echo $_GET['db']; ?>'
            var table = '<?php echo $_GET['table']; ?>';

            $.post('./ajax/ajax.php', {
                method: 'tableColumn',
                db: db,
                table: table
            }, (res) => {
                res = JSON.parse(res);
                tableColumn(res);
            });

            function tableColumn(res) {
                // console.log(res);
                $('#selectcolumn').html('');

                $.each(res, (k, v) => {
                    $('#selectcolumn').append(`<div class="form-check"><input type="checkbox" name="column[]" checked="checked" value="${v.id}" class="form-check-input"> ${v.id}</div>`);
                });

                var rules_basic;

                $('#builder').queryBuilder({
                    plugins: ['bt-tooltip-errors'],

                    filters: res,
                    rules: rules_basic
                });
                /****************************************************************
                            Triggers and Changers QueryBuilder
                *****************************************************************/

                $('#btn-get').on('click', function() {
                    var result = $('#builder').queryBuilder('getSQL', 'question_mark');
                    var column = new Array();
                    $("input[name='column[]']:checked").each(function() {
                        column.push($(this).val());
                    });

                    result.column = column;

                    // console.log(result);

                    if (!$.isEmptyObject(result)) {
                        // $('#queryBlock').html(JSON.stringify(result, null, 2));
                        window.top.postMessage(JSON.stringify(result, null, 2), '*');
                    } else {
                        console.log("invalid object :");
                    }
                    // console.log(result);
                });

                $('#btn-reset').on('click', function() {
                    $('#builder').queryBuilder('reset');
                });

                $('#btn-set').on('click', function() {
                    //$('#builder').queryBuilder('setRules', rules_basic);
                    var result = $('#builder').queryBuilder('getSQL', 'question_mark');
                    if (!$.isEmptyObject(result)) {
                        rules_basic = result;
                    }
                });

                //When rules changed :
                $('#builder').on('getRules.queryBuilder.filter', function(e) {
                    //$log.info(e.value);
                });


            }

        });
    </script>

</body>

</html>

<!-- {
                        id: 'name',
                        label: 'Name',
                        type: 'string'
                    }, {
                        id: 'category',
                        label: 'Category',
                        type: 'integer',
                        input: 'select',
                        values: {
                            1: 'Books',
                            2: 'Movies',
                            3: 'Music',
                            4: 'Tools',
                            5: 'Goodies',
                            6: 'Clothes'
                        },
                        operators: ['equal', 'not_equal', 'in', 'not_in', 'is_null', 'is_not_null']
                    }, {
                        id: 'in_stock',
                        label: 'In stock',
                        type: 'integer',
                        input: 'radio',
                        values: {
                            1: 'Yes',
                            0: 'No'
                        },
                        operators: ['equal']
                    }, {
                        id: 'price',
                        label: 'Price',
                        type: 'double',
                        validation: {
                            min: 0,
                            step: 0.01
                        }
                    }, {
                        id: 'id',
                        label: 'Identifier',
                        type: 'string',
                        placeholder: '____-____-____',
                        operators: ['equal', 'not_equal'],
                        validation: {
                            format: /^.{4}-.{4}-.{4}$/
                        }
                    } -->