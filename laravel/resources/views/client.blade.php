<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        Test Pawooon - Client
        <table>
            <tr>
                <td>Hash</td> <td><input type="text" disabled="" name="uuid" /></td>
            </tr>
            <tr>
                <td>Nama</td> <td><input type="text" name="nama"/></td>
            </tr>
            <tr>
                <td>Alamat</td> <td><input type="text" name="alamat"/></td>
            </tr>
            <tr>
                <td colspan="2"><button class="submit">Submit</button></td>
            </tr>
        </table>

        Daftar User
        <table class="table-result" border="1">
            <tr>
                <td>ID Customer</td><td>Nama</td><td>Alamat</td>
            </tr>
        </table>
        <button class="refresh">Refresh</button>
    </body>
    <footer>
        <script type="text/javascript">
        var timeout;
        var error = false;
        
        function makeid()
        {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

            for( var i=0; i < 50; i++ )
                text += possible.charAt(Math.floor(Math.random() * possible.length));

            $('input[name=uuid]').val(text);
        }
        
        function loadUser ()
        {
            $.get('/load', function(result) {
            console.log(result)
            for (var i = 0; i < result.length; i++) {
                $('.table-result').append('<tr><td>'+result[i].uuid+'</td><td>'+result[i].nama+'</td><td>'+result[i].alamat+'</td></tr>');
            };
            }.bind(this));
        }
        
        loadUser()
        makeid();        

        $('input[name=nama]').on('input',function(e){
            clearTimeout(timeout)
            timeout = setTimeout(function(){
                $.ajax
                ({
                    type: "POST",
                    url: '/check-name',
                    data: { name : $('input[name=nama]').val() },
                    success : function(res) {
                        if(res == 1) {
                            alert('Name already exist');
                            error = true;
                            $('input[name=nama]').val('');
                        } else {
                            error = false;  
                        }
                    },
                    error : function() {

                    }
                })
            },1000)
            check = false;
        });

        $('.submit').on('click',function(){
            if (!error && $('input[name=nama]').val() != '' && $('input[name=nama]').val() != null && $('input[name=nama]').val() != undefined && $('input[name=alamat]').val() != '' && $('input[name=alamat]').val() != null && $('input[name=alamat]').val() != undefined) {
                var user = {
                    uuid: $('input[name=uuid]').val(),
                    nama: $('input[name=nama]').val(),
                    alamat: $('input[name=alamat]').val()
                }

                $.ajax
                ({
                    type: "POST",
                    url: '/add',
                    data: { user : user },
                    success : function() {
                        $('.table-result').append('<tr><td>'+user.uuid+'</td><td>'+user.nama+'</td><td>'+user.alamat+'</td></tr>');
                        makeid();
                        $('input[name=nama]').val('');
                        $('input[name=alamat]').val('');
                    },
                    error : function() {
                        alert('Failed , please try again');
                        makeid();
                    }
                })
            } else {
                alert('Please full fill data.')
            }
        })

        $('.refresh').on('click',function(){
            $('.table-result').empty();
            $('.table-result').append('<tr><td>ID Customer</td><td>Nama</td><td>Alamat</td></tr>');
            loadUser();
        })

        </script>
    </footer>
</html>
