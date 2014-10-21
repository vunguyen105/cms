<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/icon" href="<?=base_url('asset/base/img/favicon.ico')?>"/>
    <script src="<?=base_url()?>asset/base/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?=base_url()?>asset/base/js/jquery-1.9.1.min.js"></script>
    <link href="<?=base_url('asset/themes/' . CURRENT_THEME)?>/css/modern.css" rel="stylesheet">
    <link href="<?=base_url('asset/themes/' . CURRENT_THEME)?>/css/theme-dark.css" rel="stylesheet">

    <style type="text/css">
        .metrouicss {
            background-color: #4A0093;
        }

        #pwordbox {
            position: absolute;
            height: 100px;
            width: 100px;
            left: 50%;
            top: 35%;
            transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
        }

        #imgcont {
            position: absolute;
            left: -175%;
            top: 50%;
            transform: translate(-50%, -10%);
            -webkit-transform: translate(-50%, -10%);
            -moz-transform: translate(-50%, -10%);
            -ms-transform: translate(-50%, -10%);
        }

        #pboxcont {
            position: absolute;
            left: 0%;
            top: 100%;
            /*
            transform: translate(-50%, -10%);
            -webkit-transform: translate(-50%, -10%);
            -moz-transform: translate(-50%, -10%);
            -ms-transform: translate(-50%, -10%);
            */
        }

        #pwordhint {
            color: #E86C19;
            font-size: 17.5px;
        }
    </style>
</head>
<body class="metrouicss">
<div id="pwordbox">
    <div id="imgcont">
        <img src="<?=base_url('asset/themes/'.CURRENT_THEME.'/images/win8.png')?>"/>
    </div>
    <div id="fieldcont">
        <div id="pboxcont">
            <h1 style="color:white;">Login</h1>

            <div class="input-control password span4" id="pworddiv">
                <form class="form-4" method="POST" action="<?=base_url('home/do_login')?>">

                    <div class="input-control text">
                        <input type="text"  name='txtUsername' />
                        <button class="btn-clear"></button>
                    </div>
                    <div class="input-control password">
                        <input type="password" name='txtPassword' />
                        <button class="btn-reveal"></button>
                    </div>

                    <input type="submit" name="submit" value="Login">
                    <input type="button" value="Support"/>
                </form>
            </div>
            <div id="pwordhint">
                Hint: <?if ((isset($error)) && $error != '') {
                echo '<span id="error">' . $error . '</span>';
            }?>
            </div>
        </div>
    </div>
</body>
</html>

