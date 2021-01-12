<html>
<head>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
</head>
<body>
    <button onclick="getToken();">Get Token</button>

    <div id="tokenData" >
    
    </div>

    <div style="display: none;" id="notLoggedin">
        <h3>You are not logged in!</h3>
        <a href="login.php">Logg in</a>
    </div>

    <script>
        var getToken = () => {
            $.ajax({
                method: 'POST',
                url: "/api/auth.php",
                data: {
                        grant_type : "password",
                        client_id : 'testclient',
                        client_secret : 'testpass',
                },
                success: (data) => {
                    console.log(data);
                    $('#tokenData').html(data.access_token);
                },
                error: (err) => {
                    if(err.status == 401) {
                        $('#notLoggedin').css('display', 'inline');
                    }
                }
            });
        }
    </script>
</body>
</html>