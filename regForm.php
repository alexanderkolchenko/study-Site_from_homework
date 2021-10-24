<?php
//session_start();
require 'reg.php';
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!DOCTYPE html>

<style>
    .none2 {
        text-align: center;
        display: none;
    }
</style>

<body>

    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <!-- login -->
        <div class="row mb-3">
            <label for="exampleInputLogin" class=" col-sm-2 col-form-label">Логин</label>
            <div class="col-sm-10">
                <input type="text" name="login" class=" col-sm-10 form-control" id="exampleInputLogin">
            </div>
        </div>

        <!-- email -->
        <div class="row mb-3">
            <label for="exampleInputEmail2" class=" col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" id="exampleInputEmail2" name="email" class="col-sm-10 form-control">
            </div>
        </div>

        <!-- password -->
        <div class="row mb-3">
            <label for="exampleInputPass1" class=" col-sm-2 form-label">Пароль</label>
            <div class="col-sm-10">
                <input type="password" id="password" name="password" class=" col-sm-10 form-control" aria-describedby="emailHelp1">
            </div>
            <p id="passproof" class="text-danger"></p>
        </div>
        <div class="row mb-3">
            <label for="exampleInputPass2" class=" col-sm-2 form-label">Повторите пароль</label>
            <div class="col-sm-10">
                <input type="password" id="password2" name="password_check" class=" col-sm-10 form-control" aria-describedby="emailHelp2">
            </div>

        </div>

        <button id="btn" type="submit" class="btn-r btn btn-sm btn-primary">Зарегистрироваться</button>
        <div id="msg1" class=" mb-3 border-0 alert p-0 px-3 fs-6 my-2 alert-danger none2" role="alert">
        </div>

    </form>

</body>

<script>
    $('.btn-r').click(function(e) {

        var password = $('#password').val();
        var login = $('input[name="login"]').val();
        var password2 = $('#password2').val();
        var emailReg = $('#exampleInputEmail2').val();

        if (password2 !== password) {
            document.getElementById('passproof').innerHTML = "Пароли не совпадают";
            e.preventDefault();
        } else {
            document.getElementById('passproof').innerHTML = "";
            e.preventDefault();
            $.ajax({
                url: 'reg.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    email: emailReg,
                    password: password,
                    login: login,
                },

                success(data) {
                    if (data.status) {
                        document.location = 'index.php';
                    } else {
                        $('#msg1').removeClass('none2').text(data["message"]);
                    }
                }

            });
        }

    })
</script>