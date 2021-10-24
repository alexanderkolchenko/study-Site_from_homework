<?php
//session_start();
require "autoriz.php";


?>
<style>
    .none1 {
        text-align: center;
        display: none;
    }
</style>

<!DOCTYPE html>

<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="  form-label">Email</label>
            <input type="email" name="email" required class=" error form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Пароль</label>
            <input type="password" name="password" required class=" error form-control" id="exampleInputPassword1">
        </div>
        <button type="submit" class=" btn-reg btn btn-sm btn-primary">Войти</button>
        <div id="msg" class=" mb-3 border-0 alert p-0 px-3 fs-6 my-2 alert-danger none1" role="alert">
        </div>

    </form>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $('.btn-reg').click(function(e) {
        e.preventDefault();

        let lemail = $('input[name="email"]').val();
        let lpassword = $('input[name="password"]').val();

        $.ajax({
            url: 'autoriz.php',
            type: 'POST',
            dataType: 'json',
            data: {
                email: lemail,
                password: lpassword,
            },
            success(data) {

                if (data.status) {
                    document.location = 'index.php';
                } else {
                    $('#msg').removeClass('none1').text(data["message"]);
                    if (data.type === 1) {

                    }
                }
            }
        });
    })
</script>