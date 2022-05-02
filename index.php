<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>PHP-AJAX-CRUD</title>
</head>

<body>

    <h2 class="text-center my-3 mb-3 " id="heading">PHP - AJAX - CRUD</h2>
    <hr>

    <div class="container">
        <div class="row my-5 py-3">
            <div class="col-sm-12">
                <form onsubmit="return false;">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="name" placeholder="Name" id="name">
                        </div>
                        <div class="col">
                            <input type="email" class="form-control" name="email" placeholder="Email" id="email">
                        </div>
                        <div class="col">
                            <input type="number" class="form-control" name="phone" placeholder="Phone" id="phone">
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-submit btn-primary">Submit</button>
                            <button type="button" class="btn btn-cancel btn-secondary">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-sm-12">
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Acions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {

            getData();

            setInterval(function() {
                var x = document.getElementById("heading");
                x.style.color = x.style.color == "blue" ? "red" : "blue";
            }, 1000);

            function getData() {
                $.ajax({
                    url: "process.php",
                    data: {action: 'read'},
                    method: "POST",
                }).done(function(data) {
                    $(".table").find("tr:gt(0)").remove();
                    arr = $.parseJSON(data); //convert to javascript array
                    $.each(arr, function(key, value) {
                        row = '<tr><td>' + (key + 1) + '</td><td>' + value.name + '</td><td>' + value.email + '</td><td>' + value.phone + '</td><td><button data-attribute=' + value.id + ' class="btn btn-danger btn-sm delete-btn" title="delete">D</button><button data-attribute=' + value.id + ' class="btn btn-primary btn-sm edit-btn ms-2" title="edit">E</button></td></tr>';
                        $('.table').append(row);
                    });
                }).fail(function(xhr) {
                    console.log(xhr.statusText + xhr.responseText);
                });
            }

            $(document).on('click', '.delete-btn', function() {
                if (confirm('Are u sure, you want to delete the item ??')) {
                    id = $(this).attr('data-attribute');
                    $.ajax({
                        url: "process.php",
                        data: {action: 'delete',id: id,},
                        method: "POST",
                    }).done(function(data) {
                        getData();
                    }).fail(function(xhr) {
                        console.log(xhr.statusText + xhr.responseText);
                    });
                } else {

                }
            });

            $(document).on('click', '.edit-btn', function() {
                id = $(this).attr('data-attribute');
                $.ajax({
                    url: "process.php",
                    data: {action: 'edit',id: id,},
                    method: "POST",
                }).done(function(data) {
                    arr = $.parseJSON(data);
                    $('#id').val(arr.id);
                    $('#name').val(arr.name);
                    $('#email').val(arr.email);
                    $('#phone').val(arr.phone);
                    $(".btn-submit").text('update')
                }).fail(function(xhr) {
                    console.log(xhr.statusText + xhr.responseText);
                });
            });

            $(".btn-submit").click(function() {
                var id = $('#id').val();
                var name = $('#name').val();
                var email = $('#email').val();
                var phone = $('#phone').val();
                if (id == '') {
                    $.ajax({
                        url: "process.php",
                        data: {action: 'create',name: name,email: email,phone: phone},
                        method: "POST",
                    }).done(function(data) {
                        getData();
                    }).fail(function(xhr) {
                        console.log(xhr.statusText + xhr.responseText);
                    });
                } else {
                    $.ajax({
                        url: "process.php",
                        data: {action: 'update',id: id,name: name,email: email,phone: phone},
                        method: "POST",
                    }).done(function(data) {
                        getData();
                    }).fail(function(xhr) {
                        console.log(xhr.statusText + xhr.responseText);
                    });
                }
            });

            $('.btn-cancel').click(function(){
                $(':input').val('')
                $(".btn-submit").text('submit')
            })
        });
    </script>
</body>

</html>