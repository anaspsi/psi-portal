<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.122.0">
    <title>Portal · PSI</title>

    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <meta name="theme-color" content="#712cf9">


    <style>
        html,
        body {
            height: 100%;
        }

        .form-signin {
            max-width: 330px;
            padding: 1rem;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }

        /*  */
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="sign-in.css" rel="stylesheet">
</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto">
        <form>
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="email" class="form-control" id="inputUserid" placeholder="name@example.com">
                <label for="inputUserid">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="inputPassword" placeholder="Password">
                <label for="inputPassword">Password</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit" onclick="btnLogin_eClick(event)">Sign in</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
        </form>
    </main>
    <script src="{{ url('assets/jquery/jquery.min.js') }} "></script>
    <script src="{{ url('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

</body>
<script>
    function btnLogin_eClick(e) {
        e.preventDefault()
        if (inputUserid.value.length <= 3) {
            inputUserid.focus()
            return
        }
        if (inputPassword.value.length <= 5) {
            inputPassword.focus()
            return
        }
        const data = {
            inputUserid: inputUserid.value,
            inputPassword: inputPassword.value,
            _token: '{{ csrf_token() }}',
        }
        e.target.disabled = true
        $.ajax({
            type: "POST",
            url: "{{route('actionlogin')}}",
            data: data,
            dataType: "json",
            success: function(response) {
                e.target.disabled = false
                if (!response.tokennya) {
                    alert(response.message)
                    inputUserid.value = ''
                    inputPassword.value = ''
                    $("#ln2").hide('slow', function() {
                        $("#ln1").show();
                        $("#inputUserid").focus();
                        $("#inputUserid").select();
                    });
                } else {
                    console.log(response)
                    sessionStorage.setItem('tokenGue', response.tokennya)
                    location.href = 'home'
                }
            },
            error: function(xhr, xopt, xthrow) {
                alert(xthrow)
                e.target.disabled = false
            }
        });
    }
    $("#lnwarning").hide();
    $("#ln2").hide();
    $("#inputUserid").keypress(function(e) {
        if (e.key === 'Enter') {
            if ($(this).val() != "") {
                $("#ln1").slideUp('slow', function() {
                    $("#ln2").show();
                    $("#inputPassword").focus();
                });
            } else {
                $("#lnwarning").show();
            }
            e.preventDefault();
        }
    });
    $("#inputUserid").keydown(function(e) {
        $("#lnwarning").hide();
    });
    $("#btnback").click(function(e) {
        e.preventDefault();
        $("#ln2").hide('slow', function() {
            $("#ln1").show();
            $("#inputUserid").focus();
            $("#inputUserid").select();
        });
    });
    $("#btnnext").click(function(e) {
        if ($("#inputUserid").val() != "") {
            $("#ln1").slideUp('slow', function() {
                $("#ln2").show();
                $("#inputPassword").focus();
            });
        } else {
            $("#lnwarning").show();
        }
    });
</script>

</html>